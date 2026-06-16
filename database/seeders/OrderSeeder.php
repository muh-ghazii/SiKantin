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

        // Buat 50 order realistis menggunakan Faker
        $faker = \Faker\Factory::create('id_ID');
        $menus = \App\Models\Menu::all();
        $users = \App\Models\User::where('role', 'pelanggan')->get();
        $statuses = ['pending', 'proses', 'selesai', 'selesai', 'selesai', 'dibatalkan'];

        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            // Waktu random dalam 30 hari terakhir
            $createdAt = $faker->dateTimeBetween('-30 days', 'now');

            $order = Order::create([
                'user_id'     => $user->id,
                'total_harga' => 0,
                'status'      => $status,
                'created_at'  => $createdAt,
                'updated_at'  => $createdAt,
            ]);

            // Tambahkan 1 hingga 3 item menu secara random
            $numItems = rand(1, 3);
            $totalHarga = 0;
            $selectedMenus = $menus->random($numItems);

            foreach ($selectedMenus as $menu) {
                $jumlah = rand(1, 3);
                $subtotal = $menu->harga * $jumlah;
                $totalHarga += $subtotal;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'menu_id'    => $menu->id,
                    'jumlah'     => $jumlah,
                    'subtotal'   => $subtotal,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }

            // Update total harga order
            $order->update(['total_harga' => $totalHarga]);
        }
    }
}