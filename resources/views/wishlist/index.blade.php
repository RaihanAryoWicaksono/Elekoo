@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-white">Wishlist Saya</h1>
        <span class="badge bg-dark-700 text-dark-300 px-4 py-1 text-sm">{{ $wishlists->count() }} Produk</span>
    </div>

    @if($wishlists->isEmpty())
        <div class="card p-12 text-center flex flex-col items-center justify-center">
            <svg class="w-48 h-48 mb-6 opacity-80" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="90" fill="#1e293b"/>
                <path d="M100 148 L55 103 C44 92 44 74 55 63 C61 57 69 54 77 54 C85 54 93 57 100 63 C107 57 115 54 123 54 C131 54 139 57 145 63 C156 74 156 92 145 103 Z" fill="#1e3a5f" stroke="#3b82f6" stroke-width="2.5"/>
                <path d="M100 130 L65 95 C57 87 57 76 65 68 C69 64 74 62 79 62 C84 62 89 64 100 73" stroke="#60a5fa" stroke-width="2" fill="none" opacity="0.5"/>
                <circle cx="148" cy="62" r="22" fill="#1a1a2e" stroke="#f97316" stroke-width="2"/>
                <path d="M140 62 L148 54 L156 62 M148 54 L148 70" stroke="#f97316" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h2 class="text-2xl font-bold text-white mb-2">Wishlist Kosong</h2>
            <p class="text-dark-400 max-w-md mb-8">Anda belum menambahkan produk favorit. Simpan produk yang Anda suka di sini untuk dibeli nanti.</p>
            <a href="{{ route('shop.index') }}" class="btn-primary text-lg px-8">Jelajahi Produk</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $wishlist)
                <div class="product-card flex flex-col h-full relative group">
                    {{-- Remove from Wishlist --}}
                    <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <form action="{{ route('wishlist.toggle', $wishlist->product) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 rounded-full bg-red-500/90 text-white hover:bg-red-600 transition-all shadow-lg" title="Hapus dari Wishlist">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </form>
                    </div>

                    <div class="relative aspect-square overflow-hidden bg-dark-700">
                        @if($wishlist->product->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($wishlist->product->image, ['http://', 'https://']) ? $wishlist->product->image : Storage::url($wishlist->product->image) }}" alt="{{ $wishlist->product->name }}">
                        @endif
                    </div>
                    
                    <div class="p-5 flex flex-col flex-1">
                        <a href="{{ route('shop.index', ['category' => $wishlist->product->category->slug]) }}" class="text-xs font-semibold text-primary-400 mb-2 hover:underline tracking-wide uppercase">{{ $wishlist->product->category->name }}</a>
                        <a href="{{ route('shop.show', $wishlist->product) }}" class="text-lg font-bold text-white mb-4 line-clamp-2 hover:text-primary-400 transition-colors">
                            {{ $wishlist->product->name }}
                        </a>
                        
                        <div class="mt-auto">
                            <div class="text-xl font-bold text-white mb-4">Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}</div>
                            
                            @if($wishlist->product->stock > 0)
                                <form action="{{ route('cart.add', $wishlist->product) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full btn-primary py-2 text-sm">Masuk Keranjang</button>
                                </form>
                            @else
                                <button disabled class="w-full btn-secondary py-2 text-sm opacity-50">Stok Habis</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
