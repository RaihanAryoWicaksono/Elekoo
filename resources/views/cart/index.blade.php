@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <h1 class="text-3xl font-bold text-white mb-8">Keranjang Belanja</h1>

    @if(!$cart || $cart->items->isEmpty())
        <div class="card p-12 text-center flex flex-col items-center justify-center">
            <svg class="w-48 h-48 mb-6 opacity-80" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="90" fill="#1e293b"/>
                <rect x="50" y="65" width="100" height="75" rx="12" fill="#334155" stroke="#475569" stroke-width="2"/>
                <path d="M70 65 L70 52 Q70 42 80 42 L120 42 Q130 42 130 52 L130 65" stroke="#64748b" stroke-width="3" stroke-linecap="round" fill="none"/>
                <circle cx="78" cy="152" r="10" fill="#475569" stroke="#64748b" stroke-width="2"/>
                <circle cx="122" cy="152" r="10" fill="#475569" stroke="#64748b" stroke-width="2"/>
                <path d="M82 95 L90 103 L108 85" stroke="#3b82f6" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="155" cy="55" r="18" fill="#1e3a5f" stroke="#3b82f6" stroke-width="2"/>
                <text x="155" y="61" text-anchor="middle" fill="#60a5fa" font-size="18" font-weight="bold">?</text>
            </svg>
            <h2 class="text-2xl font-bold text-white mb-2">Keranjang Masih Kosong</h2>
            <p class="text-dark-400 max-w-md mb-8">Anda belum menambahkan produk apa pun ke keranjang. Mari mulai berbelanja dan temukan gadget impian Anda!</p>
            <a href="{{ route('shop.index') }}" class="btn-primary text-lg px-8">Mulai Belanja</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="card p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
                        {{-- Product Image --}}
                        <div class="w-full sm:w-32 aspect-square rounded-xl bg-dark-700 flex-shrink-0 flex items-center justify-center overflow-hidden">
                            @if($item->product->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($item->product->image, ['http://', 'https://']) ? $item->product->image : Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="max-w-full max-h-full object-cover">
                            @else
                                <svg class="w-8 h-8 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @endif
                        </div>

                        {{-- Info & Controls --}}
                        <div class="flex-1 w-full">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 mb-4">
                                <div>
                                    <a href="{{ route('shop.show', $item->product) }}" class="text-lg font-bold text-white hover:text-primary-400 transition-colors line-clamp-2">
                                        {{ $item->product->name }}
                                    </a>
                                    <p class="text-sm text-dark-400 mt-1">{{ $item->product->category->name }}</p>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="text-lg font-bold text-white">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    @if($item->product->original_price > $item->product->price)
                                        <p class="text-xs text-dark-400 line-through">Rp {{ number_format($item->product->original_price, 0, ',', '.') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-4">
                                    @csrf
                                    @method('PATCH')
                                    <div class="relative flex items-center h-10 bg-dark-900 border border-dark-600 rounded-lg overflow-hidden w-28" x-data="{ qty: {{ $item->quantity }}, max: {{ $item->product->stock }} }">
                                        <button type="button" @click="qty = qty > 1 ? qty - 1 : 1; $refs.form.submit()" class="px-3 text-dark-300 hover:text-white transition-colors h-full">-</button>
                                        <input type="number" name="quantity" x-model="qty" min="1" max="{{ $item->product->stock }}" class="w-full h-full bg-transparent border-none text-center text-white text-sm focus:ring-0 p-0" onchange="this.form.submit()">
                                        <button type="button" @click="qty = qty < max ? qty + 1 : max; $refs.form.submit()" class="px-3 text-dark-300 hover:text-white transition-colors h-full">+</button>
                                    </div>
                                </form>

                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition-colors flex items-center gap-1 font-medium" onclick="return confirm('Hapus produk ini dari keranjang?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="hidden sm:inline">Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary Sidebar --}}
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-white mb-6 pb-4 border-b border-dark-700">Ringkasan Belanja</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-dark-300">
                            <span>Total Harga ({{ $cart->count }} barang)</span>
                            <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-dark-300">
                            <span>Estimasi Ongkos Kirim</span>
                            <span>Dihitung saat checkout</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-dark-700 pt-4 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-white">Total Bayar</span>
                            <span class="text-2xl font-black text-white">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-primary w-full text-lg justify-center shadow-primary-500/25 shadow-xl">
                        Lanjut ke Checkout
                    </a>
                    
                    <a href="{{ route('shop.index') }}" class="block text-center text-primary-400 hover:text-primary-300 font-medium mt-6 text-sm">
                        &larr; Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
