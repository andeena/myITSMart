@extends('layouts.app')

@section('title', 'Riwayat Ulasan Saya')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold">Riwayat Ulasan Saya</h2>
    <p class="text-muted">Melihat semua ulasan yang pernah Anda berikan.</p>

    @forelse ($reviews as $review)
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h5 class="card-title fw-bold mb-0">
                        {{-- Nama produk bisa di-klik untuk melihat detailnya --}}
                        <a href="{{ route('products.show', $review->product_id) }}" class="text-decoration-none">{{ $review->product_name }}</a>
                    </h5>
                    {{-- Hasil DB::select adalah string, perlu di-parse ke Carbon untuk format --}}
                    <span class="text-muted small">{{ \Carbon\Carbon::parse($review->review_date)->format('d F Y') }}</span>
                </div>
                <div class="mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                    @endfor
                </div>
                <p class="card-text fst-italic">"{{ $review->comment }}"</p>
            </div>
        </div>
    @empty
        <div class="text-center p-5 bg-light rounded">
            <p class="text-muted">Anda belum pernah memberikan ulasan.</p>
        </div>
    @endforelse
</div>
@endsection