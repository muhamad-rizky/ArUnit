<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Stock;
use App\Mail\StockNotificationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendStockEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-stock-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email for stocks that were inputted exactly 3 days ago';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        // Mapping cabang ke daftar email (mirip dengan logic AR)
        $branchEmailLists = [
            'ciawi' => [
                'bm.cwi@suzukidutacendana.com',
            ],
            'cianjur' => [
                'bm.cjr@suzukidutacendana.com',
            ],
            'cinere' => [
                'bm.cnr@suzukidutacendana.com',
            ],
            'jatiasih' => [
                'bm.jts@suzukidutacendana.com',
            ],
            'bp' => [
                'bm.jts@suzukidutacendana.com',
            ],
        ];

        $targetDate = Carbon::now()->subDays(3)->toDateString();
        $stocks = Stock::whereDate('created_at', $targetDate)->get();
        if ($stocks->isEmpty()) {
            $this->info("Tidak ada data stock yang diinput pada {$targetDate}.");
            return;
        }

        // Kelompokkan stock per cabang
        $grouped = $stocks->groupBy('cabang');
        foreach ($grouped as $cabang => $group) {
            $emails = $branchEmailLists[$cabang] ?? [];
            if (!empty($emails)) {
                // Kirim ke semua email dalam array
                Mail::to($emails)->send(new StockNotificationMail($group));
                $this->info("Email stock berhasil dikirim ke cabang {$cabang} ({$cabang}) untuk {$group->count()} record pada {$targetDate}.");
            } else {
                $this->warn("Tidak ada email terdaftar untuk cabang {$cabang}. Skipping.");
            }
        }
    }
}
