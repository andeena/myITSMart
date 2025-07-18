<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('info', 'Keranjang Anda kosong. Silakan belanja dulu.');
        }

        // [PERBAIKAN] Menggunakan 'list_price' sesuai nama kolom di database
        $total = $cartItems->sum(function($item) {
            return $item->product ? ($item->product->list_price * $item->quantity) : 0;
        });
        
        $shippers = Shipper::all();

        return view('checkout.index', compact('cartItems', 'total', 'shippers'));
    }

    /**
     * Memproses pesanan yang dibuat oleh user.
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipper_id' => 'required|exists:shippers,id',
        ]);
        
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get(); // Pastikan 'with('product')' ada

        if ($cartItems->isEmpty()) {
            return redirect()->route('home');
        }

        // [PERBAIKIKAN] Hitung total di luar transaction
        $total = $cartItems->sum(function($item) {
            return $item->product ? ($item->product->list_price * $item->quantity) : 0;
        });

        try {
            DB::transaction(function () use ($user, $cartItems, $request, $total) {
                // Buat record di tabel 'orders', gunakan variabel $total
                $order = Order::create([
                    'customer_id' => $user->id,
                    'order_date' => now(),
                    'total_amount' => $total,
                    'ship_address' => $request->shipping_address,
                    'shipper_id' => $request->shipper_id,
                    'status' => 'Pending',
                ]);

                // Pindahkan item dari keranjang ke 'order_details'
                foreach ($cartItems as $item) {
                    if ($item->product) { // Tambahan keamanan
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'unit_price' => $item->product->list_price,
                        ]);
                    }
                }

                // Kosongkan keranjang user
                $user->cartItems()->delete();
            });

        } catch (\Exception $e) {
            return redirect()->route('checkout.index')->with('error', 'Terjadi kesalahan. Error: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.orders')->with('success', 'Pesanan Anda berhasil dibuat!');
    }
}
