@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold">Wishlist Saya</h2>
    <p class="text-muted">Produk yang Anda sukai dan simpan untuk nanti.</p>

    <div class="row mt-4">
        @forelse ($wishlistItems as $product)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->product_name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <p class="card-text fw-bold text-primary fs-5">Rp {{ number_format($product->list_price, 0, ',', '.') }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary mt-auto">Lihat Produk</a>
                        {{-- Tambahkan tombol hapus dari wishlist di sini nanti --}}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center p-5 bg-light rounded">
                    <p class="text-muted">Wishlist Anda masih kosong.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Cari Produk</a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Link Paginasi -->
    <div class="d-flex justify-content-center">
        {{ $wishlistItems->links() }}
    </div>
</div>
@endsection
