<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data untuk kartu statistik
        $totalRevenue = Order::whereIn('status', ['Selesai', 'completed', 'Shipped', 'Delivered'])->sum('total_amount');
        $newOrdersCount = Order::where('status', 'Pending')->count();
        $totalCustomers = User::where('role', 'customer')->count();

        // 2. Ambil 5 pesanan terbaru
        $recentOrders = Order::with('customer')->latest()->take(5)->get();

        // 3. Ambil 5 produk terlaris (menggunakan query JOIN)
        $bestSellingProducts = DB::select("
            SELECT p.product_name, SUM(od.quantity) AS total_sold
            FROM products AS p
            JOIN order_details AS od ON p.id = od.product_id
            JOIN orders AS o ON od.order_id = o.id
            WHERE o.status IN ('Selesai', 'Shipped', 'Delivered', 'completed')
            GROUP BY p.product_name
            ORDER BY total_sold DESC
            LIMIT 5
        ");
        
        // 4. Kirim semua data ke view
        return view('admin.dashboard', compact(
            'totalRevenue',
            'newOrdersCount',
            'totalCustomers',
            'recentOrders',
            'bestSellingProducts'
        ));
    }

}