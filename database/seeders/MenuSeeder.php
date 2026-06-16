<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // Makanan (category_id: 1)
            ['category_id' => 1, 'nama_menu' => 'Nasi Goreng', 'deskripsi' => 'Nasi goreng spesial dengan telur dan ayam', 'harga' => 15000, 'stok' => 50],
            ['category_id' => 1, 'nama_menu' => 'Mie Goreng', 'deskripsi' => 'Mie goreng dengan sayuran segar', 'harga' => 12000, 'stok' => 50],
            ['category_id' => 1, 'nama_menu' => 'Nasi Ayam', 'deskripsi' => 'Nasi dengan ayam goreng crispy', 'harga' => 18000, 'stok' => 40],
            ['category_id' => 1, 'nama_menu' => 'Gado-gado', 'deskripsi' => 'Sayuran segar dengan bumbu kacang', 'harga' => 13000, 'stok' => 30],

            // Minuman (category_id: 2)
            ['category_id' => 2, 'nama_menu' => 'Es Teh Manis', 'deskripsi' => 'Teh manis dingin segar', 'harga' => 5000, 'stok' => 100],
            ['category_id' => 2, 'nama_menu' => 'Es Jeruk', 'deskripsi' => 'Jeruk peras dingin', 'harga' => 7000, 'stok' => 80],
            ['category_id' => 2, 'nama_menu' => 'Jus Alpukat', 'deskripsi' => 'Jus alpukat segar dengan susu', 'harga' => 12000, 'stok' => 50],
            ['category_id' => 2, 'nama_menu' => 'Air Mineral', 'deskripsi' => 'Air mineral botol 600ml', 'harga' => 4000, 'stok' => 200],

            // Snack (category_id: 3)
            ['category_id' => 3, 'nama_menu' => 'Pisang Goreng', 'deskripsi' => 'Pisang goreng crispy', 'harga' => 8000, 'stok' => 60],
            ['category_id' => 3, 'nama_menu' => 'Tahu Goreng', 'deskripsi' => 'Tahu goreng dengan cabe rawit', 'harga' => 5000, 'stok' => 70],

            // Paket Hemat (category_id: 4)
            ['category_id' => 4, 'nama_menu' => 'Paket Nasi + Minum', 'deskripsi' => 'Nasi goreng + es teh manis', 'harga' => 18000, 'stok' => 30],
            ['category_id' => 4, 'nama_menu' => 'Paket Lengkap', 'deskripsi' => 'Nasi ayam + jus + snack', 'harga' => 28000, 'stok' => 20],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}