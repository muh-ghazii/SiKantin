<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user admin
        User::create([
            'nama'     => 'Admin SiKantin',
            'email'    => 'admin@sikantin.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        // Buat user pelanggan contoh
        User::create([
            'nama'     => 'Pelanggan Test',
            'email'    => 'pelanggan@sikantin.com',
            'password' => Hash::make('password123'),
            'role'     => 'pelanggan',
        ]);
    }
}