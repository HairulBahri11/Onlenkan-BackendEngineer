<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class produkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr_produk = [
            [
                'nama_produk' => 'Wafer Tenggo',
                'kategori_id' => 1,
                'harga' => 1000,
                'stok' => 100,
                'deskripsi' => 'Wafer Tenggo adalah wafer yang sangat enak',
                'foto_produk' => 'wafer.jpg',
                'user_id' => 2
            ],
            [
                'nama_produk' => 'Teh Pucuk',
                'kategori_id' => 2,
                'harga' => 2000,
                'stok' => 100,
                'deskripsi' => 'Teh Pucuk adalah teh sejuk',
                'foto_produk' => 'tehpucuk.jpg',
                'user_id' => 3
            ],
            [
                'nama_produk' => 'Kaos Oblong',
                'kategori_id' => 3,
                'harga' => 53000,
                'stok' => 100,
                'deskripsi' => 'Kaos Oblong adalah kaos nyaman digunakan',
                'foto_produk' => 'kaos.jpg',
                'user_id' => 2
            ],
            [
                'nama_produk' => 'Laptop Asus',
                'kategori_id' => 4,
                'harga' => 2000000,
                'stok' => 100,
                'deskripsi' => 'Laptop Asus adalah laptop paling populer',
                'foto_produk' => 'laptop.jpg',
                'user_id' => 2
            ],
            [
                'nama_produk' => 'Mobil Honda',
                'kategori_id' => 5,
                'harga' => 75000000,
                'stok' => 100,
                'deskripsi' => 'Mobil Honda adalah mobil yang sangat enak',
                'foto_produk' => 'mobil.jpg',
                'user_id' => 3
            ],
        ];

        foreach ($arr_produk as $key => $produk) {
            Produk::create($produk);
        }
    }
}
