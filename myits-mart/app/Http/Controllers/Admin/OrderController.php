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
        // Ambil semua pesanan dengan relasi customer dan detail produk
        $orders = Order::with(['customer', 'details.product'])->latest()->paginate(15);
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
     * Jika status berubah ke "Completed", trigger akan aktif.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Processing,Shipped,Delivered,Completed,Cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Cek apakah status berubah agar trigger bisa berjalan
        if ($oldStatus !== $newStatus) {
            $order->status = $newStatus;
            $order->save(); // Trigger akan aktif jika status berubah
        }

        return redirect()->route('admin.orders.show', $order)
                         ->with('success', "Status pesanan diubah dari '$oldStatus' ke '$newStatus'.");
    }
}
