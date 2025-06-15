@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold">Detail Pesanan #{{ $order->id }}</h2>
    <a href="{{ route('dashboard.orders') }}" class="btn btn-secondary">Kembali ke Riwayat</a>
</div>

<div class="row">
    <!-- Kolom Kiri: Produk yang Dipesan -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Produk yang Dipesan</div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->details as $detail)
                        <tr>
                            <td>{{ $detail->product->product_name ?? 'Produk Dihapus' }}</td>
                            <td class="text-center">{{ (int)$detail->quantity }}</td>
                            <td class="text-end">
                                {{-- Tombol "Beri Ulasan" hanya muncul jika pesanan Selesai & produk belum diulas --}}
                                @if(in_array($order->status, ['Selesai', 'completed', 'Delivered']) && !in_array($detail->product_id, $reviewedProductIds))
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal-{{ $detail->product_id }}">
                                        Beri Ulasan
                                    </button>
                                @elseif(in_array($detail->product_id, $reviewedProductIds))
                                    <span class="badge bg-success">Sudah Diulas</span>
                                @else
                                    <span class="badge bg-light text-dark">Belum Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Informasi Pesanan -->
    <div class="col-lg-4">
        {{-- ... (kode informasi pesanan tidak berubah) ... --}}
    </div>
</div>

<!-- MODAL UNTUK FORM ULASAN -->
@foreach ($order->details as $detail)
<div class="modal fade" id="reviewModal-{{ $detail->product_id }}" tabindex="-1" aria-labelledby="reviewModalLabel-{{ $detail->product_id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reviewModalLabel-{{ $detail->product_id }}">Ulasan untuk {{ $detail->product->product_name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('reviews.store', $detail->product_id) }}" method="POST">
          @csrf
          <div class="modal-body">
              <div class="mb-3">
                <label for="rating" class="form-label">Rating Anda</label>
                <select class="form-select" name="rating" id="rating" required>
                  <option value="">-- Pilih Bintang --</option>
                  <option value="5">★★★★★ (Luar Biasa)</option>
                  <option value="4">★★★★☆ (Bagus)</option>
                  <option value="3">★★★☆☆ (Cukup)</option>
                  <option value="2">★★☆☆☆ (Kurang)</option>
                  <option value="1">★☆☆☆☆ (Buruk)</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="comment" class="form-label">Komentar Anda</label>
                <textarea class="form-control" name="comment" id="comment" rows="4" placeholder="Bagaimana pengalaman Anda dengan produk ini?" required></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection