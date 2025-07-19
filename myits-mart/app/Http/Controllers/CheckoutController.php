<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

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
            return redirect()->route('cart.index')->with('info', 'Keranjang Anda kosong.');
        }

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
        // [PERBAIKAN] Ambil cartItems sekali saja dengan relasi produknya
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        // [PERBAIKAN] Hitung total di luar transaction
        $total = $cartItems->sum(function($item) {
            return $item->product ? ($item->product->list_price * $item->quantity) : 0;
        });

        if ($total <= 0) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item untuk di-checkout.');
        }

        $order = null;

        try {
            // [PERBAIKAN] Lempar variabel $total ke dalam transaction
            DB::transaction(function () use ($user, $cartItems, $request, $total, &$order) {
                
                $order = Order::create([
                    'customer_id' => $user->id,
                    'order_date' => now(),
                    'total_amount' => $total,
                    'ship_address' => $request->shipping_address,
                    'shipper_id' => $request->shipper_id,
                    'status' => 'Pending',
                ]);

                foreach ($cartItems as $item) {
                    if ($item->product) {
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'unit_price' => $item->product->list_price,
                        ]);
                    }
                }

                $user->cartItems()->delete();
            });

        } catch (\Exception $e) {
            return redirect()->route('checkout.index')->with('error', 'Terjadi kesalahan saat memproses pesanan. Error: ' . $e->getMessage());
        }

        // --- Bagian Midtrans ---
        
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat array untuk detail transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];
        
        // Dapatkan Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($params);
        
        // Kirim Snap Token ke view pembayaran
        return view('checkout.payment', compact('snapToken'));
    }
}
