<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installment_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id'); 
            $table->integer('amount');
            $table->timestamp('payment_date');
            $table->timestamps();
            
            $table->index('transaction_id'); // Pakai index saja, lebih aman
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installment_payments');
    }
};