<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AsuransiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\VarianController;
use App\Http\Controllers\WarnaController;
use App\Http\Controllers\Admin\GudangController;
use App\Http\Controllers\Admin\CabangController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    
    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/bp', [PiutangController::class, 'indexBp']);
    Route::post('/bp', [PiutangController::class, 'storeBp']);
    Route::get('/bp/{id}/edit', [PiutangController::class, 'editBp'])->whereNumber('id');
    Route::put('/bp/{id}', [PiutangController::class, 'updateBp'])->whereNumber('id');
    Route::delete('/bp/{id}', [PiutangController::class, 'destroyBp'])->whereNumber('id');

    Route::prefix('gr/{branch}')->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi'])->group(function () {
        Route::get('/', [PiutangController::class, 'indexGr']);
        Route::post('/', [PiutangController::class, 'storeGr']);
        Route::get('/{id}/edit', [PiutangController::class, 'editGr'])->whereNumber('id');
        Route::put('/{id}', [PiutangController::class, 'updateGr'])->whereNumber('id');
        Route::delete('/{id}', [PiutangController::class, 'destroyGr'])->whereNumber('id');
    });

    Route::get('/asuransi/list', function () {
        return \App\Models\Asuransi::select('id', 'nama')->orderBy('nama')->get();
    })->name('asuransi.list');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('asuransi', AsuransiController::class);
        Route::resource('users', UserController::class);
        Route::resource('perusahaan', PerusahaanController::class);
        
        Route::get('stocks/export-pdf', [StockController::class, 'exportPdf'])->name('stocks.exportPdf');
        Route::get('stocks/export-excel', [StockController::class, 'exportExcel'])->name('stocks.exportExcel');
        Route::get('stocks/print', [StockController::class, 'print'])->name('stocks.print');
        Route::resource('stocks', StockController::class);
        
        Route::resource('units', UnitController::class);
        Route::resource('varians', VarianController::class);
        Route::resource('warnas', WarnaController::class);
        Route::resource('gudangs', GudangController::class);
        Route::resource('cabangs', CabangController::class);
        Route::resource('in-units', \App\Http\Controllers\InUnitController::class);
    });

    Route::prefix('dev-tools')->group(function () {
        
        Route::get('/bersihin-cache-it', function() {
            Artisan::call('config:clear');
            return "MANTAP! Cache .env Suzuki Duta Cendana berhasil dihapus tanpa terminal!";
        });

        Route::get('/cek-kolom-piutang', function () {
            return [
                'tipe_konsumen' => Schema::hasColumn('piutangs', 'tipe_konsumen'),
                'perusahaan_id' => Schema::hasColumn('piutangs', 'perusahaan_id'),
            ];
        });

        Route::get('/cek-migration-perusahaan', function () {
            return DB::table('migrations')
                ->where('migration', 'like', '%perusahaan%')
                ->orWhere('migration', 'like', '%tipe_konsumen%')
                ->get();
        });

        Route::get('/jalankan-migrate', function () {
            Artisan::call('migrate', ['--force' => true]);
            return nl2br(Artisan::output());
        });

        Route::get('/fix-kolom-piutang', function () {
            Schema::table('piutangs', function (Blueprint $table) {
                if (!Schema::hasColumn('piutangs', 'tipe_konsumen')) {
                    $table->string('tipe_konsumen')->default('reguler')->after('nama_konsumen');
                }
                if (!Schema::hasColumn('piutangs', 'perusahaan_id')) {
                    $table->unsignedBigInteger('perusahaan_id')->nullable()->after('tipe_konsumen');
                }
            });
            return [
                'tipe_konsumen' => Schema::hasColumn('piutangs', 'tipe_konsumen'),
                'perusahaan_id' => Schema::hasColumn('piutangs', 'perusahaan_id'),
            ];
        });

        Route::get('/ubah-default-tipe-konsumen', function () {
            DB::statement("ALTER TABLE piutangs MODIFY tipe_konsumen VARCHAR(255) NULL DEFAULT NULL");
            return 'Default tipe_konsumen berhasil dihapus';
        });

        Route::get('/reset-tipe-konsumen', function () {
            DB::table('piutangs')->where('tipe_konsumen', 'reguler')->update(['tipe_konsumen' => null]);
            return 'Berhasil reset';
        });

        Route::get('/kirim-laporan-rabu', function () {
            if (now()->isWednesday()) {
                Artisan::call('app:send-weekly-branch-data-email');
                return 'Email berhasil dikirim';
            }
            return 'Hari ini bukan Rabu';
        });

        Route::get('/fix-overdue-perusahaan', function () {
            if (!Schema::hasColumn('perusahaan', 'overdue')) {
                Schema::table('perusahaan', function ($table) {
                    $table->integer('overdue')->default(28)->after('deskripsi');
                });
                return 'Kolom overdue berhasil ditambahkan';
            }
            return 'Kolom overdue sudah ada';
        });

        Route::get('/kirim-laporan-sekarang', function() {
            Artisan::call('app:send-weekly-branch-data-email');
            return nl2br(Artisan::output());
        });

        Route::get('/clear-optimize', function () {
            Artisan::call('optimize:clear');
            return '<pre>' . Artisan::output() . '</pre>';
        });

        Route::get('/test-schedule', function () {
            Artisan::call('schedule:list');
            return '<pre>' . Artisan::output() . '</pre>';
        });

        Route::get('/cek-schedule-file', function () {
            return file_get_contents(base_path('routes/console.php'));
        });

        Route::get('/cek-jam', function () {
            return [
                'utc' => now()->toDateTimeString(),
                'jakarta' => now('Asia/Jakarta')->toDateTimeString(),
            ];
        });
    });

});