<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->dateTime('payment_date')->nullable()->change();
            $table->decimal('payment_amount', 12, 2)->nullable()->change();
            $table->string('channel_bayar')->nullable()->change();
            $table->string('status_bayar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->dateTime('payment_date')->nullable(false)->change();
            $table->decimal('payment_amount', 12, 2)->nullable(false)->change();
            $table->string('channel_bayar')->nullable(false)->change();
            $table->string('status_bayar')->nullable(false)->change();
        });
    }
};
