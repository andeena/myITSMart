<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderHistoryView;
use App\Models\CustomerDashboardStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $stats = CustomerDashboardStats::find($user->id);

        if (!$stats) {
            $stats = (object) ['total_orders' => 0, 'total_spending' => 0];
        }

        // Panggil fungsi database GetCustomerLevel
        $levelResult = DB::selectOne("SELECT GetCustomerLevel(?) AS level", [$user->id]);
        $customerLevel = $levelResult->level;

        $wishlistCount = $user->wishlistProducts()->count();
        $pendingOrdersCount = $user->orders()->where('status', 'Processing')->count();
        $recentOrders = $user->orders()->latest('order_date')->take(3)->get();

        return view('dashboard.index', compact(
            'stats',
            'wishlistCount',
            'pendingOrdersCount',
            'recentOrders',
            'customerLevel'
        ));
    }

    /**
     * [DIKEMBALIKAN] Menampilkan halaman riwayat pesanan.
     */
    public function orders()
    {
        $allOrderItems = OrderHistoryView::where('customer_id', Auth::id())
                                        ->orderBy('order_date', 'desc')
                                        ->get();

        $reviewedProductIds = Auth::user()->reviews()->pluck('product_id')->toArray();
        $orders = $allOrderItems->groupBy('order_id');

        return view('dashboard.orders', compact('orders', 'reviewedProductIds'));
    }

    /**
     * [DIKEMBALIKAN] Menampilkan halaman riwayat ulasan.
     */
    public function myReviews()
    {
        $userId = Auth::id();
        $reviews = DB::select("
            SELECT r.rating, r.comment, r.created_at AS review_date, p.product_name, p.id AS product_id
            FROM reviews AS r
            JOIN products AS p ON r.product_id = p.id
            WHERE r.customer_id = ? ORDER BY r.created_at DESC;
        ", [$userId]);

        return view('dashboard.my-reviews', compact('reviews'));
    }

    /**
     * [DIKEMBALIKAN] Menampilkan halaman wishlist.
     */
    public function myWishlist()
    {
        $wishlistItems = Auth::user()->wishlistProducts()->paginate(12);
        
        return view('dashboard.my-wishlist', compact('wishlistItems'));
    }
}