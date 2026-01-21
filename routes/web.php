<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookingController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return redirect()->route('login'); // Langsung lempar ke halaman login
});

Route::get('/buat-admin', function () {
    $user = User::updateOrCreate(
        ['username' => 'wawan'], 
        [
            'password' =>  Hash::make('123'),
            'no_telp'  => '08123456789'
        ]
    );
    return $user;
});

Route::get('/login', [LoginController::class, 'index'])->name('login'); 
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout'); 

Route::middleware(['auth'])->group(function () {

    Route::get('/cek-ketersediaan', [BookingController::class, 'cekKetersediaan'])->name('cek.ketersediaan');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/reguler', [BookingController::class, 'reguler'])->name('reguler');
    Route::get('/vip-smoking', [BookingController::class, 'vipSmoking'])->name('vip.smoking');
    Route::get('/vip-non-smoking', [BookingController::class, 'vip_nonSmoking'])->name('vip.non.smoking');     

    Route::post('/pembayaran', [BookingController::class, 'pembayaran'])->name('pembayaran');
    Route::post('/pembayaran/konfirmasi', [BookingController::class, 'konfirmasiPembayaran'])->name('pembayaran.konfirmasi');    
});