<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - myITS Mart</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc; /* slate-50 */
        }
        .its-blue {
            color: #2563eb;
        }
        .bg-its-blue {
            background-color: #2563eb;
        }
        .hover\:bg-its-blue-dark:hover {
            background-color: #1d4ed8;
        }
        .ring-its-blue:focus {
            --tw-ring-color: #2563eb;
        }
    </style>
</head>
<body class="antialiased">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center font-bold text-2xl its-blue">
                        myITS Mart
                    </a>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Lihat Semua Produk</a>
                    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                </div>
            </div>
        </div>
    </nav>
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            
            <div>
                <div class="aspect-w-1 aspect-h-1 w-full bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center">
                </div>
            </div>

            <div class="flex flex-col">
                <h1 class="text-4xl font-extrabold tracking-tight text-slate-800">{{ $product->name }}</h1>
                
                <div class="mt-3">
                    <p class="text-3xl text-slate-900 font-light">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                <div class="mt-4 flex items-center">
                    <div class="flex items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="h-5 w-5 flex-shrink-0 {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10.868 2.884c.321-.662 1.215-.662 1.536 0l1.832 3.754 4.145.603c.731.106 1.023.998.494 1.512l-2.999 2.923.708 4.129c.125.728-.638 1.283-1.29.948L10 14.89l-3.715 1.952c-.652.335-1.415-.22-1.29-.948l.708-4.129-2.999-2.923c-.529-.514-.237-1.406.494-1.512l4.145-.603L10.868 2.884z" clip-rule="evenodd" />
                            </svg>
                        @endfor
                    </div>
                    <p class="ml-2 text-sm text-gray-500">{{ $product->reviews->count() }} ulasan</p>
                </div>

                <div class="mt-6">
                    <h3 class="sr-only">Deskripsi</h3>
                    <div class="space-y-6 text-base text-gray-700">
                        <p>{{ $product->description }}</p>
                    </div>
                </div>

                <div class="mt-6">
                     @if($product->stock > 0)
                        <p class="text-sm font-medium inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-green-800">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Stok Tersedia ({{ $product->stock }})
                        </p>
                    @else
                        <p class="text-sm font-medium inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-red-800">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                            Stok Habis
                        </p>
                    @endif
                </div>

                @if($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-8">
                    @csrf
                    <div class="flex items-center space-x-4">
                         <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                         <button type="submit" class="flex-1 rounded-md border border-transparent bg-its-blue px-8 py-3 text-base font-medium text-white shadow-sm hover:bg-its-blue-dark focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                            Tambah ke Keranjang
                         </button>
                    </div>
                </form>
                @endif
            </div>
        </div>

        @if (count($alsoBoughtProducts) > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Pelanggan Lain Juga Membeli</h2>
            <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
                @foreach ($alsoBoughtProducts as $relatedProduct)
                    <div class="group relative">
                        <div class="h-56 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75">
                             {{-- Placeholder untuk gambar --}}
                             <img src="https://placehold.co/400x400/0A6EBD/white?text={{ urlencode($relatedProduct->product_name) }}" alt="{{ $relatedProduct->product_name }}" class="h-full w-full object-cover object-center">
                        </div>
                        <h3 class="mt-4 text-sm text-gray-700">
                            <a href="{{ route('products.show', $relatedProduct->id) }}">
                                <span class="absolute inset-0"></span>
                                {{ $relatedProduct->product_name }}
                            </a>
                        </h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">
                            Rp {{ number_format($relatedProduct->list_price, 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <div class="mt-16">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Ulasan Pelanggan</h2>
            <div class="mt-6 space-y-10">
                @forelse ($product->reviews as $review)
                    <div class="flex space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-xl font-bold text-gray-600">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                <svg class="h-5 w-5 flex-shrink-0 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.868 2.884c.321-.662 1.215-.662 1.536 0l1.832 3.754 4.145.603c.731.106 1.023.998.494 1.512l-2.999 2.923.708 4.129c.125.728-.638 1.283-1.29.948L10 14.89l-3.715 1.952c-.652.335-1.415-.22-1.29-.948l.708-4.129-2.999-2.923c-.529-.514-.237-1.406.494-1.512l4.145-.603L10.868 2.884z" clip-rule="evenodd" /></svg>
                                @endfor
                            </div>
                            <p class="sr-only">{{ $review->rating }} dari 5 bintang</p>
                            <div class="mt-2 prose prose-sm max-w-none text-gray-600">
                                <p>{{ $review->comment }}</p>
                            </div>
                            <p class="mt-3 text-sm font-medium text-gray-900">
                                oleh {{ $review->user->name }} pada {{ $review->created_at->format('d F Y') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 px-4 border-2 border-dashed rounded-lg">
                        <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>