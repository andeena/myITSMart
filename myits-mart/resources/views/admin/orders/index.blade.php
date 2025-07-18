@extends('admin.layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
    <h1 class="h2">Daftar Pesanan</h1>

    <div class="card mt-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->customer->name ?? 'N/A' }}</td>
                            <td>{{ $order->order_date->format('d M Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark">{{ $order->status }}</span>
                            </td>
                            <td class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $orders->links() }}
        </div>
    </div>
@endsection