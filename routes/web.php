<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect('/dashboard')
            : redirect('/home');
    }
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return auth()->user()->role === 'admin'
            ? redirect('/dashboard')
            : redirect('/home');
    }

    return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
});

Route::post('/register', function (Request $request) {
    $request->validate([
        'nama'     => 'required|string|max:100',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    \App\Models\User::create([
        'nama'     => $request->nama,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
        'role'     => 'pelanggan',
    ]);

    return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});

Route::get('/dashboard', function () {
    $stats = [
        'total_pelanggan'  => \App\Models\User::where('role', 'pelanggan')->count(),
        'total_menu'       => \App\Models\Menu::count(),
        'total_pesanan'    => \App\Models\Order::count(),
        'total_pendapatan' => \App\Models\Order::where('status', 'selesai')->sum('total_harga'),
    ];
    $pesanan_terbaru = \App\Models\Order::with('user')->latest()->take(5)->get();
    $menu_terlaris   = \App\Models\Menu::take(5)->get();

    return view('dashboard.index', compact('stats', 'pesanan_terbaru', 'menu_terlaris'));
})->middleware(['auth', 'admin']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/categories', function () {
        $categories = \App\Models\Category::withCount('menus')->get();
        return view('category.index', compact('categories'));
    });
    Route::get('/categories/create', function () {
        return view('category.create');
    });
    Route::get('/categories/{id}/edit', function ($id) {
        $category = \App\Models\Category::findOrFail($id);
        return view('category.edit', compact('category'));
    });

    Route::get('/menus', function () {
        $menus      = \App\Models\Menu::with('category')->get();
        $categories = \App\Models\Category::all();
        return view('menu.index', compact('menus', 'categories'));
    });
    Route::get('/menus/create', function () {
        $categories = \App\Models\Category::all();
        return view('menu.create', compact('categories'));
    });
    Route::get('/menus/{id}/edit', function ($id) {
        $menu       = \App\Models\Menu::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('menu.edit', compact('menu', 'categories'));
    });

    Route::get('/orders', function () {
        $orders = \App\Models\Order::with('user')->withCount('orderItems')->latest()->get();
        return view('orders.index', compact('orders'));
    });

    // CRUD Categories
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // CRUD Menus
    Route::post('/menus', [MenuController::class, 'store']);
    Route::put('/menus/{id}', [MenuController::class, 'update']);
    Route::delete('/menus/{id}', [MenuController::class, 'destroy']);

    // Update Order Status
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/orders/create', function () {
        $menus = \App\Models\Menu::where('stok', '>', 0)->get();
        return view('orders.create', compact('menus'));
    });

    Route::get('/orders/history', function () {
        $orders = \App\Models\Order::where('user_id', auth()->id())
                    ->with('orderItems.menu')
                    ->latest()
                    ->get();
        return view('orders.history', compact('orders'));
    });

    Route::get('/orders/{id}', function ($id) {
        $order = \App\Models\Order::with(['user', 'orderItems.menu'])->findOrFail($id);
        if (auth()->user()->role !== 'admin' && auth()->id() !== $order->user_id) {
            return redirect('/home')->with('error', 'Akses ditolak');
        }
        return view('orders.show', compact('order'));
    });

    Route::post('/orders', [OrderController::class, 'store']);
});

Route::get('/home', function () {
    $menus      = \App\Models\Menu::with('category')->get();
    $categories = \App\Models\Category::all();
    return view('home.index', compact('menus', 'categories'));
});

// Cart Routes
Route::post('/cart/add', function (Request $request) {
    $cart = session('cart', []);
    $id   = $request->menu_id;

    if (isset($cart[$id])) {
        $newJumlah = $cart[$id]['jumlah'] + $request->jumlah;
        $cart[$id]['jumlah'] = min($newJumlah, $request->stok);
    } else {
        $cart[$id] = [
            'nama_menu' => $request->nama_menu,
            'harga'     => $request->harga,
            'jumlah'    => $request->jumlah,
            'stok'      => $request->stok,
        ];
    }

    session(['cart' => $cart]);
    return back()->with('cart_message', $request->nama_menu . ' ditambahkan ke keranjang!');
});

Route::post('/cart/update', function (Request $request) {
    $cart = session('cart', []);
    $id   = $request->menu_id;

    if (isset($cart[$id])) {
        $cart[$id]['jumlah'] = $request->jumlah;
        session(['cart' => $cart]);
    }

    return back();
});

Route::post('/cart/remove', function (Request $request) {
    $cart = session('cart', []);
    unset($cart[$request->menu_id]);
    session(['cart' => $cart]);
    return back();
});

Route::post('/cart/clear', function () {
    session()->forget('cart');
    return redirect('/home');
});