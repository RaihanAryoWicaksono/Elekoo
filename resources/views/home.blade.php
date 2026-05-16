@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
{{-- Hero Section --}}
<div class="relative overflow-hidden bg-dark-900 border-b border-dark-800">
    <div class="absolute inset-0 bg-hero-gradient opacity-50"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative pt-20 pb-32">
        <div class="text-center max-w-3xl mx-auto animate-slide-up">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-500/10 border border-primary-500/20 text-primary-400 text-sm font-medium mb-6">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                </span>
                Koleksi Terbaru 2026
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tight">
                Your Future <span class="text-gradient">Tech</span>, <br> Today.
            </h1>
            <p class="text-lg text-dark-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                Temukan perangkat elektronik canggih untuk gaya hidup modern Anda. Kualitas terjamin dengan harga terbaik hanya di Elekoo.
            </p>
            <div class="flex items-center justify-center gap-4">
                <a href="{{ route('shop.index') }}" class="btn-primary text-lg px-8 py-4">Mulai Belanja</a>
                <a href="#categories" class="btn-outline text-lg px-8 py-4">Lihat Kategori</a>
            </div>
        </div>
    </div>
</div>

{{-- Categories Section --}}
<div id="categories" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex items-end justify-between mb-10">
        <div>
            <h2 class="section-title">Kategori Pilihan</h2>
            <p class="section-subtitle">Jelajahi produk berdasarkan kategori favorit Anda</p>
        </div>
        <a href="{{ route('shop.index') }}" class="text-primary-400 hover:text-primary-300 font-medium hidden sm:block">Lihat Semua &rarr;</a>
    </div>

    <div class="flex flex-wrap items-center justify-start lg:justify-center gap-4 sm:gap-6">
        @foreach($categories->take(6) as $category)
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="card-hover p-6 text-center group w-[45%] sm:w-48 flex-shrink-0">
                <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-dark-700 flex items-center justify-center group-hover:scale-110 group-hover:bg-primary-500/20 transition-all duration-300">
                    @if($category->image)
                        <img src="{{ \Illuminate\Support\Str::startsWith($category->image, ['http://', 'https://']) ? $category->image : Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-12 h-12 object-contain">
                    @else
                        <svg class="w-10 h-10 text-dark-400 group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    @endif
                </div>
                <h3 class="font-medium text-white group-hover:text-primary-400 transition-colors text-lg">{{ $category->name }}</h3>
            </a>
        @endforeach
    </div>
</div>

{{-- Featured Products --}}
<div class="bg-dark-950 py-20 border-y border-dark-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="section-title">Produk Unggulan</h2>
            <p class="section-subtitle">Gadget terbaik pilihan Elekoo minggu ini</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</div>

{{-- New Arrivals --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex items-end justify-between mb-10">
        <div>
            <h2 class="section-title">Rilis Terbaru</h2>
            <p class="section-subtitle">Jangan lewatkan teknologi terbaru yang baru tiba</p>
        </div>
        <a href="{{ route('shop.index', ['sort' => 'newest']) }}" class="text-primary-400 hover:text-primary-300 font-medium hidden sm:block">Lihat Semua &rarr;</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($newArrivals as $product)
            @include('components.product-card', ['product' => $product])
        @endforeach
    </div>
</div>

{{-- Features/Benefits --}}
<div class="bg-dark-800 border-y border-dark-700 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6">
                <div class="w-16 h-16 mx-auto bg-blue-500/10 text-blue-400 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Gratis Ongkir</h3>
                <p class="text-dark-400">Untuk setiap pembelian di atas Rp 1.000.000 ke seluruh Indonesia</p>
            </div>
            <div class="p-6">
                <div class="w-16 h-16 mx-auto bg-green-500/10 text-green-400 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Garansi Resmi</h3>
                <p class="text-dark-400">Semua produk kami dijamin asli dan memiliki garansi resmi pabrik</p>
            </div>
            <div class="p-6">
                <div class="w-16 h-16 mx-auto bg-purple-500/10 text-purple-400 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Dukungan 24/7</h3>
                <p class="text-dark-400">Tim kami siap membantu Anda kapan saja via live chat dan telepon</p>
            </div>
        </div>
    </div>
</div>
@endsection
