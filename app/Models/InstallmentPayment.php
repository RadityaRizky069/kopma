<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallmentPayment extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi
    protected $fillable = [
        'transaction_id',
        'amount',
        'payment_date'
    ];

    // Relasi balik ke transaksi (Opsional tapi berguna)
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}