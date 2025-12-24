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
        Schema::create('data_bayars', function (Blueprint $table) {
            $table->id();
            $table->string('bb_id')->nullable();
            $table->string('account_number')->nullable();
            $table->string('telp_number')->nullable();
            $table->integer('bill_amount_1')->default(0);
            $table->integer('jumlah_bayar')->default(0);
            $table->date('payment_date')->nullable();
            $table->string('status_tagihan')->nullable();
            $table->string('area')->nullable();
            $table->string('region')->nullable();
            $table->string('branch')->nullable();
            $table->string('city')->nullable();
            $table->string('cluster')->nullable();
            $table->string('sto')->nullable();
            $table->string('wok')->nullable();
            $table->string('agency')->nullable();
            $table->string('los')->nullable();
            $table->string('product')->nullable();
            $table->string('mytsel')->nullable();
            $table->string('segment')->nullable();
            $table->double('usage_m2')->default(0);
            $table->double('usage_m1')->default(0);
            $table->integer('tiket_open')->default(0);
            $table->integer('saldo')->default(0);
            $table->integer('bill_amount_2')->default(0);
            $table->integer('bucket_1')->default(0);
            $table->integer('bucket_2')->default(0);
            $table->string('status')->nullable();
            $table->string('namaloket')->nullable();
            $table->string('kategoriloket')->nullable();
            $table->integer('dominan_payday')->default(0);
            $table->integer('last_date_pay')->default(0);
            $table->string('customer_segment')->nullable();
            $table->string('email')->nullable();
            $table->string('los_category')->nullable();
            $table->string('customer_category')->nullable();
            $table->string('billing_category')->nullable();
            $table->integer('speed_category')->default(0);
            $table->string('product_category')->nullable();
            $table->string('full_name')->nullable();
            $table->double('propensity_score_cp1')->default(0);
            $table->string('crm_address')->nullable();
            $table->string('no_handphone')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('install_address')->nullable();
            $table->string('addrs')->nullable();
            $table->string('product_name')->nullable();
            $table->double('usage_inet_gb')->default(0);
            $table->string('sf_code')->nullable();
            $table->string('channel')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('subchannel_sales')->nullable();
            $table->string('bill_info')->nullable();
            $table->timestamp('ps_ts')->nullable();
            $table->string('arpu_cat')->nullable();
            $table->string('chief_code')->nullable();
            $table->string('chief_name')->nullable();
            $table->string('latitude_echo')->nullable();
            $table->string('longitude_echo')->nullable();
            $table->string('cek_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bayars');
    }
};
