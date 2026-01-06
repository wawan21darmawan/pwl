<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [LoginController::class, 'login']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/reguler', [BookingController::class, 'reguler'])
    ->name('reguler');

Route::get('/vip-smoking', [BookingController::class, 'vipSmoking'])
    ->name('vip.smoking'); 
 
Route::get('/vip-non-smoking', [BookingController::class, 'vip_nonSmoking'])
    ->name('vip.non.smoking');     

Route::post('/pembayaran', [BookingController::class, 'pembayaran'])
    ->name('pembayaran');
 
Route::post('/pembayaran/konfirmasi', [BookingController::class, 'konfirmasiPembayaran'])
    ->name('pembayaran.konfirmasi');    

Route::get('/logout', function () {
    return redirect('/login');
})->name('logout');
