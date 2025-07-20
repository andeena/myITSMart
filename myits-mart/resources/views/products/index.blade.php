@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
{{-- Bagian HTML Anda tidak perlu diubah, sudah bagus --}}
<div class="row">
    <div class="col-lg-3">
        <h4 class="mb-3">Kategori Produk</h4>
        <div class="list-group shadow-sm mb-4">
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

    <div class="col-lg-9">
        <h1 class="mb-4">Katalog Produk</h1>

        <div class="mb-4">
            <input type="search" id="product-search-input" class="form-control form-control-lg" placeholder="Cari nama produk..." value="{{ request('query') }}">
        </div>

        <div id="product-list-container">
            {{-- Memuat daftar produk awal dari partial view --}}
            @include('products._product_list', ['products' => $products])
        </div>
        
        <div id="pagination-container" class="d-flex justify-content-center mt-4">
            {{ $products->appends(request()->query())->links() }}
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

    function fetchData(url) {
        // Tampilkan loading spinner
        productContainer.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        paginationContainer.innerHTML = ''; // Kosongkan paginasi

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Perbarui konten dengan hasil dari API
                productContainer.innerHTML = data.products_html;
                paginationContainer.innerHTML = data.pagination_html;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                productContainer.innerHTML = '<div class="alert alert-danger">Gagal memuat produk. Silakan coba lagi.</div>';
            });
    }

    // --- EVENT LISTENER UNTUK INPUT PENCARIAN ---
    searchInput.addEventListener('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const query = this.value;
            const urlParams = new URLSearchParams(window.location.search);
            const category = urlParams.get('kategori') || '';
            const fetchUrl = `/api/products/search?query=${encodeURIComponent(query)}&kategori=${encodeURIComponent(category)}`;
            
            fetchData(fetchUrl);
        }, 500); // 500 milidetik delay
    });

    paginationContainer.addEventListener('click', function(event) {
        // Cek apakah yang diklik adalah link paginasi
        if (event.target.tagName === 'A' && event.target.classList.contains('page-link')) {
            event.preventDefault(); // Mencegah reload halaman
            const fetchUrl = event.target.href.replace('products?','api/products/search?'); // Ganti URL ke endpoint API
            
            fetchData(fetchUrl);
        }
    });
});
</script>
@endpush