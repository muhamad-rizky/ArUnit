<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Stock::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'No DO',
            'Tanggal DO',
            'Kode Mobil',
            'Nama Mobil',
            'Warna',
            'Tahun',
            'Chassis Code',
            'No Rangka',
            'Engine Code',
            'No Mesin',
            'Faktur',
            'Bulan Naik Faktur',
            'Harga',
            'KPT + KF',
            'ACS2',
            'Subsidi',
            'HPP',
            'Lokasi',
            'Estimasi Masuk Gudang',
            'Status',
            'Lain-lain',
            'Penjualan',
            'Tanggal Matching/DO',
            'Cabang',
            'Keterangan',
            'Unit',
            'Created At',
            'Updated At',
        ];
    }
}
