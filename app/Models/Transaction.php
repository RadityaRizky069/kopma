<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TransactionItem;
use App\Models\InstallmentPayment;
use Carbon\Carbon;

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
        'used_points',
        'discount',
        // ====== TAMBAHAN UNTUK FITUR CICILAN ======
        'is_installment',        // 1 jika cicilan, 0 jika bukan
        'installment_duration',  // Lama cicilan (hari)
        'installment_total',     // Total yang harus dicicil
        'installment_amount',    // Nominal per termin
        'installment_paid',      // Total yang SUDAH dibayar
        'installment_due'        // Tanggal jatuh tempo
    ];

    /**
     * Casts: Mengubah string dari database otomatis jadi objek Carbon (Tanggal)
     * agar bisa pakai fungsi ->format() atau ->isPast()
     */
    protected $casts = [
        'tanggal' => 'datetime',
        'installment_due' => 'datetime',
        'is_installment' => 'boolean',
    ];

    // ================= RELASI =================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }

    public function installmentPayments()
    {
        return $this->hasMany(InstallmentPayment::class, 'transaction_id');
    }

    // ================= BOOT (LOGIKA OTOMATIS) =================

    protected static function boot()
    {
        parent::boot();

        // Saat data dibuat, jika bukan cicilan, set default installment_paid ke 0
        static::creating(function ($model) {
            if (!$model->installment_paid) {
                $model->installment_paid = 0;
            }
        });
    }

    // ================= ACCESSORS (Fungsi Pembantu) =================

    /**
     * Mengecek sisa tagihan: Rp {{ $transaction->remaining_balance }}
     */
    public function getRemainingBalanceAttribute()
    {
        return $this->installment_total - $this->installment_paid;
    }

    /**
     * Mengecek persentase pembayaran: {{ $transaction->payment_percentage }}%
     */
    public function getPaymentPercentageAttribute()
    {
        if ($this->installment_total <= 0) return 0;
        return ($this->installment_paid / $this->installment_total) * 100;
    }

    /**
     * Mengecek apakah cicilan sudah telat jatuh tempo
     */
    public function getIsOverdueAttribute()
    {
        if (!$this->is_installment || $this->status === 'selesai') return false;
        return $this->installment_due && $this->installment_due->isPast();
    }
}