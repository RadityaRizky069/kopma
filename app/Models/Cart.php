<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // 1. KASIH TAU NAMA TABELNYA (PENTING!)
    protected $table = 'keranjang';

    // 2. SESUAIKAN NAMA KOLOM (Sesuai foto database kamu)
    protected $fillable = [
        'user_id', 
        'produk_id', // Di database kamu namanya produk_id, bukan product_id
        'jumlah'     // Di database kamu namanya jumlah, bukan quantity
    ];

    // 3. RELASI KE PRODUK
    public function product()
    {
        // Parameter kedua 'produk_id' wajib ditulis karena nama kolomnya tidak standar
        return $this->belongsTo(Product::class, 'produk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}