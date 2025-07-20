<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Pastikan DB Facade di-import

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama dengan produk pilihan dan produk terlaris.
     */
    public function index()
    {
        $featuredProducts = Product::latest()->take(4)->get();

        $bestSellingProducts = DB::select("
            SELECT
                p.id,
                p.product_name,      
                p.list_price, 
                p.image,       
                SUM(od.quantity) AS total_sold
            FROM
                products AS p
            JOIN
                order_details AS od ON p.id = od.product_id
            JOIN
                orders AS o ON od.order_id = o.id
            WHERE
                o.status IN ('Selesai', 'Shipped', 'Delivered', 'Completed')
            GROUP BY
                p.id, p.product_name, p.list_price -- Menyesuaikan GROUP BY
            ORDER BY
                total_sold DESC
            LIMIT 5;
        ");

        return view('welcome', [
            'featuredProducts'    => $featuredProducts,
            'bestSellingProducts' => $bestSellingProducts,
        ]);
    }
}
