@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<h1>Checkout</h1>
<form action="{{ route('checkout.process') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Detail Pengiriman</h5>
                    <hr>
                    <div class="mb-3">
                        <label for="ship_address" class="form-label">Alamat Lengkap Pengiriman</label>
                        <textarea class="form-control @error('ship_address') is-invalid @enderror" id="ship_address" name="ship_address" rows="3" required>{{ old('ship_address', Auth::user()->profile->address ?? '') }}</textarea>
                        @error('ship_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="shipper_id" class="form-label">Pilih Ekspedisi</label>
                        <select class="form-select @error('shipper_id') is-invalid @enderror" name="shipper_id" required>
                            <option value="">-- Pilih Jasa Pengiriman --</option>
                            @foreach ($shippers as $shipper)
                                <option value="{{ $shipper->id }}">{{ $shipper->company_name }}</option>
                            @endforeach
                        </select>
                         @error('shipper_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $item->product->name }} <small> (x{{ $item->quantity }})</small></span>
                                <span>{{ 'Rp ' . number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between align-items-center fw-bold h5">
                            <span>TOTAL</span>
                            <span>{{ 'Rp ' . number_format($total, 0, ',', '.') }}</span>
                        </li>
                    </ul>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary btn-lg">Buat Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection