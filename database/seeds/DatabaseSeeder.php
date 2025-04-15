<?php

namespace Database\Seeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Menjalankan UsersTableSeeder
        $this->call(UsersTableSeeder::class);
    }

    
}