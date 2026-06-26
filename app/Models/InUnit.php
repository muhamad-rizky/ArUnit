<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InUnit extends Model
{
    protected $fillable = [
        'nama_driver',
        'tanggal',
        'type',
        'warna',
        'no_rangka',
        'no_mesin',
        'lokasi_pengambilan',
        'cabang_id',
        'cekits',
        'jam_kedatangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
