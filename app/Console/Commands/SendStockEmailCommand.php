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
        $branchEmails = [
        'ciawi' => 'bm.cwi@suzukidutacendana.com',
        'cianjur' => 'bm.cjr@suzukidutacendana.com',
        'cinere' => 'bm.cnr@suzukidutacendana.com',
        'jatiasih' => 'bm.jts@suzukidutacendana.com',
        'bp' => 'bm.jts@suzukidutacendana.com',
    ];
    $targetDate = Carbon::now()->subDays(3)->toDateString();
        $stocks = Stock::whereDate('created_at', $targetDate)->get();
    if ($stocks->isEmpty()) {
        $this->info("Tidak ada data stock yang diinput pada {$targetDate}.");
        return;
    }
    $grouped = $stocks->groupBy('cabang');
    foreach ($grouped as $cabang => $group) {
        $email = $branchEmails[$cabang] ?? null;
        if ($email) {
            Mail::to($email)->send(new StockNotificationMail($group));
            $this->info("Email berhasil dikirim ke {$email} untuk {$group->count()} stock cabang {$cabang} pada {$targetDate}.");
        } else {
            $this->warn("Tidak ada email terdaftar untuk cabang {$cabang}. Skipping.");
        }
    }
    }
}
