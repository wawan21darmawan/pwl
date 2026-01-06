<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookingController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// --- HALAMAN PUBLIK (Bisa diakses siapa saja) ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index'])->name('login'); // Ubah jadi controller biar rapi
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout'); // Logout sebaiknya via controller

// --- JALAN PINTAS BUAT USER ADMIN ---
Route::get('/buat-admin', function () {
    
    // Hapus user lama biar gak error duplikat
    User::where('username', 'admin')->delete();

    // Buat User Baru
    User::create([
        'username' => 'admin',
        'password' => Hash::make('123'), // Nah, ini kode yang otomatis mengacak password
        'no_telp'  => '08123456789'
    ]);

    return "BERHASIL! User admin sudah dibuat. <br> Username: <b>admin</b> <br> Password: <b>123</b> <br> No Telp: <b>08123456789</b> <br><br> <a href='/login'>Klik disini untuk Login</a>";
});

// --- HALAMAN KHUSUS MEMBER (Harus Login) ---
// Kita grupkan dengan middleware 'auth'
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Booking (Sesuai route kamu)
    Route::get('/reguler', [BookingController::class, 'reguler'])->name('reguler');
    Route::get('/vip-smoking', [BookingController::class, 'vipSmoking'])->name('vip.smoking');
    Route::get('/vip-non-smoking', [BookingController::class, 'vip_nonSmoking'])->name('vip.non.smoking');     

    // Proses Pembayaran
    Route::post('/pembayaran', [BookingController::class, 'pembayaran'])->name('pembayaran');
    Route::post('/pembayaran/konfirmasi', [BookingController::class, 'konfirmasiPembayaran'])->name('pembayaran.konfirmasi');    
});