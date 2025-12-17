<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'username',
        'nama_lengkap',
        'regional',
        'branch',
    ];
    public function pelanggans()
    {
        // admin: nama kolom di tabel pelanggan
        // nama_lengkap: nama kolom di tabel tim
        return $this->hasMany(\App\Models\Pelanggan::class, 'admin', 'nama_lengkap');
    }
}
