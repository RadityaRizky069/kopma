<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'user_id', 
        'kode_transaksi', 
        'total_harga', 
        'metode_pembayaran', 
        'status', 
        'tanggal'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }
}