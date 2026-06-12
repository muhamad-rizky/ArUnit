<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/bp', [PiutangController::class, 'indexBp']);
    Route::post('/bp', [PiutangController::class, 'storeBp']);
    Route::get('/bp/{id}/edit', [PiutangController::class, 'editBp'])->whereNumber('id');
    Route::put('/bp/{id}', [PiutangController::class, 'updateBp'])->whereNumber('id');
    Route::delete('/bp/{id}', [PiutangController::class, 'destroyBp'])->whereNumber('id');

    Route::get('/gr/{branch}', [PiutangController::class, 'indexGr'])
        ->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi']);
    Route::post('/gr/{branch}', [PiutangController::class, 'storeGr'])
        ->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi']);
    Route::get('/gr/{branch}/{id}/edit', [PiutangController::class, 'editGr'])
        ->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi'])
        ->whereNumber('id');
    Route::put('/gr/{branch}/{id}', [PiutangController::class, 'updateGr'])
        ->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi'])
        ->whereNumber('id');
    Route::delete('/gr/{branch}/{id}', [PiutangController::class, 'destroyGr'])
        ->whereIn('branch', ['cinere', 'jatiasih', 'cianjur', 'ciawi'])
        ->whereNumber('id');

    // Simple JSON endpoint to provide Asuransi list for AJAX dropdowns
    Route::get('/asuransi/list', function () {
        return \App\Models\Asuransi::select('id', 'nama')->orderBy('nama')->get();
    })->name('asuransi.list');

    // Admin area (basic authorization inside controllers/views checks is_admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/asuransi', [App\Http\Controllers\AsuransiController::class, 'index'])->name('asuransi.index');
        Route::get('/asuransi/create', [App\Http\Controllers\AsuransiController::class, 'create'])->name('asuransi.create');
        Route::post('/asuransi', [App\Http\Controllers\AsuransiController::class, 'store'])->name('asuransi.store');
        Route::get('/asuransi/{asuransi}/edit', [App\Http\Controllers\AsuransiController::class, 'edit'])->name('asuransi.edit');
        Route::put('/asuransi/{asuransi}', [App\Http\Controllers\AsuransiController::class, 'update'])->name('asuransi.update');
        Route::delete('/asuransi/{asuransi}', [App\Http\Controllers\AsuransiController::class, 'destroy'])->name('asuransi.destroy');

        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/perusahaan', [App\Http\Controllers\PerusahaanController::class, 'index'])->name('perusahaan.index');
        Route::get('/perusahaan/create', [App\Http\Controllers\PerusahaanController::class, 'create'])->name('perusahaan.create');
        Route::post('/perusahaan', [App\Http\Controllers\PerusahaanController::class, 'store'])->name('perusahaan.store');
        Route::get('/perusahaan/{perusahaan}/edit', [App\Http\Controllers\PerusahaanController::class, 'edit'])->name('perusahaan.edit');
        Route::put('/perusahaan/{perusahaan}', [App\Http\Controllers\PerusahaanController::class, 'update'])->name('perusahaan.update');
        Route::delete('/perusahaan/{perusahaan}', [App\Http\Controllers\PerusahaanController::class, 'destroy'])->name('perusahaan.destroy');
    });
});

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

Route::get('/bersihin-cache-it', function() {
    Artisan::call('config:clear');
    return "MANTAP! Cache .env Suzuki Duta Cendana berhasil dihapus tanpa terminal!";
});


use Illuminate\Support\Facades\Schema;

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

    Artisan::call('migrate', [
        '--force' => true
    ]);

    return nl2br(Artisan::output());
});

use Illuminate\Database\Schema\Blueprint;

Route::get('/fix-kolom-piutang', function () {

    Schema::table('piutangs', function (Blueprint $table) {

        if (!Schema::hasColumn('piutangs', 'tipe_konsumen')) {
            $table->string('tipe_konsumen')
                ->default('reguler')
                ->after('nama_konsumen');
        }

        if (!Schema::hasColumn('piutangs', 'perusahaan_id')) {
            $table->unsignedBigInteger('perusahaan_id')
                ->nullable()
                ->after('tipe_konsumen');
        }
    });

    return [
        'tipe_konsumen' => Schema::hasColumn('piutangs', 'tipe_konsumen'),
        'perusahaan_id' => Schema::hasColumn('piutangs', 'perusahaan_id'),
    ];
});


Route::get('/ubah-default-tipe-konsumen', function () {

    DB::statement("
        ALTER TABLE piutangs
        MODIFY tipe_konsumen VARCHAR(255) NULL DEFAULT NULL
    ");

    return 'Default tipe_konsumen berhasil dihapus';
});

Route::get('/reset-tipe-konsumen', function () {

    DB::table('piutangs')
        ->where('tipe_konsumen', 'reguler')
        ->update([
            'tipe_konsumen' => null
        ]);

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
            $table->integer('overdue')
                  ->default(28)
                  ->after('deskripsi');
        });

        return 'Kolom overdue berhasil ditambahkan';
    }

    return 'Kolom overdue sudah ada';
});

use App\Models\Piutang;
use Carbon\Carbon;

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