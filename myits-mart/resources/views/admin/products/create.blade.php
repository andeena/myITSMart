@extends('admin.layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
    <h1 class="h2">Tambah Produk Baru</h1>
    
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @include('admin.products._form')
                
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
@endsection