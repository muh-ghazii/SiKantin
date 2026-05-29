<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total user pelanggan
        $totalPelanggan = User::where('role', 'pelanggan')->count();

        // Total menu
        $totalMenu = Menu::count();

        // Total kategori
        $totalKategori = Category::count();

        // Total pesanan
        $totalPesanan = Order::count();

        // Total pendapatan (hanya pesanan selesai)
        $totalPendapatan = Order::where('status', 'selesai')->sum('total_harga');

        // Pesanan per status
        $pesananPerStatus = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // 5 menu terlaris
        $menuTerlaris = Menu::select('menus.id', 'menus.nama_menu', 'menus.harga',
                DB::raw('SUM(order_items.jumlah) as total_terjual'))
            ->join('order_items', 'menus.id', '=', 'order_items.menu_id')
            ->groupBy('menus.id', 'menus.nama_menu', 'menus.harga')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // Pesanan terbaru
        $pesananTerbaru = Order::with(['user', 'orderItems.menu'])
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'statistik' => [
                    'total_pelanggan'  => $totalPelanggan,
                    'total_menu'       => $totalMenu,
                    'total_kategori'   => $totalKategori,
                    'total_pesanan'    => $totalPesanan,
                    'total_pendapatan' => $totalPendapatan,
                ],
                'pesanan_per_status' => $pesananPerStatus,
                'menu_terlaris'      => $menuTerlaris,
                'pesanan_terbaru'    => $pesananTerbaru,
            ]
        ]);
    }
}