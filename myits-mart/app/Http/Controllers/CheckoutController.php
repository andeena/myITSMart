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
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

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

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippers = Shipper::all();

        return view('checkout.index', compact('cartItems', 'total', 'shippers'));
    }

    /**
     * Memproses pesanan yang dibuat oleh user.
     */
    public function process(Request $request)
    {
        $request->validate([
            'ship_address' => 'required|string|max:255',
            'shipper_id' => 'required|exists:shippers,id',
        ]);
        
        $user = Auth::user();
        $cartItems = $user->cartItems;

        if ($cartItems->isEmpty()) {
            return redirect()->route('home');
        }

        try {
            // Gunakan transaction untuk memastikan semua query berhasil atau tidak sama sekali
            DB::transaction(function () use ($user, $cartItems, $request) {
                $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

                // 1. Buat record di tabel 'orders'
                $order = Order::create([
                    'customer_id' => $user->id,
                    'order_date' => now(),
                    'total_amount' => $total,
                    'ship_address' => $request->ship_address,
                    'shipper_id' => $request->shipper_id,
                    'status' => 'Pending',
                ]);

                // 2. Pindahkan item dari keranjang ke 'order_details'
                foreach ($cartItems as $item) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->product->price, // Simpan harga saat ini
                    ]);
                }

                // 3. Kosongkan keranjang user
                $user->cartItems()->delete();
            });

        } catch (\Exception $e) {
            // Jika ada error, kembalikan ke halaman checkout dengan pesan error
            return redirect()->route('checkout.index')->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi. Error: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.orders')->with('success', 'Pesanan Anda berhasil dibuat!');
    }
}