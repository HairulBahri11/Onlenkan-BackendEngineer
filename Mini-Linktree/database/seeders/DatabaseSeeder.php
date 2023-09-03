<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = User::create([
            'name' => 'Admin',
            'email' => 'admin@onlenkan.2.0',
            'password' => Hash::make('admin123'), // password
            'role' => 'admin',
        ]);
    }
}
