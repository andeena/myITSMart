<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan.
     */
    public function index()
    {
        // Ambil semua pesanan, muat relasi customer, urutkan dari yang terbaru, dan paginasi
        $orders = Order::with('customer')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        // Muat semua relasi yang dibutuhkan untuk halaman detail
        $order->load('customer', 'details.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status pesanan.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Processing,Shipped,Delivered,Completed,Cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

    
        return redirect()->route('admin.orders.show', $order)
                         ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
