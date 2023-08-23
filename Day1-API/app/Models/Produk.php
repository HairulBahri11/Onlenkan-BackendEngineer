<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = ['nama_produk', 'kategori_id', 'harga', 'stok', 'deskripsi', 'foto_produk'];
    // protected $guarded = [];

    public function datakategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
