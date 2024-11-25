<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\InputKodePerusahaanController;
use App\Http\Controllers\MenampilkanPerusahaanController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\Masterdata\CoaController;
use App\Http\Controllers\Masterdata\CoaKelompokController;
use App\Http\Controllers\Masterdata\RolesController;
use App\Http\Controllers\Masterdata\BarangController;
use App\Http\Controllers\Masterdata\PelangganController;
use App\Http\Controllers\Masterdata\SupplierController;
use App\Http\Controllers\Masterdata\KaryawanController;
use App\Http\Controllers\Masterdata\JabatanController;
use App\Http\Controllers\Masterdata\UsersController;
use App\Http\Controllers\Masterdata\JasaController;
use App\Http\Controllers\Barang2Controller;
use App\Http\Controllers\Transaksi\PembelianController;
use App\Http\Controllers\Transaksi\PembeliandetailController;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Auth;

// Auth routes
Auth::routes();

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Registration routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Perusahaan routes
Route::middleware('auth')->group(function () {
    Route::get('/registrasiperusahaan', [PerusahaanController::class, 'showCreateForm'])
        ->name('registrasi-perusahaan');
    Route::post('/registrasiperusahaan', [PerusahaanController::class, 'createPerusahaan'])
        ->name('create.perusahaan');

    Route::get('/input-kode-perusahaan', [InputKodePerusahaanController::class, 'showInputForm'])
        ->middleware(['check.perusahaan'])
        ->name('input-kode-perusahaan');
    Route::post('/input-kode-perusahaan', [InputKodePerusahaanController::class, 'handleInputKode'])
        ->middleware(['check.perusahaan'])
        ->name('handle-input-kode');

    Route::get('/perusahaan', [MenampilkanPerusahaanController::class, 'index'])
        ->name('perusahaan.index');
});

// Masterdata routes
Route::prefix('masterdata')->middleware('auth')->group(function () {
    // COA routes
    Route::resource('coa', CoaController::class)->except(['show']);
    Route::post('/coa/store', [CoaController::class, 'store'])->name('coa.store');

    // CoaKelompok routes
    Route::resource('coa-kelompok', CoaKelompokController::class);

    // Roles routes
    Route::resource('user_role', RolesController::class);

    // Barang routes
    Route::resource('barang', BarangController::class);

    // Pelanggan routes
    Route::resource('pelanggan', PelangganController::class);

    // Supplier routes
    Route::resource('supplier', SupplierController::class);

    // Karyawan routes
    Route::resource('karyawan', KaryawanController::class);

    // Jabatan routes
    Route::resource('jabatan', JabatanController::class);

    // Users routes
    Route::resource('users', UsersController::class);

    // Jasa routes
    Route::resource('jasa', JasaController::class);

    // Asset routes
    Route::get('masterdata/aset/{aset}/depreciation', [AssetController::class, 'calculateDepreciation'])->name('aset.depreciation');
    Route::resource('aset', AssetController::class);
});

// Transaksi routes
Route::prefix('transaksi')->middleware('auth')->group(function () {
    Route::resource('/pembelian', PembelianController::class);
    Route::get('/pembelian/{id}/detail', [PembeliandetailController::class, 'index'])->name('pembeliandetail.index');
    Route::post('/pembelian/{id}/detail/store', [PembeliandetailController::class, 'store'])->name('pembeliandetail.store');
    Route::put('/pembelian/detail/{id}', [PembeliandetailController::class, 'update'])->name('pembeliandetail.update');
    Route::delete('/pembelian/detail/{id}', [PembeliandetailController::class, 'destroy'])->name('pembeliandetail.destroy');
});

// Barang2 routes
Route::middleware('auth')->group(function () {
    Route::resource('barang2', Barang2Controller::class);
});
