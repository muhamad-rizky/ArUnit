<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Unit;
use App\Models\Warna;
use App\Models\Varian;
use App\Models\Gudang;
use App\Models\Cabang;
use Illuminate\Http\Request;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $lokasiFilter = $request->input('lokasi');
        if ($lokasiFilter) {
            $query->where('lokasi', $lokasiFilter);
        }

        $items = $query->latest()->paginate(15);
        
        $gudangOptions = \App\Models\Gudang::orderBy('nama')->pluck('nama', 'nama');
        
        return view('admin.stocks.index', compact('items', 'search', 'lokasiFilter', 'gudangOptions'));
    }

    public function create()
    {
        $namaMobilOptions = Unit::orderBy('nama')->pluck('nama', 'nama');
        $warnaOptions = Warna::orderBy('nama')->pluck('nama', 'nama');
        $varianOptions = Varian::orderBy('nama')->pluck('nama', 'nama');
        $gudangOptions = Gudang::orderBy('nama')->pluck('nama', 'nama');
        $cabangOptions = Cabang::orderBy('nama')->pluck('nama', 'nama');

        return view('admin.stocks.create', compact('namaMobilOptions', 'warnaOptions', 'varianOptions', 'gudangOptions', 'cabangOptions'));
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
            'varian' => 'nullable|string|max:255',
        ]);

        $validated['hpp'] = ($validated['harga'] ?? 0) + ($validated['kpt_kf'] ?? 0) + ($validated['acs2'] ?? 0) - ($validated['subsidi'] ?? 0);

        Stock::create($validated);

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Data stock berhasil ditambahkan.');
    }

    public function edit(Stock $stock)
    {
        $namaMobilOptions = Unit::orderBy('nama')->pluck('nama', 'nama');
        $warnaOptions = Warna::orderBy('nama')->pluck('nama', 'nama');
        $varianOptions = Varian::orderBy('nama')->pluck('nama', 'nama');
        $gudangOptions = Gudang::orderBy('nama')->pluck('nama', 'nama');
        $cabangOptions = Cabang::orderBy('nama')->pluck('nama', 'nama');

        return view('admin.stocks.edit', compact('stock', 'namaMobilOptions', 'warnaOptions', 'varianOptions', 'gudangOptions', 'cabangOptions'));
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
            'varian' => 'nullable|string|max:255',
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

    public function exportExcel()
    {
        return Excel::download(new StockExport, 'stock.xlsx');
    }

    public function exportPdf()
    {
        $items = Stock::all();
        $pdf = Pdf::loadView('admin.stocks.pdf', compact('items'))->setPaper('a4', 'landscape');
        return $pdf->download('stock.pdf');
    }

    public function print()
    {
        $items = Stock::all();
        return view('admin.stocks.print', compact('items'));
    }
}
