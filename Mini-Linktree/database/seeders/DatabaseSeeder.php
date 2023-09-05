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
            'name' => 'irul',
            'email' => 'irul@onlenkan.2.0',
            'password' => Hash::make('irul123'),
            'username' => 'irul.2.0',
            'foto' => 'irul.jpg',
            'deskripsi' => 'Welcome To My Journey As A Fullstack Web Developer',

        ]);
    }
}
