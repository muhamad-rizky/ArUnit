<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 11px; }
        th, td { border: 1px solid #ddd; padding: 8px 6px; text-align: left; }
        th { background-color: #1e293b; color: white; text-transform: uppercase; font-size: 10px; }
        .header { background: #1e293b; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; border: 1px solid #ddd; border-top: none; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Notifikasi Stock Kendaraan per Cabang</h2>
    </div>
    <div class="content">
        <p>Halo Team,</p>
        <p>Berikut adalah daftar data stock berdasarkan <strong>Tanggal DO</strong> 3 hari yang lalu:</p>
        
        <table>
            <thead>
                <tr>
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
                    <th>LOKASI</th>
                    <th>STATUS</th>
                    <th>CABANG</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $stock)
                <tr>
                    <td>{{ $stock->no_do }}</td>
                    <td class="text-center">{{ $stock->tanggal_do ? \Carbon\Carbon::parse($stock->tanggal_do)->format('d-M-Y') : '-' }}</td>
                    <td>{{ $stock->kode_mobil }}</td>
                    <td>{{ $stock->nama_mobil }}</td>
                    <td>{{ $stock->warna }}</td>
                    <td class="text-center">{{ $stock->tahun }}</td>
                    <td>{{ $stock->chassis_code }}</td>
                    <td>{{ $stock->norangka }}</td>
                    <td>{{ $stock->engine_code }}</td>
                    <td>{{ $stock->nomesin }}</td>
                    <td>{{ $stock->faktur }}</td>
                    <td>{{ $stock->bln_naik_faktur }}</td>
                    <td>{{ strtoupper($stock->lokasi) }}</td>
                    <td class="text-center">{{ strtoupper($stock->status ?? '-') }}</td>
                    <td>{{ strtoupper($stock->cabang) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="15" style="text-align:center; font-weight: bold;">Tidak ada data stock untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <p style="margin-top: 20px;"><em>Email ini dikirimkan secara otomatis oleh sistem scheduling ArUnit.</em></p>
    </div>
</body>
</html>