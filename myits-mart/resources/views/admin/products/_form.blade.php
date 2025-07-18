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
    <label for="product_name" class="form-label">Nama Produk</label>
    <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="image" class="form-label">Foto Produk</label>
    <input type="file" class="form-control" id="image" name="image">
    @if (isset($product) && $product->image)
        <div class="mt-2">
            <small>Gambar saat ini:</small><br>
            <img src="{{ asset('storage/' . $product->image) }}" alt="Foto Produk" style="max-height: 100px;">
        </div>
    @endif
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="list_price" class="form-label">Harga</label>
        <input type="number" step="0.01" class="form-control" id="list_price" name="list_price" value="{{ old('list_price', $product->list_price ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="stock" class="form-label">Stok</label>
        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required>
    </div>
</div>
<div class="mb-3">
    <label for="product_category" class="form-label">Kategori</label>
    <input type="text" class="form-control" id="product_category" name="product_category" value="{{ old('product_category', $product->product_category ?? '') }}">
</div>
<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
</div>
