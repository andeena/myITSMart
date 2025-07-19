@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Detail Pesanan #{{ $order->id }}</h2>
        <a href="{{ route('dashboard.orders') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
        </a>
    </div>

    <div class="row">
        {{-- Kolom Kiri: Detail Produk & Riwayat Status --}}
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header fw-bold d-flex align-items-center"><i class="fas fa-box-open me-2"></i>Produk Dipesan</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->details as $detail)
                            <tr>
                                <td>
                                    @if($detail->product)
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $detail->product->image_url }}" alt="{{ $detail->product->product_name }}" class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                            <span>{{ $detail->product->product_name }}</span>
                                        </div>
                                    @else
                                        <span>Produk telah dihapus</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ (int)$detail->quantity }}</td>
                                <td class="text-end">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($detail->unit_price * $detail->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end align-items-center">
                    <strong class="me-3">Total Pesanan:</strong>
                    <span class="fs-5 fw-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        {{-- Kolom Kanan: Detail Pelanggan & Pengiriman --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header fw-bold d-flex align-items-center"><i class="fas fa-user me-2"></i>Info Pengiriman</div>
                <div class="card-body">
                    <p><strong>Kurir:</strong> {{ $order->shipper->company_name ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-primary">{{ $order->status }}</span></p>
                    <hr>
                    <p class="mb-0"><strong>Alamat Pengiriman:</strong><br>{{ $order->ship_address }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection