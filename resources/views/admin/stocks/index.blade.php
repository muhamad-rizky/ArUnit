@extends('layouts.app')

@section('content')
<style>
    .data-table {
        table-layout: auto !important;
        min-width: 100% !important;
    }
    .data-table tbody tr td,
    .data-table thead tr th {
        color: #334155 !important;
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
    .table-container {
        overflow-x: auto !important;
        border-radius: 10px;
        background: #fff;
        border: 1px solid #e2e8f0;
        width: 100%;
    }
</style>

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <div>
        <h1 class="page-title">Data Stock</h1>
        <p class="page-subtitle">Kelola daftar stock kendaraan.</p>
    </div>
    <a href="{{ route('admin.stocks.create') }}" class="btn-primary">Tambah Stock</a>
</div>

@if(session('success'))
    <div style="margin-bottom:18px; padding:14px 16px; border-radius:12px; background:#dcfce7; color:#166534; border:1px solid #86efac;">
        {{ session('success') }}
    </div>
@endif

<div style="margin-bottom:18px; display:flex; flex-wrap:wrap; gap:12px; align-items:center; justify-content:space-between;">
    <form method="GET" action="{{ route('admin.stocks.index') }}" style="display:flex; gap:8px; align-items:center; flex:1; min-width:260px;">
        <input type="text" name="search" value="{{ old('search', $search ?? '') }}" placeholder="Cari No DO, Nama Mobil, No Rangka..."
            style="width:100%; max-width:400px; padding:10px 14px; border-radius:10px; border:1px solid #d1d5db; background:#fff; color:#111827;">
        <button type="submit" class="btn-primary" style="padding:10px 18px;">Cari</button>
    </form>
    @if(!empty($search))
        <a href="{{ route('admin.stocks.index') }}" style="color:#0f172a; text-decoration:none; font-weight:600;">Reset</a>
    @endif
</div>

<div class="table-container">
    <table class="data-table" style="width:100%; border-collapse:collapse; text-align:left;">
        <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
            <tr>
                <th style="padding:12px 16px;">NO</th>
                <th style="padding:12px 16px;">NO DO</th>
                <th style="padding:12px 16px;">TANGGAL DO</th>
                <th style="padding:12px 16px;">KODE MOBIL</th>
                <th style="padding:12px 16px;">NAMA MOBIL</th>
                <th style="padding:12px 16px;">WARNA</th>
                <th style="padding:12px 16px;">TAHUN</th>
                <th style="padding:12px 16px;">CHASSIS CODE</th>
                <th style="padding:12px 16px;">NO RANGKA</th>
                <th style="padding:12px 16px;">ENGINE CODE</th>
                <th style="padding:12px 16px;">NO MESIN</th>
                <th style="padding:12px 16px;">FAKTUR</th>
                <th style="padding:12px 16px;">BLN NAIK FAKTUR</th>
                <th style="padding:12px 16px;">HARGA</th>
                <th style="padding:12px 16px;">KPT + KF</th>
                <th style="padding:12px 16px;">ACS2</th>
                <th style="padding:12px 16px;">SUBSIDI</th>
                <th style="padding:12px 16px;">HPP</th>
                <th style="padding:12px 16px;">LOKASI</th>
                <th style="padding:12px 16px;">ESTIMASI MASUK GUDANG</th>
                <th style="padding:12px 16px;">STATUS</th>
                <th style="padding:12px 16px;">LAIN-LAIN</th>
                <th style="padding:12px 16px;">PENJUALAN</th>
                <th style="padding:12px 16px;">TANGGAL MATCHING/DO</th>
                <th style="padding:12px 16px;">CABANG</th>
                <th style="padding:12px 16px;">KETERANGAN</th>
                <th style="padding:12px 16px;">UNIT</th>
                <th class="col-action" style="padding:12px 16px; position:sticky; right:0; background:#f8fafc; z-index:10; border-left:1px solid #e2e8f0; box-shadow:-4px 0 6px -1px rgba(0,0,0,0.05);">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i => $item)
                <tr style="border-bottom:1px solid #e2e8f0;">
                    <td style="padding:12px 16px;">{{ $items->firstItem() + $i }}</td>
                    <td style="padding:12px 16px;">{{ $item->no_do }}</td>
                    <td style="padding:12px 16px;">{{ $item->tanggal_do ? \Carbon\Carbon::parse($item->tanggal_do)->format('d-M-y') : '' }}</td>
                    <td style="padding:12px 16px;">{{ $item->kode_mobil }}</td>
                    <td style="padding:12px 16px;">{{ $item->nama_mobil }}</td>
                    <td style="padding:12px 16px;">{{ $item->warna }}</td>
                    <td style="padding:12px 16px;">{{ $item->tahun }}</td>
                    <td style="padding:12px 16px;">{{ $item->chassis_code }}</td>
                    <td style="padding:12px 16px;">{{ $item->norangka }}</td>
                    <td style="padding:12px 16px;">{{ $item->enginecode }}</td>
                    <td style="padding:12px 16px;">{{ $item->nomesin }}</td>
                    <td style="padding:12px 16px;">{{ $item->faktur }}</td>
                    <td style="padding:12px 16px;">{{ $item->bln_naik_faktur }}</td>
                    <td style="padding:12px 16px;">{{ number_format($item->harga ?? 0, 0, ',', '.') }}</td>
                    <td style="padding:12px 16px;">{{ number_format($item->kpt_kf ?? 0, 0, ',', '.') }}</td>
                    <td style="padding:12px 16px;">{{ number_format($item->acs2 ?? 0, 0, ',', '.') }}</td>
                    <td style="padding:12px 16px;">{{ number_format($item->subsidi ?? 0, 0, ',', '.') }}</td>
                    <td style="padding:12px 16px;">{{ number_format($item->hpp ?? 0, 0, ',', '.') }}</td>
                    <td style="padding:12px 16px;">{{ $item->lokasi }}</td>
                    <td style="padding:12px 16px;">{{ $item->estimasi_unit_masuk_gudang_dca }}</td>
                    <td style="padding:12px 16px;">{{ $item->status }}</td>
                    <td style="padding:12px 16px;">{{ $item->lain_lain }}</td>
                    <td style="padding:12px 16px;">{{ $item->penjualan }}</td>
                    <td style="padding:12px 16px;">{{ $item->tanggal_matching_do }}</td>
                    <td style="padding:12px 16px;">{{ $item->cabang }}</td>
                    <td style="padding:12px 16px;">{{ $item->keterangan }}</td>
                    <td style="padding:12px 16px;">{{ $item->unit }}</td>
                    <td style="padding:12px 16px; text-align:center; white-space:nowrap; position:sticky; right:0; background:#fff; z-index:10; border-left:1px solid #e2e8f0; box-shadow:-4px 0 6px -1px rgba(0,0,0,0.05);">
                        <a href="{{ route('admin.stocks.edit', $item) }}" class="btn-primary">Edit</a>
                        <form action="{{ route('admin.stocks.destroy', $item) }}" method="POST" style="display:inline-flex; margin-left:8px;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-secondary" style="background:#ef4444; color:#fff; border:none;" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="28" style="text-align:center; padding:18px 12px; color: #000; background: #f5f5f5;">
                        Tidak ada data stock untuk ditampilkan.
                    </td>
                </tr>
            @endempty
        </tbody>
    </table>
</div>

<div style="margin-top:16px;">{{ $items->links() }}</div>

@endsection
