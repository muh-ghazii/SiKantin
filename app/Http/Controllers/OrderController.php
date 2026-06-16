<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // GET /orders
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->get('per_page', 10);

        // Admin lihat semua, pelanggan hanya miliknya
        if ($user->role === 'admin') {
            $orders = Order::with(['user', 'orderItems.menu'])->paginate($perPage);
        } else {
            $orders = Order::with(['orderItems.menu'])
                ->where('user_id', $user->id)
                ->paginate($perPage);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $orders
        ]);
    }

    // POST /orders
    public function store(Request $request)
    {
        $request->validate([
            'items'           => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.jumlah'  => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $menu = Menu::find($item['menu_id']);

                if ($menu->stok < $item['jumlah']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Stok {$menu->nama_menu} tidak mencukupi");
                }

                $subtotal     = $menu->harga * $item['jumlah'];
                $totalHarga  += $subtotal;
                $orderItems[] = [
                    'menu_id'  => $menu->id,
                    'jumlah'   => $item['jumlah'],
                    'subtotal' => $subtotal,
                ];

                // Kurangi stok
                $menu->decrement('stok', $item['jumlah']);
            }

            $order = Order::create([
                'user_id'     => Auth::id(),
                'total_harga' => $totalHarga,
                'status'      => 'pending',
            ]);

            $order->orderItems()->createMany($orderItems);

            DB::commit();

            session()->forget('cart');
            return redirect('/orders/history')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Pesanan gagal dibuat: ' . $e->getMessage());
        }
    }

    // GET /orders/{id}
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.menu'])->find($id);

        if (!$order) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $order
        ]);
    }

    // PUT /orders/{id}/status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }

        $request->validate([
            'status' => 'required|in:pending,proses,selesai,dibatalkan',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate!');
    }
}