<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        // Auto-update status 'matching' to 'free' if it's been more than 3 days
        Stock::where('status', 'matching')
             ->where('updated_at', '<', now()->subDays(3))
             ->update(['status' => 'free']);

        $search = $request->input('search');
        $query = Stock::query();

        // Perbaikan: Menggunakan Logical Grouping (Closure) untuk orWhere agar aman
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mobil', 'LIKE', "%{$search}%")
                  ->orWhere('no_do', 'LIKE', "%{$search}%")
                  ->orWhere('norangka', 'LIKE', "%{$search}%");
            });
        }

        $items = $query->latest()->paginate(15);
        return view('admin.stocks.index', compact('items', 'search'));
    }

    public function create()
    {
        $namaMobilOptions = Stock::whereNotNull('nama_mobil')->where('nama_mobil', '!=', '')->distinct()->orderBy('nama_mobil')->pluck('nama_mobil');
        $kodeMobilOptions = Stock::whereNotNull('kode_mobil')->where('kode_mobil', '!=', '')->distinct()->orderBy('kode_mobil')->pluck('kode_mobil');
        $warnaOptions = Stock::whereNotNull('warna')->where('warna', '!=', '')->distinct()->orderBy('warna')->pluck('warna');

        return view('admin.stocks.create', compact('namaMobilOptions', 'kodeMobilOptions', 'warnaOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_do' => 'nullable|string|max:255',
            'tanggal_do' => 'nullable|date',
            'kode_mobil' => 'nullable|string|max:255',
            'nama_mobil' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer',
            'chassis_code' => 'nullable|string|max:255',
            'norangka' => 'nullable|string|max:255',
            'enginecode' => 'nullable|string|max:255',
            'nomesin' => 'nullable|string|max:255',
            'faktur' => 'nullable|string|max:255',
            'bln_naik_faktur' => 'nullable|string|max:255',
            'harga' => 'nullable|integer',
            'kpt_kf' => 'nullable|integer',
            'acs2' => 'nullable|integer',
            'subsidi' => 'nullable|integer',
            'hpp' => 'nullable|integer',
            'lokasi' => 'nullable|string|max:255',
            'estimasi_unit_masuk_gudang_dca' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'lain_lain' => 'nullable|string|max:255',
            'penjualan' => 'nullable|string|max:255',
            'tanggal_matching_do' => 'nullable|date',
            'cabang' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
        ]);

        $validated['hpp'] = ($validated['harga'] ?? 0) + ($validated['kpt_kf'] ?? 0) + ($validated['acs2'] ?? 0) - ($validated['subsidi'] ?? 0);

        Stock::create($validated);

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Data stock berhasil ditambahkan.');
    }

    public function edit(Stock $stock)
    {
        $namaMobilOptions = Stock::whereNotNull('nama_mobil')->where('nama_mobil', '!=', '')->distinct()->orderBy('nama_mobil')->pluck('nama_mobil');
        $kodeMobilOptions = Stock::whereNotNull('kode_mobil')->where('kode_mobil', '!=', '')->distinct()->orderBy('kode_mobil')->pluck('kode_mobil');
        $warnaOptions = Stock::whereNotNull('warna')->where('warna', '!=', '')->distinct()->orderBy('warna')->pluck('warna');

        return view('admin.stocks.edit', compact('stock', 'namaMobilOptions', 'kodeMobilOptions', 'warnaOptions'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'no_do' => 'nullable|string|max:255',
            'tanggal_do' => 'nullable|date',
            'kode_mobil' => 'nullable|string|max:255',
            'nama_mobil' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer',
            'chassis_code' => 'nullable|string|max:255',
            'norangka' => 'nullable|string|max:255',
            'enginecode' => 'nullable|string|max:255',
            'nomesin' => 'nullable|string|max:255',
            'faktur' => 'nullable|string|max:255',
            'bln_naik_faktur' => 'nullable|string|max:255',
            'harga' => 'nullable|integer',
            'kpt_kf' => 'nullable|integer',
            'acs2' => 'nullable|integer',
            'subsidi' => 'nullable|integer',
            'hpp' => 'nullable|integer',
            'lokasi' => 'nullable|string|max:255',
            'estimasi_unit_masuk_gudang_dca' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'lain_lain' => 'nullable|string|max:255',
            'penjualan' => 'nullable|string|max:255',
            'tanggal_matching_do' => 'nullable|date',
            'cabang' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
        ]);

        $validated['hpp'] = ($validated['harga'] ?? 0) + ($validated['kpt_kf'] ?? 0) + ($validated['acs2'] ?? 0) - ($validated['subsidi'] ?? 0);

        $stock->update($validated);

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Data stock berhasil diperbarui.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Data stock berhasil dihapus.');
    }
}