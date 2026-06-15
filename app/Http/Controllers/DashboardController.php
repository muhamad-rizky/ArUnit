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

        if (! empty($user) && ($user->is_admin ?? false)) {
            $records = Piutang::orderByDesc('id')->get();
        } else {
            $records = Piutang::where('branch', $user->branch)->orderByDesc('id')->get();
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

        // STOCK DATA
        $totalStock = Stock::count();
        $stockByStatus = Stock::selectRaw('LOWER(status) as status_lower, COUNT(*) as total')
            ->groupBy('status_lower')
            ->pluck('total', 'status_lower')
            ->toArray();
        $stockByMobil = Stock::selectRaw('nama_mobil, COUNT(*) as total')
            ->whereNotNull('nama_mobil')
            ->where('nama_mobil', '!=', '')
            ->groupBy('nama_mobil')
            ->orderByDesc('total')
            ->get();

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
