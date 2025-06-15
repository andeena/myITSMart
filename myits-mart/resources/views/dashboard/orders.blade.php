@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="container py-4">
        <h2 class="fw-bold">Riwayat Pesanan</h2>
        <p class="text-muted">Melihat semua transaksi untuk {{ Auth::user()->name }}.</p>

        @forelse ($orders as $order_id => $details)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-0">
                                <i class="fas fa-receipt me-2 text-primary"></i>Pesanan #{{ $order_id }}
                            </h5>
                            @if($details->isNotEmpty())
                                <small class="text-muted">Tanggal: {{ $details->first()->order_date->format('d F Y') }}</small>
                            @endif
                        </div>
                        
                        {{-- [LOGIKA STATUS ANTI-ERROR] --}}
                        @if($details->isNotEmpty())
                            @php
                                // Ambil status mentah, bersihkan dari spasi, dan ubah ke huruf kecil
                                $statusClean = strtolower(trim($details->first()->order_status ?? ''));
                                // Siapkan status asli untuk ditampilkan
                                $statusDisplay = $details->first()->order_status ?? 'N/A';
                            @endphp

                            @if (in_array($statusClean, ['selesai', 'completed', 'delivered', 'shipped']))
                                <span class="badge bg-success p-2">{{ $statusDisplay }}</span>
                            @else
                                <span class="badge bg-info text-dark p-2">{{ $statusDisplay }}</span>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 40%;">Produk</th>
                                <th scope="col" class="text-center">Jumlah</th>
                                <th scope="col" class="text-end">Harga Satuan</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $detail)
                            <tr>
                                <td>{{ $detail->product_name ?? 'Produk Tidak Ditemukan' }}</td>
                                <td class="text-center">{{ (int)($detail->quantity ?? 0) }}</td>
                                <td class="text-end">Rp {{ number_format($detail->unit_price ?? 0, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    {{-- [LOGIKA TOMBOL ANTI-ERROR] --}}
                                    @php
                                        // Pengecekan dilakukan di sini agar lebih bersih
                                        $isOrderFinished = $details->isNotEmpty() && in_array(strtolower(trim($details->first()->order_status ?? '')), ['selesai', 'completed', 'delivered', 'shipped']);
                                        $isReviewed = in_array($detail->product_id, $reviewedProductIds);
                                    @endphp

                                    @if ($isOrderFinished)
                                        @if ($isReviewed)
                                            <span class="badge bg-success">Sudah Diulas</span>
                                        @else
                                            {{-- Pastikan product_id ada sebelum membuat tombol --}}
                                            @if($detail->product_id)
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal-{{ $detail->product_id }}">
                                                    Beri Ulasan
                                                </button>
                                            @endif
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="text-center p-5 bg-light rounded">
                <p class="text-muted">Anda belum memiliki riwayat pesanan.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Mulai Belanja</a>
            </div>
        @endforelse
    </div>

    @php
        $uniqueProductsForModals = $orders->flatten()->whereNotNull('product_id')->unique('product_id');
    @endphp

    @foreach ($uniqueProductsForModals as $detail)
    <div class="modal fade" id="reviewModal-{{ $detail->product_id }}" tabindex="-1" aria-labelledby="reviewModalLabel-{{ $detail->product_id }}" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="reviewModalLabel-{{ $detail->product_id }}">Ulasan untuk {{ $detail->product_name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('reviews.store', ['product' => $detail->product_id]) }}" method="POST">
              @csrf
              <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Rating Anda</label>
                    <select class="form-select" name="rating" required>
                      <option value="">-- Pilih Bintang --</option>
                      <option value="5">★★★★★</option>
                      <option value="4">★★★★☆</option>
                      <option value="3">★★★☆☆</option>
                      <option value="2">★★☆☆☆</option>
                      <option value="1">★☆☆☆☆</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Komentar Anda</label>
                    <textarea class="form-control" name="comment" rows="4" required></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Kirim</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    @endforeach
@endsection
