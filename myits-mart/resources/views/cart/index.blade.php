@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<h1>Keranjang Belanja</h1>

@if ($cartItems->isEmpty())
    <div class="alert alert-info">
        Keranjang belanja Anda masih kosong. Yuk, <a href="{{ route('products.index') }}">mulai belanja</a>!
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th width="150px">Kuantitas</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                @if($item->product)
                                    <img src="{{ $item->product->image_url }}" width="50" class="me-2 rounded">
                                    {{ $item->product->name }}
                                @else
                                    Produk telah dihapus
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->product->list_price ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" class="form-control form-control-sm" min="1">
                                        <button class="btn btn-sm btn-outline-secondary" type="submit">Update</button>
                                    </div>
                                </form>
                            </td>
                            <td><strong>Rp {{ number_format(($item->product->list_price ?? 0) * $item->quantity, 0, ',', '.') }}</strong></td>
                            <td>
                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-end align-items-center mt-3">
        <h4 class="me-3">Total: <span class="text-primary">{{ 'Rp ' . number_format($total, 0, ',', '.') }}</span></h4>
        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg">Lanjutkan ke Checkout</a>
    </div>
@endif
@endsection