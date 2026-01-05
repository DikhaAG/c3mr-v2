<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBayar extends Model
{
    // Opsional: kalau kamu mau eksplisit nama tabel
    protected $table = 'data_bayars';

    // Daftar kolom yang boleh diisi via create() / fill()
    protected $fillable = [
        'bb_id',
        'account_number',
        'telp_number',
        'bill_amount_1',
        'jumlah_bayar',
        'payment_date',
        'status_tagihan',
        'area',
        'region',
        'branch',
        'city',
        'cluster',
        'sto',
        'wok',
        'agency',
        'los',
        'product',
        'mytsel',
        'segment',
        'usage_m2',
        'usage_m1',
        'tiket_open',
        'saldo',
        'bill_amount_2',
        'bucket_1',
        'bucket_2',
        'status',
        'namaloket',
        'kategoriloket',
        'dominan_payday',
        'last_date_pay',
        'customer_segment',
        'email',
        'los_category',
        'customer_category',
        'billing_category',
        'speed_category',
        'product_category',
        'full_name',
        'propensity_score_cp1',
        'crm_address',
        'no_handphone',
        'postal_code',
        'phone_number',
        'install_address',
        'addrs',
        'product_name',
        'usage_inet_gb',
        'sf_code',
        'channel',
        'referral_code',
        'subchannel_sales',
        'bill_info',
        'ps_ts',
        'arpu_cat',
        'chief_code',
        'chief_name',
        'latitude_echo',
        'longitude_echo',
        'cek_bayar',
    ];

    // Cast biar tipe data otomatis rapi (opsional tapi sangat berguna)
    protected $casts = [
        'payment_date' => 'date',
        'ps_ts'        => 'datetime',

        'bill_amount_1' => 'integer',
        'jumlah_bayar'  => 'integer',
        'tiket_open'    => 'integer',
        'saldo'         => 'integer',
        'bill_amount_2' => 'integer',
        'bucket_1'      => 'integer',
        'bucket_2'      => 'integer',
        'dominan_payday' => 'integer',
        'last_date_pay' => 'integer',
        'speed_category' => 'integer',

        'usage_m2'             => 'float',
        'usage_m1'             => 'float',
        'usage_inet_gb'        => 'float',
        'propensity_score_cp1' => 'float',
    ];
}
