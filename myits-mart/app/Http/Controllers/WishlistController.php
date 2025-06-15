<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Menambahkan produk ke wishlist pengguna yang sedang login.
     */
    public function add(Product $product)
    {
        $user = Auth::user();

        // Cek untuk mencegah duplikat
        $isExist = $user->wishlistProducts()->where('product_id', $product->id)->exists();

        if ($isExist) {
            return redirect()->back()->with('info', 'Produk ini sudah ada di wishlist Anda.');
        }

        // 'attach' adalah cara Eloquent untuk menambahkan data ke tabel pivot (many-to-many)
        $user->wishlistProducts()->attach($product->id);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke wishlist!');
    }

    /**
     * Menghapus produk dari wishlist pengguna.
     * (Ini untuk pengembangan di masa depan, tapi kita siapkan sekarang)
     */
    public function remove(Product $product)
    {
        $user = Auth::user();

        // 'detach' adalah cara Eloquent untuk menghapus data dari tabel pivot
        $user->wishlistProducts()->detach($product->id);

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari wishlist.');
    }
}