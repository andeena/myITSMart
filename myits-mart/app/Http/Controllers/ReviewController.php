<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    /**
     * Memvalidasi dan menyimpan ulasan baru ke database.
     */
    public function store(Request $request, Product $product)
    {
        // 1. Validasi input dari form
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        try {
            // 2. Cek apakah user sudah pernah mengulas produk ini sebelumnya
            $existingReview = $product->reviews()
                                    ->where('customer_id', Auth::id())
                                    ->exists();

            if ($existingReview) {
                return redirect()->back()->with('error', 'Anda sudah pernah memberikan ulasan untuk produk ini.');
            }

            // 3. Simpan ulasan baru.
            // Trigger 'before_review_insert_check_purchase' akan otomatis berjalan di sini!
            $product->reviews()->create([
                'customer_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            // Jika berhasil, kembalikan ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda telah berhasil disimpan.');

        } catch (\Illuminate\Database\QueryException $e) {
            // 4. Menangkap error dari database, terutama dari Trigger
            $errorMessage = $e->getMessage();

            // Cek apakah errornya adalah pesan kustom dari trigger kita
            if (str_contains($errorMessage, 'Anda hanya bisa mengulas produk yang sudah Anda beli')) {
                return redirect()->back()->with('error', 'Gagal: Anda hanya bisa mengulas produk yang sudah Anda beli.');
            }
            
            // Log error lain untuk debugging oleh developer
            Log::error('Review Store Error: ' . $errorMessage);
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server. Silakan coba lagi.');
        }
    }
}
