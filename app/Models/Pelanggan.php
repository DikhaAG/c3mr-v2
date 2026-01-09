<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    //
    use HasFactory;

    /**
     * Column Casting: Memastikan tipe data dikonversi otomatis
     * saat diakses melalui Eloquent.
     */
    protected $casts = [
        'tanggal' => 'date',
        'tgl_aktivasi' => 'date',
        'payment_date' => 'date',
        'total_tagihan' => 'decimal:2',
        'payment_amount' => 'decimal:2',
    ];

    protected $fillable = [
        'tanggal',
        'id_pelanggan',
        'domisili',
        'category_billing',
        'nama_pelanggan',
        'cp',
        'branch',
        'sto',
        'los',
        'status',
        'habit_category',
        'total_tagihan',
        'fungsi',
        'admin',
        'r_caring_status',
        'keterangan',
        'keterangan2',
        'paket',
        'tgl_aktivasi',
        'status_bayar',
        'payment_date',
        'payment_amount',
        'channel_bayar',
        'regional',
    ];
}
