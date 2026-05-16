@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <h1 class="text-3xl font-bold text-white mb-8">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Form Checkout --}}
        <div class="lg:col-span-2">
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                
                <div class="card p-6 md:p-8 mb-6">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-primary-500/20 text-primary-400 flex items-center justify-center text-sm">1</div>
                        Informasi Pengiriman
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="label">Nama Penerima <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" class="input-field" required>
                            @error('shipping_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" class="input-field" required>
                            @error('shipping_phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="label">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="shipping_address" rows="3" class="input-field resize-none" required placeholder="Nama Jalan, Gedung, No. Rumah">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                        @error('shipping_address') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="label">Provinsi <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_province" value="{{ old('shipping_province') }}" class="input-field" required>
                            @error('shipping_province') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Kota / Kabupaten <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" class="input-field" required>
                            @error('shipping_city') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Kode Pos <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" class="input-field" required>
                            @error('shipping_postal_code') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="card p-6 md:p-8 mb-6">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-primary-500/20 text-primary-400 flex items-center justify-center text-sm">2</div>
                        Metode Pembayaran
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex cursor-pointer rounded-xl border border-dark-600 bg-dark-700 p-4 focus:outline-none">
                            <input type="radio" name="payment_method" value="transfer" class="peer sr-only" {{ old('payment_method', 'transfer') === 'transfer' ? 'checked' : '' }}>
                            <div class="flex w-full items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-dark-600 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-white">Transfer Bank</p>
                                        <p class="text-sm text-dark-400">BCA, Mandiri, BNI, BRI</p>
                                    </div>
                                </div>
                                <div class="h-5 w-5 rounded-full border border-dark-500 peer-checked:border-primary-500 peer-checked:bg-primary-500 flex items-center justify-center">
                                    <div class="h-2.5 w-2.5 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                                </div>
                            </div>
                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary-500 pointer-events-none"></div>
                        </label>

                        <label class="relative flex cursor-pointer rounded-xl border border-dark-600 bg-dark-700 p-4 focus:outline-none">
                            <input type="radio" name="payment_method" value="cod" class="peer sr-only" {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                            <div class="flex w-full items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-dark-600 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-white">Bayar di Tempat (COD)</p>
                                        <p class="text-sm text-dark-400">Bayar saat barang sampai</p>
                                    </div>
                                </div>
                                <div class="h-5 w-5 rounded-full border border-dark-500 peer-checked:border-primary-500 peer-checked:bg-primary-500 flex items-center justify-center">
                                    <div class="h-2.5 w-2.5 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                                </div>
                            </div>
                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-primary-500 pointer-events-none"></div>
                        </label>
                    </div>
                    @error('payment_method') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                <div class="card p-6 md:p-8">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-primary-500/20 text-primary-400 flex items-center justify-center text-sm">3</div>
                        Catatan Pesanan (Opsional)
                    </h2>
                    <textarea name="notes" rows="2" class="input-field resize-none" placeholder="Pesan khusus untuk kurir atau penjual...">{{ old('notes') }}</textarea>
                </div>
            </form>
        </div>

        {{-- Order Summary --}}
        <div class="lg:col-span-1">
            <div class="card p-6 sticky top-24">
                <h2 class="text-xl font-bold text-white mb-6 pb-4 border-b border-dark-700">Ringkasan Pesanan</h2>
                
                <div class="space-y-4 mb-6 max-h-[40vh] overflow-y-auto pr-2 scrollbar-hide">
                    @foreach($cart->items as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-16 rounded-lg bg-dark-700 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                @if($item->product->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($item->product->image, ['http://', 'https://']) ? $item->product->image : Storage::url($item->product->image) }}" class="object-cover">
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-white line-clamp-2 leading-tight">{{ $item->product->name }}</h4>
                                <div class="text-xs text-dark-400 mt-1">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @php
                    $subtotal = $cart->total;
                    $shipping = 15000; // Fixed shipping for demo
                    $total = $subtotal + $shipping;
                @endphp

                <div class="space-y-3 mb-6 border-t border-dark-700 pt-6">
                    <div class="flex justify-between text-dark-300 text-sm">
                        <span>Total Harga ({{ $cart->count }} barang)</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-dark-300 text-sm">
                        <span>Ongkos Kirim (Flat)</span>
                        <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="border-t border-dark-700 pt-4 mb-8">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-white">Total Tagihan</span>
                        <span class="text-2xl font-black text-primary-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit" form="checkout-form" class="btn-primary w-full text-lg justify-center shadow-primary-500/25 shadow-xl">
                    Buat Pesanan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
