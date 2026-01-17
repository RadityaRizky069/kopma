<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;

/* ================= HOME ================= */
Route::get('/', [ProductController::class, 'home'])->name('home');
Route::view('/tentang', 'tentang')->name('tentang');

/* ================= AUTH ================= */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* ================= ADMIN ================= */
Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function() {

        Route::get('/', [AdminController::class,'dashboard'])->name('dashboard');

        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);

        Route::get('customers', [AdminController::class,'customers'])->name('customers');

        Route::get('transactions', [TransactionController::class,'index'])->name('transactions');
        Route::post(
            'transactions/{id}/update-status',
            [TransactionController::class,'updateStatus']
        )->name('transactions.updateStatus');

        Route::get('reports', [AdminController::class,'reports'])->name('reports');
});

/* ================= CUSTOMER - PUBLIK (BISA DILIHAT TAMU) ================= */
// Route ini ditaruh DI LUAR middleware supaya Tamu bisa lihat katalog & detail
// Tanpa harus login dulu.
Route::get('products', [ProductController::class,'index'])
    ->name('products.index');

Route::get('products/{id}', [ProductController::class,'show'])
    ->name('products.show');


/* ================= CUSTOMER - PRIVATE (MEMBER ONLY) ================= */
// Route ini yang di-PROTEKSI.
// Kalau Tamu klik tombol "Keranjang", dia akan mengakses route ini,
// lalu dicegat Middleware -> Dilempar ke Login -> Muncul Notif.
Route::middleware(['role:customer'])->group(function() {

    // --- KERANJANG ---
    Route::get('cart', [CartController::class,'index'])
        ->name('cart.index');

    Route::post('cart/add/{id}', [CartController::class,'add'])
        ->name('cart.add');

    Route::patch('cart/update/{id}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('cart/remove/{id}', [CartController::class, 'remove'])
        ->name('cart.remove');

    // --- TRANSAKSI ---
    Route::post('checkout', [TransactionController::class,'checkout'])
        ->name('checkout');

    Route::get('transactions', [TransactionController::class,'customerTransactions'])
        ->name('customer.transactions');
});