<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CommentController;

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
    ->group(function () {

        Route::get('/', [AdminController::class,'dashboard'])->name('dashboard');

        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);

        Route::get('customers', [AdminController::class,'customers'])->name('customers');

        // --- Transaksi ---
        Route::get('transactions', [TransactionController::class,'index'])->name('transactions');
        Route::post(
            'transactions/{id}/update-status',
            [TransactionController::class,'updateStatus']
        )->name('transactions.updateStatus');

        // --- Laporan ---
        // 1. Halaman Laporan (View)
        Route::get('reports', [AdminController::class,'reports'])->name('reports');
        
        // 2. Download Excel (PENTING: Ini yang kita perlukan)
        Route::get('reports/export', [AdminController::class, 'exportReports'])->name('reports.export');
    });

/* ================= CUSTOMER - PUBLIK ================= */
Route::get('products', [ProductController::class,'index'])
    ->name('products.index');

Route::get('products/{id}', [ProductController::class,'show'])
    ->name('products.show');

/* ================= KOMENTAR (LOGIN REQUIRED) ================= */
Route::middleware('auth')->group(function () {

    // buat komentar / reply
    Route::post('/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    // edit komentar
    Route::put('/comments/{comment}', [CommentController::class, 'update'])
        ->name('comments.update');

    // hapus komentar
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    // like & dislike
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])
        ->name('comments.like');

    Route::post('/comments/{comment}/dislike', [CommentController::class, 'dislike'])
        ->name('comments.dislike');
});

/* ================= CUSTOMER - PRIVATE ================= */
Route::middleware(['role:customer'])->group(function () {

    Route::get('cart', [CartController::class,'index'])->name('cart.index');

    Route::post('cart/add/{id}', [CartController::class,'add'])->name('cart.add');

    Route::patch('cart/update/{id}', [CartController::class,'update'])->name('cart.update');

    Route::delete('cart/remove/{id}', [CartController::class,'remove'])->name('cart.remove');

    Route::post('checkout', [TransactionController::class,'checkout'])->name('checkout');

    Route::get('transactions', [TransactionController::class,'customerTransactions'])
        ->name('customer.transactions');
});