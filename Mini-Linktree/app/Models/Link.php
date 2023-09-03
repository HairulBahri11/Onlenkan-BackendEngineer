<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $table = 'link_tree';
    protected $fillable = ['title', 'icon', 'order', 'link', 'created_by', 'updated_by', 'warna'];
}
