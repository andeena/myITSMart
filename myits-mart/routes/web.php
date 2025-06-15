<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan semua rute untuk aplikasi Anda.
| Rute-rute ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web".
|
*/


//======================================================================
// RUTE PUBLIK (Dapat diakses oleh semua orang)
//======================================================================

// Halaman utama / Welcome Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Katalog dan Detail Produk
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/test-modal', function () {
    return view('test');
});

Route::middleware('auth')->group(function () {

    Route::prefix('keranjang')->middleware('auth')->name('cart.')->group(function () { // <-- TAMBAHKAN DI SINI
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/tambah/{product}', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{cart}', [CartController::class, 'update'])->name('update');
        Route::delete('/hapus/{cart}', [CartController::class, 'remove'])->name('remove');
    });

    Route::prefix('checkout')->middleware('auth')->name('checkout.')->group(function () { // <-- TAMBAHKAN DI SINI
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'process'])->name('process');
    });

    Route::post('/wishlist/tambah/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/hapus/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    Route::post('/ulasan/simpan/{product}', [ReviewController::class, 'store'])->name('reviews.store');


Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pesanan', [DashboardController::class, 'orders'])->name('dashboard.orders');
    Route::get('/pesanan/{order}', [DashboardController::class, 'showOrder'])->name('dashboard.orders.show');
    
    Route::get('/ulasan', [DashboardController::class, 'myReviews'])->name('dashboard.my-reviews');
    Route::get('/wishlist', [DashboardController::class, 'myWishlist'])->name('dashboard.my-wishlist');

});

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//======================================================================
// RUTE AUTENTIKASI (Login, Register, Logout, dll.)
//======================================================================
// Baris ini secara otomatis memuat semua rute yang dibutuhkan untuk
// autentikasi dari Laravel Breeze (login, register, logout, lupa password, dll).
require __DIR__.'/auth.php';