@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .profile-card .profile-avatar {
        width: 80px;
        height: 80px;
        background-color: #e9ecef;
        color: #0d6efd;
        font-size: 2.5rem;
        font-weight: bold;
    }
    .level-badge {
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.4em 0.8em;
    }
    .level-gold { background-color: #fff3cd; color: #664d03; }
    .level-silver { background-color: #e2e3e5; color: #41464b; }
    .level-bronze { background-color: #f8e5d7; color: #6e4a27; }
</style>
@endpush

@section('content')
<div class="row">
    <!-- Kolom Kiri: Profil & Navigasi -->
    <div class="col-lg-4 mb-4">
        <div class="card profile-card text-center shadow-sm h-100">
            <div class="card-body d-flex flex-column">
                <div class="profile-avatar rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                    <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <h4 class="card-title">{{ Auth::user()->name }}</h4>
                <p class="text-muted">{{ Auth::user()->email }}</p>
                
                <!-- [BARU] Menampilkan Lencana Level Keanggotaan -->
                <div class="mb-3">
                    @php
                        $levelClass = 'level-bronze'; // Default
                        if (str_contains($customerLevel, 'Gold')) $levelClass = 'level-gold';
                        if (str_contains($customerLevel, 'Silver')) $levelClass = 'level-silver';
                    @endphp
                    <span class="badge rounded-pill {{ $levelClass }} level-badge">
                        <i class="fas fa-crown me-1"></i> {{ $customerLevel }}
                    </span>
                </div>
                
                <hr>
                <div class="list-group list-group-flush text-start mt-auto">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active" aria-current="true">
                        <i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('dashboard.orders') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-box fa-fw me-2"></i>Riwayat Pesanan
                    </a>
                    <a href="{{ route('dashboard.my-wishlist') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-heart fa-fw me-2"></i>Wishlist Saya
                    </a>
                    <a href="{{ route('dashboard.my-reviews') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-star fa-fw me-2"></i>Ulasan Saya
                    </a>
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-edit fa-fw me-2"></i>Profil Saya
                    </a>
                    <a href="#" class="list-group-item list-group-item-action" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-fw me-2"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <h2 class="fw-bold mb-4">Selamat Datang Kembali, {{ strtok(Auth::user()->name, " ") }}! 👋</h2>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-primary text-uppercase">Total Pesanan</h6>
                            <h4 class="fw-bold">{{ $stats->total_orders ?? 0 }}</h4>
                        </div>
                        <div class="flex-shrink-0 ms-3">
                            <i class="fas fa-box-open stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-primary text-uppercase">Pesanan Diproses</h6>
                            <h4 class="fw-bold">{{ $pendingOrdersCount }}</h4>
                        </div>
                        <div class="flex-shrink-0 ms-3">
                            <i class="fas fa-clock stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                 <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-primary text-uppercase">Item di Wishlist</h6>
                            <h4 class="fw-bold">{{ $wishlistCount }}</h4>
                        </div>
                        <div class="flex-shrink-0 ms-3">
                            <i class="fas fa-heart stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                 <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-primary text-uppercase">Total Belanja</h6>
                            <h4 class="fw-bold">Rp {{ number_format($stats->total_spending ?? 0, 0, ',', '.') }}</h4>
                        </div>
                        <div class="flex-shrink-0 ms-3">
                            <i class="fas fa-money-bill-wave stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <h4 class="fw-bold mt-2 mb-3">Pesanan Terbaru</h4>
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse ($recentOrders as $order)
    <tr>
        <td><strong>#{{ $order->id }}</strong></td>
<td>{{ $order->order_date->format('d M Y') }}</td>        <td><span class="badge bg-info text-dark">{{ $order->status }}</span></td>
        {{-- [PERBAIKAN] Ubah 'total_amount' menjadi nama kolom yang benar, misal 'total' --}}
        <td class="text-end fw-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
        <td class="text-center">
            <a href="{{ route('dashboard.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center text-muted py-4">Anda belum memiliki pesanan.</td>
    </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div> -->
    </div>
</div>
@endsection
