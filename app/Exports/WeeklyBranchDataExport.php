<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WeeklyBranchDataExport implements FromView, ShouldAutoSize
{
    protected $branchData;

    public function __construct($branchData)
    {
        $this->branchData = $branchData;
    }

    public function view(): View
    {
        return view('pdf.branch_data_weekly', [
            'branchData' => $this->branchData
        ]);
    }
}
