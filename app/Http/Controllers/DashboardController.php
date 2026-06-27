<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Ambil data Piutang berdasarkan Role
        if (! empty($user) && ($user->is_admin ?? false)) {
            $records = Piutang::orderByDesc('id')->get();
        } else {
            // Ditambahkan fallback ?? '' agar tidak error jika branch kosong/null
            $records = Piutang::where('branch', $user->branch ?? '')->orderByDesc('id')->get();
        }

        $branchFilter = strtolower(request()->query('branch', ''));
        $allowedBranches = ['bp', 'cinere', 'jatiasih', 'cianjur', 'ciawi'];
        $selectedBranch = in_array($branchFilter, $allowedBranches, true) ? $branchFilter : null;
        $filteredRecords = $selectedBranch ? $records->where('branch', $selectedBranch) : $records;

        $totalPiutang = $records->sum('saldo_akhir');
        $totalKonsumen = $records->map(function ($r) {
            return $r->no_spk ?: $r->nama_konsumen;
        })->filter()->unique()->count();
        
        $totalAsuransi = $records->where('spk_type', 'ASURANSI')->count();
        $totalDebet = $records->sum('debet');
        $totalKredit = $records->sum('kredit');
        
        $bpInsuranceTotals = Piutang::where('branch', 'bp')
            ->where('spk_type', 'ASURANSI')
            ->whereNotNull('nama_asuransi')
            ->where('nama_asuransi', '<>', '')
            ->selectRaw('nama_asuransi, COUNT(*) as total')
            ->groupBy('nama_asuransi')
            ->orderByDesc('total')
            ->get();
            
        $grBranchCount = $records->where('branch', '!=', 'bp')->pluck('branch')->unique()->count();
        $totalSelisih = $records->sum(function ($item) {
            return ($item->saldo_awal + $item->debet - $item->kredit) - $item->saldo_akhir;
        });
        
        $branchSummaries = $records->groupBy('branch')->map(function ($group, $branch) {
            return [
                'count' => $group->count(),
                'saldo_akhir' => $group->sum('saldo_akhir'),
                'debet' => $group->sum('debet'),
                'kredit' => $group->sum('kredit'),
            ];
        })->sortByDesc(function ($summary) {
            return $summary['count'];
        })->toArray();

        // 2. Ambil data STOCK (Hanya dijalankan jika user punya akses Admin / Admin Stock)
        $totalStock = 0;
        $stockByStatus = [];
        $stockByMobil = collect();

        if (! empty($user) && (($user->is_admin ?? false) || ($user->is_admin_stock ?? false))) {
            $totalStock = Stock::count();
            $stockByStatus = Stock::selectRaw('LOWER(status) as status_lower, COUNT(*) as total')
                ->groupBy('status_lower')
                ->pluck('total', 'status_lower')
                ->toArray();
            $imageMap = [
                'NEW CARRY'     => 'Suzuki-Carry.webp',
                'APV'           => 'Suzuki-Apv.png',
                'ERTIGA-HYBRID' => 'Suzuki-Ertiga-Hybrid.webp',
                'XL7-HYBRID'    => 'XL7_Hybrid.webp',
                'GRAND-VITARA'  => 'Grand-Vitara.webp',
                'JIMMY'         => 'Jimmy.png',
                'FRONX'         => 'suzuki-fronx.png',
            ];

            // Ambil semua stock, lalu kelompokkan per nama_mobil
            $rawStocks  = Stock::whereNotNull('nama_mobil')->where('nama_mobil', '!=', '')->get();
            $groupedByMobil = $rawStocks->groupBy('nama_mobil');

            // Bangun dari imageMap agar semua mobil selalu tampil (walaupun stok = 0)
            $stockByMobil = collect($imageMap)->map(function ($imageFile, $namaMobil) use ($groupedByMobil) {
                $group = $groupedByMobil->get($namaMobil, collect());

                $varianCounts = $group->whereNotNull('varian')
                    ->groupBy('varian')
                    ->map(fn($g) => $g->count());

                $warnaCounts = $group->whereNotNull('warna')
                    ->groupBy('warna')
                    ->map(fn($g) => $g->count());

                return (object)[
                    'nama_mobil'    => $namaMobil,
                    'total'         => $group->count(),
                    'varian_counts' => $varianCounts,
                    'warna_counts'  => $warnaCounts,
                    'varians'       => $varianCounts->keys(),
                    'warnas'        => $warnaCounts->keys(),
                    'image'         => $imageFile,
                ];
            })->sortByDesc('total')->values();
        }

        return view('dashboard', [
            'records' => $records,
            'totalPiutang' => $totalPiutang,
            'totalKonsumen' => $totalKonsumen,
            'totalAsuransi' => $totalAsuransi,
            'totalDebet' => $totalDebet,
            'totalKredit' => $totalKredit,
            'bpInsuranceTotals' => $bpInsuranceTotals,
            'grBranchCount' => $grBranchCount,
            'totalSelisih' => $totalSelisih,
            'branchSummaries' => $branchSummaries,
            'summaryBranches' => $branchSummaries,
            'selectedBranch' => $selectedBranch,
            'recentRecords' => $selectedBranch ? $filteredRecords : $records->take(10),
            'selectedRecords' => $filteredRecords,
            'totalStock' => $totalStock,
            'stockByStatus' => $stockByStatus,
            'stockByMobil' => $stockByMobil,
        ]);
    }
}
