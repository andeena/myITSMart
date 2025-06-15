<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $user = Auth::user();

        // [BENAR] Menggunakan relasi 'cartItems' yang cerdas. Laravel akan otomatis memakai 'customer_id'.
        $cartItems = $user->cartItems()->with('product')->get();
        
        $total = $cartItems->sum(function($item) {
            return $item->product ? ($item->product->list_price * $item->quantity) : 0;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Menambahkan produk ke dalam keranjang.
     */
    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:' . $product->stock]);

        $user = Auth::user();
        
        // [BENAR] Mencari item yang ada melalui relasi.
        $cartItem = $user->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // [BENAR] Membuat item baru melalui relasi.
            $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Memperbarui kuantitas item di keranjang.
     */
    public function update(Request $request, Cart $cart)
    {
        // [BENAR] Cek kepemilikan menggunakan 'customer_id'.
        if ($cart->customer_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function remove(Cart $cart)
    {
        // [BENAR] Cek kepemilikan menggunakan 'customer_id'.
        if ($cart->customer_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }
        
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
