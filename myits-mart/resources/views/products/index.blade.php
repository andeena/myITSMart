@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="row">
    <!-- Kolom Kiri: Sidebar Filter Kategori -->
    <div class="col-lg-3">
        <h4 class="mb-3">Kategori Produk</h4>
        <div class="list-group shadow-sm">
            <a href="{{ route('products.index') }}" 
               class="list-group-item list-group-item-action {{ !request('kategori') ? 'active' : '' }}">
                Semua Kategori
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['kategori' => $category->product_category]) }}" 
                   class="list-group-item list-group-item-action {{ request('kategori') == $category->product_category ? 'active' : '' }}">
                    {{ $category->product_category }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Kolom Kanan: Daftar Produk -->
    <div class="col-lg-9">
        <h1 class="mb-4">Katalog Produk</h1>
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text fw-bold text-primary fs-5">{{ $product->formatted_price }}</p>
                            
                            {{-- [PERBAIKAN] Tombol diletakkan sejajar di bawah --}}
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary">Lihat Detail</a>
                                
                                {{-- Tombol Wishlist --}}
                                <div>
                                    @if (Auth::check() && in_array($product->id, $wishlistedProductIds))
                                        {{-- Form Hapus dari Wishlist (Ikon Hati Penuh) --}}
                                        <form action="{{ route('wishlist.remove', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0" title="Hapus dari Wishlist">
                                                <i class="fas fa-heart fs-4"></i>
                                            </button>
                                        </form>
                                    @else
                                        {{-- Form Tambah ke Wishlist (Ikon Hati Kosong) --}}
                                        <form action="{{ route('wishlist.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link text-danger p-0" title="Tambah ke Wishlist">
                                                <i class="far fa-heart fs-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Tidak ada produk yang ditemukan untuk kategori ini.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Link Paginasi -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection