<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

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
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Manajemen Produk & Kategori
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);

        // Manajemen Customer
        Route::get('customers', [AdminController::class, 'customers'])->name('customers');

        // --- Transaksi Admin ---
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions');
        Route::post('transactions/{id}/update-status', [TransactionController::class, 'updateStatus'])
            ->name('transactions.updateStatus');

        // --- Laporan ---
        Route::get('reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('reports/export', [AdminController::class, 'exportReports'])->name('reports.export');
    });

/* ================= CUSTOMER - PUBLIK ================= */
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');

/* ================= FITUR UMUM (LOGIN REQUIRED) ================= */
Route::middleware('auth')->group(function () {
    // Komentar
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::post('/comments/{comment}/dislike', [CommentController::class, 'dislike'])->name('comments.dislike');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
});

/* ================= CUSTOMER - PRIVATE ================= */
Route::middleware(['auth', 'role:customer'])->group(function () {

    // Keranjang Belanja
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout & Transaksi
    Route::post('checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::get('transactions', [TransactionController::class, 'customerTransactions'])->name('customer.transactions');

    // Fitur Cicilan
    Route::get('transactions/{id}/pay', [TransactionController::class, 'payInstallment'])->name('transactions.pay');
    Route::post('transactions/{id}/pay', [TransactionController::class, 'processInstallment'])->name('transactions.pay.process');
});