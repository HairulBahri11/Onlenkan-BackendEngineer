<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123')
        ]);

        $admin->assignRole('admin');


        $penjual_a = User::create([
            'name' => 'Ani_penjual',
            'email' => 'Penjual_A@gmail.com',
            'password' => bcrypt('penjual123')
        ]);

        $penjual_a->assignRole('penjual');

        $penjual_b = User::create([
            'name' => 'Beni_penjual',
            'email' => 'Penjual_B@gmail.com',
            'password' => bcrypt('penjual123')
        ]);

        $penjual_b->assignRole('penjual');
    }
}
