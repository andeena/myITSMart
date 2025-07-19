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
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController; // <-- [BARU] Tambahkan ini
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RajaOngkirController;

Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::resource('users', AdminUserController::class)->except(['create', 'store', 'show']);

});

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

    Route::get('/pembayaran/{order}', [PaymentController::class, 'pay'])->name('payment.pay');

    // Route::post('/ongkir/cek', [RajaOngkirController::class, 'cekOngkir'])->name('ongkir.cek');
});

Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

// Route::get('/api/provinces', [RajaOngkirController::class, 'getProvinces'])->name('api.provinces');
// Route::get('/api/cities/{province_id}', [RajaOngkirController::class, 'getCities'])->name('api.cities');

//======================================================================
// RUTE AUTENTIKASI (Login, Register, Logout, dll.)
//======================================================================
require __DIR__.'/auth.php';