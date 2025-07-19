<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Menyiapkan dan menampilkan halaman pembayaran untuk pesanan yang sudah ada.
     */
    public function pay(Order $order)
    {
        // Keamanan: Pastikan hanya pemilik pesanan yang bisa membayar
        if ($order->customer_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Keamanan: Pastikan hanya pesanan 'Pending' yang bisa dibayar
        if ($order->status !== 'Pending') {
            return redirect()->route('dashboard.orders')->with('info', 'Pesanan ini tidak bisa dibayar lagi.');
        }
        
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Ambil data user
        $user = Auth::user();

        $unique_order_id = $order->id . '-' . Str::random(5);
        // Buat parameter untuk Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id' => $unique_order_id,
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