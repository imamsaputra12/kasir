<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data pengguna dengan role admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Jangan lupa untuk hash password
            'role' => 'admin',
        ]);

        // Menambahkan data pengguna dengan role kasir
        User::create([
            'name' => 'Kasir User',
            'email' => 'kasir@example.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);
    }
}