<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            // Kembalikan semua produk jika query kosong
            $products = Product::latest()->paginate(12);
        } else {
            // Cari produk berdasarkan nama
            $products = Product::where('product_name', 'LIKE', "%{$query}%")
                               ->latest()
                               ->paginate(12);
        }

        // Kita akan merender view partial dan mengembalikannya sebagai JSON
        // Ini adalah trik agar kita tidak perlu menulis HTML di JavaScript
        return response()->json([
            'products_html' => view('products._product_list', ['products' => $products])->render(),
            'pagination_html' => $products->links()->toHtml(),
        ]);
    }
}
