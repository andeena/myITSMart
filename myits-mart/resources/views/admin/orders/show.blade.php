@extends('admin.layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h2">Detail Pesanan #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>
    
    <div class="row">
        {{-- Kolom Kiri: Detail Produk & Riwayat Status --}}
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header fw-bold d-flex align-items-center">
                    <i class="fas fa-box-open me-2"></i>Produk Dipesan
                </div>
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
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $detail->product->image_url }}" alt="{{ $detail->product->product_name }}" class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        <span>{{ $detail->product->product_name ?? 'N/A' }}</span>
                                    </div>
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

            <div class="card shadow-sm">
                 <div class="card-header fw-bold d-flex align-items-center">
                    <i class="fas fa-history me-2"></i>Riwayat Status Pesanan
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse ($order->logs as $log)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Status diubah menjadi <strong>{{ $log->status }}</strong></span>
                                <small class="text-muted">{{ $log->created_at->format('d M Y, H:i') }}</small>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Belum ada riwayat perubahan status.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        
        {{-- Kolom Kanan: Detail Pelanggan, Pengiriman, & Aksi --}}
        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header fw-bold d-flex align-items-center">
                   <i class="fas fa-user me-2"></i>Detail Pelanggan
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $order->customer->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Alamat Pengiriman:</strong><br>{{ $order->ship_address }}</p>
                </div>
            </div>
            
            <div class="card mb-4 shadow-sm">
                <div class="card-header fw-bold d-flex align-items-center">
                   <i class="fas fa-truck me-2"></i>Detail Pengiriman
                </div>
                <div class="card-body">
                    <p><strong>Kurir:</strong> {{ $order->shipper->company_name ?? 'Belum dipilih' }}</p>
                    <p class="mb-0"><strong>Tanggal Kirim:</strong> {{ $order->shipped_date ? $order->shipped_date->format('d M Y') : 'Belum dikirim' }}</p>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header fw-bold d-flex align-items-center">
                    <i class="fas fa-edit me-2"></i>Update Status Pesanan
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Ubah Status Menjadi:</label>
                            <select name="status" id="status" class="form-select">
                                <option value="Pending" @if($order->status == 'Pending') selected @endif>Pending</option>
                                <option value="Processing" @if($order->status == 'Processing') selected @endif>Processing</option>
                                <option value="Shipped" @if($order->status == 'Shipped') selected @endif>Shipped</option>
                                <option value="Delivered" @if($order->status == 'Delivered') selected @endif>Delivered</option>
                                <option value="Completed" @if($order->status == 'Completed') selected @endif>Completed</option>
                                <option value="Cancelled" @if($order->status == 'Cancelled') selected @endif>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection