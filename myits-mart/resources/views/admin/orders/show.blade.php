@extends('admin.layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h2">Detail Pesanan #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header fw-bold">Produk Dipesan</div>
                <div class="table-responsive">
                    <table class="table mb-0">
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
                                <td>{{ $detail->product->product_name ?? 'N/A' }}</td>
                                <td class="text-center">{{ (int)$detail->quantity }}</td>
                                <td class="text-end">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($detail->unit_price * $detail->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-end fs-5 fw-bold">
                    Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header fw-bold">Detail Pelanggan</div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $order->customer->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Alamat Pengiriman:</strong><br>{{ $order->ship_address }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header fw-bold">Update Status Pesanan</div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Saat Ini: <strong>{{ $order->status }}</strong></label>
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