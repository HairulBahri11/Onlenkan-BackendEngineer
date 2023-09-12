<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    protected $table = 'toko';
    protected $fillable = ['nama_toko', 'alamat_toko', 'jam_buka', 'jam_tutup', 'no_telp', 'foto_toko', 'deskripsi_toko', 'tanggal_berdiri', 'user_id'];
}
