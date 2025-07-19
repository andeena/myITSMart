<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // Set konfigurasi
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');

        // Buat instance notifikasi
        $notification = new Notification();
        
        // Ambil order
        $order = Order::find($notification->order_id);

        // Lakukan verifikasi dan update status
        if ($notification->transaction_status == 'capture' || $notification->transaction_status == 'settlement') {
            $order->status = 'Processing'; // Ubah status menjadi 'Processing'
        }
        
        $order->save();
        return response()->json(['message' => 'Notifikasi berhasil diproses.']);
    }
}