<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('product_category', $request->category);
        }
        
        $products = $query->latest()->paginate(10);
        
        $categories = Product::select('product_category')->whereNotNull('product_category')->distinct()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            
            $image = Image::read($file);
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $path = 'products/' . $fileName;
            Storage::disk('public')->put($path, $image->toJpeg(75));
            
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk baru berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            
            $image = Image::read($file);
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $path = 'products/' . $fileName;
            Storage::disk('public')->put($path, $image->toJpeg(75));
            
            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        
        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}
