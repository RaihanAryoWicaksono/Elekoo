@extends('layouts.app')

@section('title', $product->name)
@section('metaDescription', Str::limit($product->description, 150))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    
    {{-- Breadcrumbs --}}
    <nav class="flex text-sm text-dark-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
        <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ route('shop.index') }}" class="hover:text-white transition-colors">Toko</a>
        <span class="mx-2">/</span>
        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-white transition-colors">{{ $product->category->name }}</a>
        <span class="mx-2">/</span>
        <span class="text-white truncate">{{ $product->name }}</span>
    </nav>

    <div class="bg-dark-800 rounded-3xl border border-dark-700 overflow-hidden mb-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
            {{-- Product Image --}}
            <div class="relative bg-dark-700 aspect-square lg:aspect-auto lg:min-h-[600px] flex items-center justify-center p-8 group">
                @if($product->image)
                    <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : Storage::url($product->image) }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain drop-shadow-2xl group-hover:scale-105 transition-transform duration-500">
                @else
                    <svg class="w-32 h-32 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                @endif
                
                @if($product->discount_percentage)
                    <div class="absolute top-6 left-6 badge bg-red-500 text-white text-sm px-3 py-1 shadow-lg">-{{ $product->discount_percentage }}%</div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="p-8 lg:p-12 flex flex-col">
                <a href="{{ route('shop.index', ['brand' => $product->brand]) }}" class="text-sm font-semibold text-primary-400 mb-3 hover:underline tracking-wide uppercase">{{ $product->brand ?? 'No Brand' }}</a>
                
                <h1 class="text-3xl lg:text-4xl font-bold text-white mb-4 leading-tight">{{ $product->name }}</h1>
                
                <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-dark-700">
                    <div class="flex items-center gap-1">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($product->rating) ? 'fill-current' : 'text-dark-600' }}" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-dark-300 ml-1">({{ $product->review_count }} Ulasan)</span>
                    </div>
                    <span class="w-1 h-1 rounded-full bg-dark-600"></span>
                    <span class="text-sm {{ $product->stock > 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ $product->stock > 0 ? 'Stok Tersedia: ' . $product->stock : 'Stok Habis' }}
                    </span>
                </div>

                <div class="mb-8">
                    @if($product->original_price > $product->price)
                        <div class="text-lg text-dark-400 line-through mb-1">Rp {{ number_format($product->original_price, 0, ',', '.') }}</div>
                    @endif
                    <div class="text-4xl font-black text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>

                <div class="prose prose-invert prose-sm text-dark-300 mb-10 max-w-none">
                    <p>{{ $product->description }}</p>
                </div>

                <div class="mt-auto pt-6 border-t border-dark-700">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1 flex gap-4">
                            @csrf
                            <div class="w-32">
                                <label class="sr-only">Kuantitas</label>
                                <div class="relative flex items-center h-14 bg-dark-900 border border-dark-600 rounded-xl overflow-hidden" x-data="{ qty: 1, max: {{ $product->stock }} }">
                                    <button type="button" @click="qty = qty > 1 ? qty - 1 : 1" class="px-4 text-dark-300 hover:text-white transition-colors h-full">-</button>
                                    <input type="number" name="quantity" x-model="qty" min="1" max="{{ $product->stock }}" class="w-full h-full bg-transparent border-none text-center text-white focus:ring-0 p-0" readonly>
                                    <button type="button" @click="qty = qty < max ? qty + 1 : max" class="px-4 text-dark-300 hover:text-white transition-colors h-full">+</button>
                                </div>
                            </div>
                            
                            @if($product->stock > 0)
                                <button type="submit" class="flex-1 btn-primary h-14 text-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Tambah
                                </button>
                            @else
                                <button disabled type="button" class="flex-1 btn-secondary h-14 text-lg opacity-50 cursor-not-allowed">Stok Habis</button>
                            @endif
                        </form>
                        
                        <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="h-14 w-14 rounded-xl border-2 {{ $isWishlisted ? 'border-red-500 text-red-500 bg-red-500/10' : 'border-dark-600 text-dark-300 hover:border-red-500 hover:text-red-500' }} flex items-center justify-center transition-colors" title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}">
                                <svg class="w-6 h-6 {{ $isWishlisted ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Specs & Details Tabs --}}
    @if($product->specifications)
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-white mb-6">Spesifikasi Detail</h2>
        <div class="card p-6 md:p-8">
            <div class="prose prose-invert max-w-none">
                {!! nl2br(e($product->specifications)) !!}
            </div>
        </div>
    </div>
    @endif

    {{-- Related Products --}}
    @if($relatedProducts->isNotEmpty())
    <div>
        <h2 class="text-2xl font-bold text-white mb-6">Produk Terkait</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
                @include('components.product-card', ['product' => $related])
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
