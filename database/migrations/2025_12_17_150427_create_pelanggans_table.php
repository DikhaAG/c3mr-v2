<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();
            $table->string('id_pelanggan')->nullable();
            $table->string('domisili')->nullable();
            $table->string('category_billing')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('cp')->nullable();
            $table->string('branch')->nullable();
            $table->string('sto')->nullable();
            $table->string('los')->nullable();
            $table->string('status')->nullable();
            $table->string('habit_category')->nullable();
            $table->decimal('total_tagihan', 15, 2)->default(0);
            $table->string('fungsi')->nullable();
            $table->string('admin')->nullable();
            $table->string('r_caring_status')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('paket')->nullable();
            $table->date('tgl_aktivasi')->nullable();
            $table->string('status_bayar')->nullable();
            $table->date('payment_date')->nullable();
            $table->decimal('payment_amount', 15, 2)->default(0);
            $table->string('channel_bayar')->nullable();
            $table->string('regional', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
