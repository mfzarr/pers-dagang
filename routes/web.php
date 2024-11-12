<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\InputKodePerusahaanController;
use App\Http\Controllers\MenampilkanPerusahaanController;
use App\Http\Controllers\PerusahaanController;

// Built-in auth routes
Auth::routes();

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Custom Registration routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Perusahaan routes (aliased as UserPerusahaanController)
Route::get('/registrasiperusahaan', [PerusahaanController::class, 'showCreateForm'])
    ->middleware('auth')  
    ->name('registrasi-perusahaan');
Route::post('/registrasiperusahaan', [PerusahaanController::class, 'createPerusahaan'])
    ->middleware('auth')  
    ->name('create.perusahaan');

// Input Kode Perusahaan routes
Route::get('/input-kode-perusahaan', [InputKodePerusahaanController::class, 'showInputForm'])
    ->middleware(['auth', 'check.perusahaan'])
    ->name('input-kode-perusahaan');

Route::post('/input-kode-perusahaan', [InputKodePerusahaanController::class, 'handleInputKode'])
    ->middleware(['auth', 'check.perusahaan'])
    ->name('handle-input-kode');

// Menampilkan perusahaan route
Route::get('/perusahaan', [MenampilkanPerusahaanController::class, 'index'])
    ->middleware('auth')
    ->name('perusahaan.index');

 // Masterdata routes (aliased as MasterdataPerusahaanController)
use App\Http\Controllers\Masterdata\PerusahaanController as MasterdataPerusahaanController;

use App\Http\Controllers\Masterdata\RolesController;
use App\Http\Controllers\Masterdata\CoaController;

use App\Http\Controllers\Masterdata\BarangController;

use App\Http\Controllers\StokBarangController;

Route::prefix('masterdata')->group(function () {
    // Route::get('users/main', [UsersController::class, 'main'])->name('user.main');
    Route::resource('user_role', RolesController::class);
    Route::resource('coas', CoaController::class);
    // Route::resource('jabatan', JabatanController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('stokBarang', StokBarangController::class);
    
    
});

// // Transaksi routes
// use App\Http\Controllers\Transaksi\PembelianController;
// use App\Http\Controllers\Transaksi\PembeliandetailController;
// use App\Http\Controllers\Transaksi\PenjualanController;
// use App\Http\Controllers\Transaksi\PenggajianController;
// use App\Http\Controllers\Transaksi\PelunasanController;

// Route::prefix('transaksi')->group(function () {
//     Route::resource('/pembelian', PembelianController::class);
//     Route::resource('/pembeliandetail', PembeliandetailController::class);
//     Route::get('/pembelian-detail/{id_pembelian}', [PembelianDetailController::class, 'index'])->name('pembeliandetail.index');
//     Route::post('/pembeliandetail/store', [PembelianDetailController::class, 'store'])->name('pembeliandetail.store');
//     Route::post('/pembeliandetail/save', [PembelianDetailController::class, 'save'])->name('pembeliandetail.save');
//     Route::post('/pembelian-detail/{id_pembelian}/pelunasan', [PembelianDetailController::class, 'pelunasan'])->name('pembeliandetail.pelunasan');

//     // Other transaksi routes can go here
// });


use App\Http\Controllers\Barang2Controller;

Route::resource('barang2', Barang2Controller::class);

use App\Http\Controllers\Masterdata\PelangganController;

Route::resource('pelanggan', PelangganController::class);

use App\Http\Controllers\Masterdata\SupplierController;

Route::resource('supplier', SupplierController::class);

use App\Http\Controllers\Masterdata\KaryawanController;

Route::resource('karyawan', KaryawanController::class);

use App\Http\Controllers\Masterdata\JabatanController;

Route::resource('jabatan', JabatanController::class);


use App\Http\Controllers\Masterdata\UsersController;

Route::middleware(['auth'])->group(function () {
    Route::resource('users', UsersController::class);
});

use App\Http\Controllers\Masterdata\JasaController;
Route::resource('jasa', JasaController::class);


use App\Http\Controllers\Transaksi\PembelianController;
use App\Http\Controllers\Transaksi\PembeliandetailController;

Route::resource('pembelian', PembelianController::class);
Route::get('pembelian/{id}/detail', [PembeliandetailController::class, 'index'])->name('pembeliandetail.index');
Route::post('pembelian/{id}/detail/store', [PembeliandetailController::class, 'store'])->name('pembeliandetail.store');
Route::put('pembelian/detail/{id}', [PembeliandetailController::class, 'update'])->name('pembeliandetail.update');
Route::delete('pembelian/detail/{id}', [PembeliandetailController::class, 'destroy'])->name('pembeliandetail.destroy');

