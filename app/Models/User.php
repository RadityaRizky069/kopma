<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ===============================
    // MASS ASSIGNABLE
    // ===============================
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_member',
        'points',
    ];

    // ===============================
    // HIDDEN
    // ===============================
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ===============================
    // CAST
    // ===============================
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_member' => 'boolean',
        ];
    }

    // ===============================
    // RELATIONSHIPS
    // ===============================

    // user punya banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // user punya banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
