<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $order1 = Order::create([
            'user_id' => 2, // ID pelanggan test
            'total_harga' => 20000.00,
            'status' => 'selesai',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'menu_id' => 1,
            'jumlah' => 1,
            'subtotal' => 15000.00,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'menu_id' => 5,
            'jumlah' => 1,
            'subtotal' => 5000.00,
        ]);
    }
}