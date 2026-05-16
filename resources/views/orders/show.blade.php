@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    
    <nav class="flex text-sm text-dark-400 mb-8">
        <a href="{{ route('orders.index') }}" class="hover:text-white transition-colors">&larr; Kembali ke Daftar Pesanan</a>
    </nav>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                Detail Pesanan
                @php $badge = $order->status_badge; @endphp
                <span class="badge-{{ $badge['color'] }} text-sm px-3 py-1">{{ $badge['text'] }}</span>
            </h1>
            <p class="text-dark-400 mt-2 font-mono">{{ $order->order_number }} • {{ $order->created_at->format('d F Y, H:i') }}</p>
        </div>
        
        @if(in_array($order->status, ['pending', 'processing']))
            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Stok akan dikembalikan.')">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-danger py-2">Batalkan Pesanan</button>
            </form>
        @endif
    </div>

    @if($order->status === 'pending' && $order->payment_method === 'transfer')
        <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-6 mb-8 flex gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-blue-300 mb-2">Menunggu Pembayaran Transfer</h3>
                <p class="text-blue-200/70 text-sm mb-4">Silakan lakukan transfer sesuai total tagihan ke salah satu rekening berikut:</p>
                <div class="space-y-2">
                    <div class="bg-dark-900/50 p-3 rounded-lg border border-blue-500/20 flex justify-between items-center">
                        <div>
                            <p class="text-xs text-dark-400 font-medium">BCA - PT Elekoo Indonesia</p>
                            <p class="text-lg font-mono font-bold text-white tracking-wider">1234 5678 90</p>
                        </div>
                    </div>
                </div>
                <p class="text-blue-200/70 text-xs mt-3">Pesanan akan otomatis dibatalkan jika tidak ada pembayaran dalam 24 jam.</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        {{-- Shipping Info --}}
        <div class="md:col-span-2 space-y-8">
            <div class="card p-6 md:p-8">
                <h2 class="text-xl font-bold text-white mb-6 border-b border-dark-700 pb-4">Alamat Pengiriman</h2>
                <div class="space-y-2 text-sm">
                    <p class="font-bold text-white text-base">{{ $order->shipping_name }}</p>
                    <p class="text-dark-300">{{ $order->shipping_phone }}</p>
                    <p class="text-dark-300 mt-2">{{ $order->shipping_address }}</p>
                    <p class="text-dark-300">{{ $order->shipping_city }}, {{ $order->shipping_province }}</p>
                    <p class="text-dark-300">{{ $order->shipping_postal_code }}</p>
                </div>
            </div>

            <div class="card p-6 md:p-8">
                <h2 class="text-xl font-bold text-white mb-6 border-b border-dark-700 pb-4">Daftar Produk</h2>
                <div class="space-y-6">
                    @foreach($order->items as $item)
                        <div class="flex gap-4">
                            <div class="w-20 h-20 rounded-xl bg-dark-700 flex-shrink-0 flex items-center justify-center overflow-hidden border border-dark-600">
                                @if($item->product && $item->product->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($item->product->image, ['http://', 'https://']) ? $item->product->image : Storage::url($item->product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-bold text-white line-clamp-2 mb-1">
                                    @if($item->product)
                                        <a href="{{ route('shop.show', $item->product) }}" class="hover:text-primary-400 transition-colors">{{ $item->product_name }}</a>
                                    @else
                                        {{ $item->product_name }} <span class="text-xs text-red-400 font-normal">(Produk Dihapus)</span>
                                    @endif
                                </h4>
                                <p class="text-sm text-dark-400 mb-2">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                <p class="text-sm font-bold text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Payment Summary --}}
        <div class="md:col-span-1">
            <div class="card p-6 sticky top-24">
                <h2 class="text-lg font-bold text-white mb-6 border-b border-dark-700 pb-4">Rincian Pembayaran</h2>
                
                <div class="space-y-4 mb-6 text-sm">
                    <div class="flex justify-between items-center text-dark-300">
                        <span>Metode Pembayaran</span>
                        <span class="font-medium text-white uppercase">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between items-center text-dark-300">
                        <span>Status Pembayaran</span>
                        <span class="badge {{ $order->payment_status === 'paid' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="space-y-3 mb-6 border-t border-dark-700 pt-6 text-sm">
                    <div class="flex justify-between text-dark-300">
                        <span>Total Harga ({{ $order->items->sum('quantity') }} barang)</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-dark-300">
                        <span>Total Ongkos Kirim</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="border-t border-dark-700 pt-4">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-base font-bold text-white">Total Belanja</span>
                        <span class="text-xl font-black text-primary-400">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
