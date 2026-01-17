<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
Schema::create('transactions', function (Blueprint $table) {
    $table->id(); // BIGINT UNSIGNED

    $table->foreignId('user_id')
        ->constrained()
        ->onDelete('cascade');

    $table->integer('total');
    $table->string('status')->default('pending');

    // ⬅⬅⬅ PINDAHKAN KE SINI
    $table->string('payment_method')->nullable();

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
