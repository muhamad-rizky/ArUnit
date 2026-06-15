<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 13px; }
        th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .header { background: #1e293b; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; border: 1px solid #ddd; border-top: none; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Notifikasi Stock Kendaraan</h2>
    </div>
    <div class="content">
        <p>Halo Admin,</p>
        <p>Berikut adalah daftar data stock yang di-input 3 hari yang lalu:</p>
        
        <table>
            <thead>
                <tr>
                    <th>NO DO</th>
                    <th>TANGGAL DO</th>
                    <th>NAMA MOBIL</th>
                    <th>WARNA</th>
                    <th>TAHUN</th>
                    <th>NO RANGKA</th>
                    <th>NO MESIN</th>
                    <th>LOKASI</th>
                    <th>STATUS</th>
                    <th>CABANG</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $stock)
                <tr>
                    <td>{{ $stock->no_do }}</td>
                    <td>{{ $stock->tanggal_do ? \Carbon\Carbon::parse($stock->tanggal_do)->format('d-M-Y') : '-' }}</td>
                    <td>{{ $stock->nama_mobil }}</td>
                    <td>{{ $stock->warna }}</td>
                    <td>{{ $stock->tahun }}</td>
                    <td>{{ $stock->norangka }}</td>
                    <td>{{ $stock->nomesin }}</td>
                    <td>{{ $stock->lokasi }}</td>
                    <td>{{ strtoupper($stock->status ?? '-') }}</td>
                    <td>{{ $stock->cabang }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;">Tidak ada data stock untuk hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <p style="margin-top: 20px;"><em>Email ini dikirimkan secara otomatis oleh sistem.</em></p>
    </div>
</body>
</html>
