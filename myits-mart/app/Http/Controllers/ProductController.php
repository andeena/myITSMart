<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman katalog produk.
     * Mendukung filter berdasarkan kategori dan menampilkan status wishlist.
     */
    public function index(Request $request)
    {
        $categories = Cache::rememberForever('categories_list', function () {
            return Product::select('product_category')
                            ->whereNotNull('product_category')
                            ->distinct()
                            ->orderBy('product_category', 'asc')
                            ->get();
        });

        $query = Product::query();

        if ($request->filled('kategori')) {
            $query->where('product_category', $request->kategori);
        }

        $products = $query->latest()->paginate(12);

        $wishlistedProductIds = [];
        if (Auth::check()) {
            $wishlistedProductIds = Auth::user()->wishlistProducts()->pluck('products.id')->toArray();
        }

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'wishlistedProductIds' => $wishlistedProductIds
        ]);
    }

    /**
     * Menampilkan halaman detail untuk satu produk.
     * Termasuk produk terkait (juga dibeli) dan status wishlist.
     */
    public function show(Product $product)
    {
        $product->load('reviews.user');

        $isInWishlist = false;
        if (Auth::check()) {
            $isInWishlist = Auth::user()->wishlistProducts()->where('product_id', $product->id)->exists();
        }

        $alsoBoughtProducts = DB::select("
            SELECT
                p.id, p.product_name, p.list_price
            FROM order_details AS od1
            JOIN order_details AS od2 ON od1.order_id = od2.order_id
            JOIN products AS p ON p.id = od2.product_id
            WHERE
                od1.product_id = ? AND od2.product_id <> ?
            GROUP BY
                p.id, p.product_name, p.list_price
            ORDER BY
                COUNT(p.id) DESC
            LIMIT 4
        ", [$product->id, $product->id]);

        return view('products.show', [
            'product' => $product,
            'alsoBoughtProducts' => $alsoBoughtProducts,
            'isInWishlist' => $isInWishlist
        ]);
    }
}
