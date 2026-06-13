<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'no_do',
        'tanggal_do',
        'kode_mobil',
        'nama_mobil',
        'warna',
        'tahun',
        'chassis_code',
        'norangka',
        'enginecode',
        'nomesin',
        'faktur',
        'bln_naik_faktur',
        'harga',
        'kpt_kf',
        'acs2',
        'subsidi',
        'hpp',
        'lokasi',
        'estimasi_unit_masuk_gudang_dca',
        'status',
        'lain_lain',
        'penjualan',
        'tanggal_matching_do',
        'cabang',
        'keterangan',
        'unit',
    ];
}
