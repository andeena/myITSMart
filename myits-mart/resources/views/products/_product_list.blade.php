<div class="row">
    @forelse ($products as $product)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text fw-bold text-primary fs-5">{{ $product->formatted_price }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary">Lihat Detail</a>
                        {{-- Logika Tombol Wishlist --}}
                        <div>
                            @if (Auth::check() && in_array($product->id, $wishlistedProductIds ?? []))
                                <form action="{{ route('wishlist.remove', $product) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0" title="Hapus dari Wishlist"><i class="fas fa-heart fs-4"></i></button>
                                </form>
                            @else
                                <form action="{{ route('wishlist.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-danger p-0" title="Tambah ke Wishlist"><i class="far fa-heart fs-4"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning">
                Produk yang Anda cari tidak ditemukan.
            </div>
        </div>
    @endforelse
</div>
