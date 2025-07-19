<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RajaOngkirController;
use App\Http\Controllers\Api\ProductController;

Route::get('/provinces', [RajaOngkirController::class, 'getProvinces'])->name('api.provinces');
Route::get('/cities/{province_id}', [RajaOngkirController::class, 'getCities'])->name('api.cities');
Route::post('/ongkir/cek', [RajaOngkirController::class, 'cekOngkir'])->name('api.ongkir.cek');
Route::get('/products/search', [ProductController::class, 'search'])->name('api.products.search');
