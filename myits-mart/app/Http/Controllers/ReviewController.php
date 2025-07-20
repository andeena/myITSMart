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
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        try {
            $existingReview = $product->reviews()
                                    ->where('customer_id', Auth::id())
                                    ->exists();

            if ($existingReview) {
                return redirect()->back()->with('error', 'Anda sudah pernah memberikan ulasan untuk produk ini.');
            }

            $customer = Auth::user()->customer;
            // Trigger 'before_review_insert_check_purchase' akan otomatis berjalan di sini!
            $product->reviews()->create([
                'customer_id' => $customer->id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda telah berhasil disimpan.');

        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $e->getMessage();

            if (str_contains($errorMessage, 'Anda hanya bisa mengulas produk yang sudah Anda beli')) {
                return redirect()->back()->with('error', 'Gagal: Anda hanya bisa mengulas produk yang sudah Anda beli.');
            }
            
            Log::error('Review Store Error: ' . $errorMessage);
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server. Silakan coba lagi.');
        }
    }
}
