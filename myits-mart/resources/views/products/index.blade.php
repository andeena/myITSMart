@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="row">
    <div class="col-lg-3">
        <h4 class="mb-3">Kategori Produk</h4>
        <div class="list-group shadow-sm mb-4">
            {{-- Tombol untuk menampilkan semua kategori --}}
            <a href="{{ route('products.index') }}" 
               class="list-group-item list-group-item-action {{ !request('kategori') ? 'active' : '' }}">
                Semua Kategori
            </a>
            {{-- Loop untuk setiap kategori yang ada di database --}}
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['kategori' => $category->product_category]) }}" 
                   class="list-group-item list-group-item-action {{ request('kategori') == $category->product_category ? 'active' : '' }}">
                    {{ $category->product_category }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="col-lg-9">
        <h1 class="mb-4">Katalog Produk</h1>

        <div class="mb-4">
            <input type="search" id="product-search-input" class="form-control form-control-lg" placeholder="Cari nama produk...">
        </div>

        <div id="product-list-container">
            {{-- Memuat daftar produk awal dari partial view --}}
            @include('products._product_list', ['products' => $products])
        </div>
        
        <div id="pagination-container" class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('product-search-input');
    const productContainer = document.getElementById('product-list-container');
    const paginationContainer = document.getElementById('pagination-container');
    let searchTimeout;

    searchInput.addEventListener('keyup', function() {
        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(() => {
            const query = this.value;
            fetchProducts(query);
        }, 500); // 500 milidetik delay
    });

    function fetchProducts(query) {
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('kategori') || '';

        const url = `/api/products/search?query=${encodeURIComponent(query)}&kategori=${encodeURIComponent(category)}`;

        productContainer.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        paginationContainer.innerHTML = ''; // Kosongkan paginasi saat loading

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                productContainer.innerHTML = data.products_html;
                paginationContainer.innerHTML = data.pagination_html;
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                productContainer.innerHTML = '<div class="alert alert-danger">Gagal memuat produk. Silakan coba lagi.</div>';
            });
    }
});
</script>
@endpush