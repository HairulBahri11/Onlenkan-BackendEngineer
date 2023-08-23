<?php

namespace Database\Seeders;

use App\Models\Kategori as ModelsKategori;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class kategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        #example seeder
        $arr_kategori = ['Makanan', 'Minuman', 'Pakaian', 'Elektronik', 'Kendaraan', 'Buku', 'Alat Tulis', 'Alat Mandi', 'Alat Rumah Tangga', 'Alat Olahraga'];
        foreach ($arr_kategori as $kategori) {
            ModelsKategori::create([
                'nama_kategori' => $kategori,
            ]);
        }
    }
}
