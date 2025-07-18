@extends('admin.layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h2">Daftar Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Tambah Produk Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->product_category ?? '-' }}</td>
                            <td class="text-end">Rp {{ number_format($product->list_price, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $product->stock }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $products->links() }}
        </div>
    </div>
@endsection