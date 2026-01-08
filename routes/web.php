<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
});

// ===================== AUTH =====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===================== ADMIN =====================
Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function() {

    // Dashboard
    Route::get('/', [AdminController::class,'dashboard'])->name('dashboard');

    // Produk
    Route::resource('products', ProductController::class);

    // Kategori
    Route::resource('categories', CategoryController::class);

    // Customer
    Route::get('customers', [AdminController::class,'customers'])->name('customers');

    // Transaksi
    Route::get('transactions', [TransactionController::class,'index'])->name('transactions');
    Route::post('transactions/{id}/update-status', [TransactionController::class,'updateStatus'])
        ->name('transactions.updateStatus');

    // Laporan
    Route::get('reports', [AdminController::class,'reports'])->name('reports');
});

// ===================== CUSTOMER =====================
Route::middleware(['auth','role:customer'])->group(function() {

    // Produk
    Route::get('products', [ProductController::class,'index'])->name('products.index');
    Route::get('products/{id}', [ProductController::class,'show'])->name('products.show');

    // Keranjang
    Route::post('cart/add/{id}', [CartController::class,'add'])->name('cart.add');
    Route::get('cart', [CartController::class,'index'])->name('cart.index');

    // Checkout
    Route::post('checkout', [TransactionController::class,'checkout'])->name('checkout');

    // Riwayat transaksi
    Route::get('transactions', [TransactionController::class,'customerTransactions'])
        ->name('customer.transactions');
});
