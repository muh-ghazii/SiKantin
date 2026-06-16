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

        // Buat user pelanggan contoh statis
        User::create([
            'nama'     => 'Pelanggan Test',
            'email'    => 'pelanggan@sikantin.com',
            'password' => Hash::make('password123'),
            'role'     => 'pelanggan',
        ]);

        // Buat 10 pelanggan realistis menggunakan Faker
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'nama'     => $faker->name,
                'email'    => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role'     => 'pelanggan',
            ]);
        }
    }
}