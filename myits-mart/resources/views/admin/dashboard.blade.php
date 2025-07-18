@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
{{-- Kartu Statistik --}}
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">TOTAL PENDAPATAN</h6>
                        <h4 class="fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                    </div>
                    <i class="fas fa-dollar-sign fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-warning shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">PESANAN BARU</h6>
                        <h4 class="fw-bold">{{ $newOrdersCount }}</h4>
                    </div>
                    <i class="fas fa-receipt fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">TOTAL PELANGGAN</h6>
                        <h4 class="fw-bold">{{ $totalCustomers }}</h4>
                    </div>
                    <i class="fas fa-users fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Pesanan Terbaru & Produk Terlaris --}}
<div class="row mt-4">
    <div class="col-md-8">
        <h5>Pesanan Terbaru</h5>
        <div class="table-responsive card">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->customer->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-info text-dark">{{ $order->status }}</span></td>
                            <td class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <h5>Produk Terlaris</h5>
        <div class="card">
            <ul class="list-group list-group-flush">
                @forelse ($bestSellingProducts as $product)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $product->product_name }}
                        <span class="badge bg-primary rounded-pill">{{ (int)$product->total_sold }}</span>
                    </li>
                @empty
                    <li class="list-group-item">Belum ada data penjualan.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection