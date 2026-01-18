<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TransactionItem;

class Transaction extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'kode_transaksi',
        'total_harga',
        'metode_pembayaran',
        'status',
        'tanggal',
        'used_points',   // WAJIB
        'discount'       // WAJIB
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }
}
