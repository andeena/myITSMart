@extends('layouts.app')

@section('title', 'Selamat Datang di myITS Mart')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(90deg, #0A6EBD 0%, #0d6efd 100%);
        color: white; border-radius: 1rem; padding: 4rem 1.5rem;
    }
    .hero-section .btn-light {
        font-weight: 600; padding: 0.75rem 1.5rem; transition: all 0.2s ease-in-out;
    }
    .hero-section .btn-light:hover {
        transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .feature-icon { font-size: 2.5rem; color: #0d6efd; }
    .section-title {
        font-weight: 700; color: #343a40; position: relative;
        padding-bottom: 0.5rem; margin-bottom: 2rem;
    }
    .section-title::after {
        content: ''; position: absolute; bottom: 0; left: 50%;
        transform: translateX(-50%); width: 60px; height: 4px;
        background-color: #0d6efd; border-radius: 2px;
    }
    .product-card {
        border: none; transition: all 0.3s ease-in-out;
    }
    .product-card:hover {
        transform: translateY(-5px); box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15)!important;
    }
    .hero-blurred-bg {
        position: relative;
        overflow: hidden; 
    }

    .hero-blurred-bg::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-image: url('{{ asset('storage/its mart.jpg') }}');
        background-size: cover;
        background-position: center;
        z-index: 1; 
        filter: blur(5px);
    }

    .hero-blurred-bg > * {
        position: relative; 
        z-index: 1;
    }
</style>
@endpush

@section('content')
    <div class="hero-section text-center mb-5 shadow-lg hero-blurred-bg">
        <h1 class="display-4 fw-bold">myITS Mart</h1>
        <p class="lead col-lg-8 fw-bold mx-auto">Solusi Belanja Cepat dan Terpercaya untuk Sivitas Akademika ITS.</p>
        <a href="{{ route('products.index') }}" class="btn btn-light mt-3">Jelajahi Semua Produk <i class="fas fa-arrow-right ms-2"></i></a>
    </div>

    <div class="container my-5 py-4">
        <h2 class="text-center section-title">Paling Laris</h2>
        
        @if(isset($bestSellingProducts) && count($bestSellingProducts) > 0)
            <div class="row">
                @foreach ($bestSellingProducts as $product)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card product-card h-100 shadow-sm">
                            {{-- [PERBAIKAN] Menggunakan accessor dari model Product untuk konsistensi --}}
                            @php
                                // Ambil instance model Product berdasarkan ID agar bisa pakai accessor
                                $productModel = \App\Models\Product::find($product->id);
                            @endphp
                            <img src="{{ $productModel ? $productModel->image_url : 'https://placehold.co/600x400' }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <p class="card-text fw-bold text-primary fs-5">Rp {{ number_format($product->list_price, 0, ',', '.') }}</p>
                                <p class="text-muted small">Terjual {{ (int)$product->total_sold }} unit</p>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">Data produk terlaris akan segera ditampilkan.</p>
        @endif
    </div>

    <div class="container text-center my-5 py-4 bg-light rounded-3">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <i class="fas fa-rocket feature-icon mb-3"></i>
                <h4 class="fw-bold">Pengiriman Cepat</h4>
                <p class="text-muted px-3">Pesanan Anda diproses dan dikirimkan secepatnya di lingkungan ITS.</p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <i class="fas fa-shield-alt feature-icon mb-3"></i>
                <h4 class="fw-bold">Produk Terjamin</h4>
                <p class="text-muted px-3">Hanya menyediakan produk-produk original dan berkualitas terbaik.</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-tags feature-icon mb-3"></i>
                <h4 class="fw-bold">Harga Mahasiswa</h4>
                <p class="text-muted px-3">Nikmati berbagai promosi dan harga spesial yang ramah di kantong.</p>
            </div>
        </div>
    </div>
    
    <div class="container my-5 py-4">
        <h2 class="text-center section-title">Baru Tiba</h2>

        @if(isset($featuredProducts) && $featuredProducts->count() > 0)
            <div class="row">
                @foreach ($featuredProducts as $product)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card product-card h-100 shadow-sm">
                            {{-- [PERBAIKAN] Memanggil accessor 'image_url' dengan benar --}}
                            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text fw-bold text-primary fs-5">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-primary mt-auto">Beli Sekarang</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">Belum ada produk baru saat ini.</p>
        @endif
    </div>
@endsection