<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Stock;
use App\Mail\StockNotificationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendStockEmailCommand extends Command
{
    protected $signature = 'app:send-stock-email';
    protected $description = 'Send email for all stocks based on Tanggal DO exactly 3 days ago to all recipients';

    public function handle()
    {
        $this->info('Mulai mengecek semua data stock berdasarkan Tanggal DO 3 hari yang lalu...');

        $semuaPenerima = [
            'bm.cwi@suzukidutacendana.com',
            'bm.cjr@suzukidutacendana.com',
            'bm.cnr@suzukidutacendana.com',
            'bm.jts@suzukidutacendana.com',
            'it@dutacendana.com',
            'ahmadmad122131@gmail.com',
            'm.rizky@smkwikrama.sch.id'
        ];

        $targetDate = Carbon::now('Asia/Jakarta')->subDays(3)->toDateString();

        $stocks = Stock::whereDate('tanggal_do', $targetDate)->get();

        // $stocks = Stock::whereDate('created_at', $targetDate)->get();

        if ($stocks->isEmpty()) {
            $this->info("Tidak ada data stock dengan Tanggal DO {$targetDate}.");
            return;
        }

        Mail::mailer('smtp_stock')
            ->to($semuaPenerima)
            ->send(new StockNotificationMail($stocks));

        $this->info("Email stock sukses dikirim ke seluruh BM, IT & Admin (Total: {$stocks->count()} unit pada {$targetDate}).");
        $this->info('Selesai memproses email stock.');
    }
}
