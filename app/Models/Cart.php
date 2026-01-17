<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $fillable = ['user_id', 'produk_id', 'jumlah'];

    public function product()
    {
        // Pastikan foreign key adalah produk_id sesuai phpMyAdmin kamu
        return $this->belongsTo(Product::class, 'produk_id');
    }
}