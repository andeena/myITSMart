@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<h1 class="fw-bold mb-4">Checkout</h1>

<form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
    @csrf
    <div class="row g-4">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Detail Pengiriman</h5>
                    <hr>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Alamat Lengkap Pengiriman</label>
                        <textarea class="form-control" name="shipping_address" id="shipping_address" rows="4" placeholder="Masukkan alamat lengkap Anda di sini..." required>{{ old('shipping_address', Auth::user()->profile->address ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="shipper_id" class="form-label">Pilih Opsi Pengiriman</label>
                        <select name="shipper_id" id="shipper_id" class="form-select" required>
                            <option value="">-- Pilih Kurir --</option>
                            @foreach ($shippers as $shipper)
                                <option value="{{ $shipper->id }}">{{ $shipper->company_name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Biaya pengiriman akan diinformasikan kemudian oleh admin.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Ringkasan Pesanan</h5>
                    <hr>
                    <ul class="list-group list-group-flush">
                        @foreach ($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $item->product->product_name ?? 'N/A' }} <small> (x{{ $item->quantity }})</small></span>
                                <span>Rp {{ number_format(($item->product->list_price ?? 0) * $item->quantity, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between align-items-center fw-bold h5">
                            <span>TOTAL</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </li>
                    </ul>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary btn-lg">Lanjutkan ke Pembayaran</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection