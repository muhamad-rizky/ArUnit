@extends('layouts.app')

@section('content')
    <style>
        .data-table {
            table-layout: auto;
            width: 100%;
            border-collapse: collapse;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.9rem;
        }

        .data-table thead {
            background-color: #1e293b;
            color: #f8fafc;
        }

        .data-table thead tr th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #ef4444 !important;
            white-space: nowrap;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.2s ease;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .data-table tbody tr:hover {
            background-color: #e2e8f0;
        }

        .data-table tbody tr.row-matching {
            background-color: #f3e8ff !important; /* light purple */
        }

        .data-table tbody tr.row-matching:hover {
            background-color: #e9d5ff !important; /* darker purple */
        }

        .data-table tbody tr.row-sold {
            background-color: #dcfce7 !important;
        }

        .data-table tbody tr.row-sold:hover {
            background-color: #bbf7d0 !important;
        }

        .data-table tbody tr.row-free {
            background-color: #ffffff !important;
        }

        .data-table tbody tr.row-free:hover {
            background-color: #f1f5f9 !important;
        }

        .data-table tbody tr td {
            padding: 12px 16px;
            color: #0f172a !important;
            font-weight: 500; 
            border: 1px solid #ef4444 !important;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #cbd5e1;
            width: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .col-action {
            position: sticky;
            right: 0;
            z-index: 10;
            background-color: #1e293b !important;
            border-left: 2px solid #cbd5e1 !important;
            box-shadow: -4px 0 6px -1px rgba(0, 0, 0, 0.05);
        }

        .col-action-body {
            position: sticky;
            right: 0;
            z-index: 10;
            background-color: inherit;
            border-left: 2px solid #e2e8f0 !important;
            text-align: center;
        }

        /* Ensure action column has background on hover/even rows */
        .data-table tbody tr:hover .col-action-body {
            background-color: #e2e8f0;
        }

        .data-table tbody tr:nth-child(even) .col-action-body {
            background-color: #f8fafc;
        }

        /* default action bg to white for odd rows */
        .data-table tbody tr:nth-child(odd) .col-action-body {
            background-color: #ffffff;
        }

        .btn-action-primary {
            background-color: #3b82f6;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: background-color 0.2s;
            display: inline-block;
        }

        .btn-action-primary:hover {
            background-color: #2563eb;
            color: white;
        }

        .btn-action-danger {
            background-color: #ef4444;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-action-danger:hover {
            background-color: #dc2626;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 0.95rem;
        }

        .search-input {
            width: 100%;
            max-width: 400px;
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #0f172a;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-primary-top {
            background-color: #10b981;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary-top:hover {
            background-color: #059669;
            color: white;
        }

        .btn-search {
            background-color: #3b82f6;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-search:hover {
            background-color: #2563eb;
        }
    </style>

    <div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <div>
            <h1 class="page-title">Data Stock</h1>
            <p class="page-subtitle" style="margin-top: 4px;">Kelola daftar stock kendaraan dengan mudah.</p>
        </div>
        <div style="display:flex; gap:12px;">
            <a href="{{ route('admin.stocks.print') }}" target="_blank" class="btn-primary-top" style="background-color: #64748b;">
                <i class="fa-solid fa-print"></i> Print
            </a>
            <a href="{{ route('admin.stocks.exportPdf') }}" class="btn-primary-top" style="background-color: #ef4444;">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </a>
            <a href="{{ route('admin.stocks.exportExcel') }}" class="btn-primary-top" style="background-color: #10b981;">
                <i class="fa-solid fa-file-excel"></i> Excel
            </a>
            <a href="{{ route('admin.stocks.create') }}" class="btn-primary-top" style="background-color: #3b82f6;">
                <i class="fa-solid fa-plus"></i> Tambah Stock
            </a>
        </div>
    </div>

    @if (session('success'))
        <div
            style="margin-bottom:20px; padding:16px 20px; border-radius:8px; background-color:#ecfdf5; color:#065f46; border-left:4px solid #10b981; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    <div
        style="margin-bottom:20px; display:flex; flex-wrap:wrap; gap:16px; align-items:center; justify-content:space-between; background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
        <form method="GET" action="{{ route('admin.stocks.index') }}"
            style="display:flex; gap:12px; align-items:center; flex:1; min-width:260px;">
            <input type="text" name="search" class="search-input" value="{{ old('search', $search ?? '') }}"
                placeholder="Cari No DO, Nama Mobil, No Rangka...">
            <button type="submit" class="btn-search">Cari</button>
        </form>
        @if (!empty($search))
            <a href="{{ route('admin.stocks.index') }}"
                style="color:#ef4444; text-decoration:none; font-weight:600; padding: 8px 12px; border-radius: 6px; transition: background 0.2s;"
                onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='transparent'">
                Reset Filter
            </a>
        @endif
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NO DO</th>
                    <th>TANGGAL DO</th>
                    <th>KODE MOBIL</th>
                    <th>NAMA MOBIL</th>
                    <th>WARNA</th>
                    <th>TAHUN</th>
                    <th>CHASSIS CODE</th>
                    <th>NO RANGKA</th>
                    <th>ENGINE CODE</th>
                    <th>NO MESIN</th>
                    <th>FAKTUR</th>
                    <th>BLN NAIK FAKTUR</th>
                    <th>HARGA</th>
                    <th>KPT + KF</th>
                    <th>ACS2</th>
                    <th>SUBSIDI</th>
                    <th>HPP</th>
                    <th>LOKASI</th>
                    <th>ESTIMASI MASUK GUDANG</th>
                    <th>STATUS</th>
                    <th>LAIN-LAIN</th>
                    <th>PENJUALAN</th>
                    <th>TANGGAL MATCHING/DO</th>
                    <th>CABANG</th>
                    <th>KETERANGAN</th>
                    <th>UNIT</th>
                    <th class="col-action">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $item)
                    @php
                        $statusLower = strtolower($item->status ?? '');
                        $rowClass = '';
                        if ($statusLower == 'free') {
                            $rowClass = 'row-free';
                        } elseif ($statusLower == 'matching') {
                            $rowClass = 'row-matching';
                        } elseif ($statusLower == 'sold') {
                            $rowClass = 'row-sold';
                        }

                        // --- TAMBAHKAN PENANGANAN ERROR TANGGAL DI SINI ---
                        $tanggalDo = '-';
                        if ($item->tanggal_do) {
                            try {
                                $tanggalDo = \Carbon\Carbon::parse($item->tanggal_do)->format('d-M-Y');
                            } catch (\Exception $e) {
                                $tanggalDo = $item->tanggal_do; // Tampilkan apa adanya (misal "12") jika error
                            }
                        }

                        $tanggalMatching = '-';
                        if ($item->tanggal_matching_do) {
                            try {
                                $tanggalMatching = \Carbon\Carbon::parse($item->tanggal_matching_do)->format('d-M-Y');
                            } catch (\Exception $e) {
                                $tanggalMatching = $item->tanggal_matching_do; // Tampilkan apa adanya jika error
                            }
                        }
                    @endphp

                    <tr class="{{ $rowClass }}">
                        <td style="text-align: center;">{{ $items->firstItem() + $i }}</td>
                        <td>{{ $item->no_do }}</td>

                        <td>{{ $tanggalDo }}</td>

                        <td>{{ $item->kode_mobil }}</td>
                        <td style="font-weight: 500;">{{ $item->nama_mobil }}</td>
                        <td>{{ $item->warna }}</td>
                        <td style="text-align: center;">{{ $item->tahun }}</td>
                        <td>{{ $item->chassis_code }}</td>
                        <td>{{ $item->norangka }}</td>
                        <td>{{ $item->enginecode }}</td>
                        <td>{{ $item->nomesin }}</td>
                        <td>{{ $item->faktur }}</td>
                        <td>{{ $item->bln_naik_faktur }}</td>
                        <td style="text-align: right;">{{ number_format($item->harga ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->kpt_kf ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->acs2 ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->subsidi ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: right; font-weight: 600;">{{ number_format($item->hpp ?? 0, 0, ',', '.') }}
                        </td>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ $item->estimasi_unit_masuk_gudang_dca }}</td>
                        <td style="text-align: center; font-weight: 600; text-transform: uppercase;">
                            {{ $item->status ?? '-' }}
                        </td>
                        <td>{{ $item->lain_lain }}</td>
                        <td>{{ $item->penjualan }}</td>

                        <td>{{ $tanggalMatching }}</td>

                        <td>{{ $item->cabang }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td style="text-align: center;">{{ $item->unit }}</td>
                        <td class="col-action-body">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route('admin.stocks.edit', $item) }}" class="btn-action-primary">Edit</a>
                                <form action="{{ route('admin.stocks.destroy', $item) }}" method="POST"
                                    style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="28" style="text-align:center; padding:30px 16px; color: #64748b; background: #fff;">
                            <div style="font-size: 1.1rem; margin-bottom: 8px;">Tidak ada data stock untuk ditampilkan.
                            </div>
                        </td>
                    </tr>
                @endempty
        </tbody>
    </table>
</div>

<div style="margin-top:20px; display: flex; justify-content: flex-end;">
    {{ $items->links() }}
</div>
@endsection
