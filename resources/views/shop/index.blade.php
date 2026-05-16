@extends('layouts.app')

@section('title', 'Toko')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    
    {{-- Breadcrumbs --}}
    <nav class="flex text-sm text-dark-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
        <span class="mx-2">/</span>
        <span class="text-white">Toko</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar Filters --}}
        <div class="w-full lg:w-64 flex-shrink-0" x-data="{ showFilters: false }">
            <div class="flex items-center justify-between lg:hidden mb-4">
                <h2 class="text-lg font-bold text-white">Filter</h2>
                <button @click="showFilters = !showFilters" class="btn-secondary py-2 px-4 text-sm">
                    <span x-show="!showFilters">Tampilkan Filter</span>
                    <span x-show="showFilters">Sembunyikan</span>
                </button>
            </div>

            <div class="card p-5 lg:block" :class="{'hidden': !showFilters, 'block': showFilters}">
                <form action="{{ route('shop.index') }}" method="GET" id="filter-form" @submit="$dispatch('filter-loading')" x-on:submit="loading = true">
                    {{-- Preserve existing search if any --}}
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="mb-6">
                        <h3 class="font-semibold text-white mb-3">Kategori</h3>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="category" value="" onchange="this.form.submit()" class="text-primary-500 focus:ring-primary-500 bg-dark-700 border-dark-600" {{ !request('category') ? 'checked' : '' }}>
                                <span class="text-dark-300 group-hover:text-white transition-colors text-sm">Semua Kategori</span>
                            </label>
                            @foreach($categories as $category)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="category" value="{{ $category->slug }}" onchange="this.form.submit()" class="text-primary-500 focus:ring-primary-500 bg-dark-700 border-dark-600" {{ request('category') === $category->slug ? 'checked' : '' }}>
                                    <span class="text-dark-300 group-hover:text-white transition-colors text-sm">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-white mb-3">Harga</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="input-field py-2 text-sm text-center">
                            </div>
                            <div>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="input-field py-2 text-sm text-center">
                            </div>
                        </div>
                        <button type="submit" class="w-full btn-secondary py-2 mt-3 text-sm">Terapkan Harga</button>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-white mb-3">Brand</h3>
                        <select name="brand" onchange="this.form.submit()" class="input-field py-2.5 text-sm appearance-none">
                            <option value="">Semua Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') === $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(request()->anyFilled(['category', 'brand', 'min_price', 'max_price', 'search']))
                        <a href="{{ route('shop.index') }}" class="w-full btn-danger py-2 block text-center mt-6">Reset Filter</a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="flex-1" x-data="{ loading: false }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-white">
                        @if(request('search'))
                            Pencarian: "{{ request('search') }}"
                        @elseif(request('category'))
                            Kategori: {{ $categories->where('slug', request('category'))->first()->name ?? 'Semua' }}
                        @else
                            Semua Produk
                        @endif
                    </h1>
                    <p class="text-sm text-dark-400 mt-1">Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk</p>
                </div>

                <div class="flex items-center gap-2">
                    <label class="text-sm text-dark-300">Urutkan:</label>
                    <select form="filter-form" name="sort" onchange="document.getElementById('filter-form').submit()" class="input-field py-2 text-sm w-auto">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Paling Populer</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                    </select>
                </div>
            </div>

            {{-- Skeleton Loading --}}
            <div x-show="loading" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
                @for($i = 0; $i < 6; $i++)
                    <div class="card animate-pulse">
                        <div class="aspect-square bg-dark-700"></div>
                        <div class="p-5 space-y-3">
                            <div class="h-3 bg-dark-700 rounded w-1/3"></div>
                            <div class="h-5 bg-dark-700 rounded w-4/5"></div>
                            <div class="h-4 bg-dark-700 rounded w-1/2"></div>
                            <div class="h-6 bg-dark-700 rounded w-2/5 mt-4"></div>
                            <div class="h-10 bg-dark-700 rounded-xl w-full mt-2"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <div x-show="!loading">
            @if($products->isEmpty())
                <div class="card p-12 text-center flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-dark-700 rounded-full flex items-center justify-center text-dark-400 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-2">Produk Tidak Ditemukan</h2>
                    <p class="text-dark-400 max-w-md">Maaf, kami tidak dapat menemukan produk yang sesuai dengan filter pencarian Anda. Silakan coba kriteria lain.</p>
                    <a href="{{ route('shop.index') }}" class="btn-primary mt-6">Kembali ke Semua Produk</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
                    @foreach($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center">
                    {{ $products->links('vendor.pagination.tailwind') }}
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
