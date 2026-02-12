<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Buat test users dengan role yang berbeda
        
        // User 1: Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // User 2: Pustakawan
        User::create([
            'name' => 'Pustakawan User',
            'email' => 'pustakawan@example.com',
            'password' => Hash::make('password123'),
            'role' => 'pustakawan',
            'is_active' => true,
        ]);

        // User 3: User Biasa (Pengunjung)
        User::create([
            'name' => 'Pengunjung User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);

        // User 4: User Nonaktif (untuk testing)
        User::create([
            'name' => 'Nonaktif User',
            'email' => 'nonaktif@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => false,
        ]);

        // User 5: Admin 2 (untuk testing)
        User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Generate 10 user tambahan dengan role random
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "User {$i}",
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password123'),
                'role' => fake()->randomElement(['user', 'user', 'user', 'pustakawan']), // Lebih banyak user
                'is_active' => fake()->boolean(90), // 90% aktif
            ]);
        }

        // Tambah data buku fisik
        $this->call(BookSeeder::class);
    }
}
