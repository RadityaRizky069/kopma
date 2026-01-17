<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // ✅ CEK DULU: table harus ada
        if (Schema::hasTable('transactions') &&
            !Schema::hasColumn('transactions', 'payment_method')) {

            Schema::table('transactions', function (Blueprint $table) {
                $table->string('payment_method')->nullable()->after('status');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('transactions') &&
            Schema::hasColumn('transactions', 'payment_method')) {

            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }
    }
};
