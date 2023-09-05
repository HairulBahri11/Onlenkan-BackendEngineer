<?php

namespace Database\Seeders;

use App\Models\SosialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SosialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = SosialMedia::create([
            'id' => 1,
            'title' => 'Instagram',
            'icon' => 'fab fa-instagram',
            'link' => 'https://www.instagram.com/irul.2.0/',
            'users_id' => 1

        ]);
        $data = SosialMedia::create([
            'id' => 2,
            'title' => 'Facebook',
            'icon' => 'fab fa-facebook',
            'link' => 'https://www.facebook.com/irul.2.0/',
            'users_id' => 1
        ]);
        $data = SosialMedia::create([
            'id' => 3,
            'title' => 'Twitter',
            'icon' => 'fab fa-twitter',
            'link' => 'https://twitter.com/irul.2.0',
            'users_id' => 1
        ]);
    }
}
