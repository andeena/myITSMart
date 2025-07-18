@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <h1 class="h2">Edit Produk: {{ $product->product_name }}</h1>
    
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.products._form')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Produk</button>
                </div>
            </form>
        </div>
    </div>
@endsection