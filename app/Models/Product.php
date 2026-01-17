<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'kategori_id'
    ];

    // =========================
    // RELASI KOMENTAR
    // =========================
public function comments()
{
    return $this->hasMany(Comment::class, 'product_id')
        ->whereNull('parent_id')
        ->with(['user','replies']);
}

}
