<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // ✅ HARUS SAMA DENGAN users.id
            $table->unsignedBigInteger('user_id');

            $table->integer('total');
            $table->string('status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamps();

            // ✅ FOREIGN KEY MANUAL (PALING AMAN)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
