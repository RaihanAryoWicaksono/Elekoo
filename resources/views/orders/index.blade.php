@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <h1 class="text-3xl font-bold text-white mb-8">Riwayat Pesanan</h1>

    @if($orders->isEmpty())
        <div class="card p-12 text-center flex flex-col items-center justify-center">
            <div class="w-24 h-24 bg-dark-700 rounded-full flex items-center justify-center text-dark-400 mb-6">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-white mb-2">Belum Ada Pesanan</h2>
            <p class="text-dark-400 max-w-md mb-8">Anda belum pernah melakukan pembelian. Mulai belanja sekarang untuk melihat riwayat pesanan Anda di sini.</p>
            <a href="{{ route('shop.index') }}" class="btn-primary text-lg px-8">Mulai Belanja</a>
        </div>
    @else
        <div class="space-y-6 mb-8">
            @foreach($orders as $order)
                <div class="card border border-dark-700 hover:border-primary-500/50 transition-colors duration-300">
                    <div class="p-6 border-b border-dark-700 bg-dark-800/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                            <div>
                                <p class="text-xs text-dark-400 mb-1">Tanggal Pembelian</p>
                                <p class="text-sm font-medium text-white">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-dark-400 mb-1">Total Belanja</p>
                                <p class="text-sm font-bold text-primary-400">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-dark-400 mb-1">Status</p>
                                @php $badge = $order->status_badge; @endphp
                                <span class="badge-{{ $badge['color'] }}">{{ $badge['text'] }}</span>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-xs text-dark-400 mb-1">Order ID</p>
                            <p class="text-sm font-mono font-bold text-white">{{ $order->order_number }}</p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                            <div class="flex-1 min-w-0 flex items-center gap-4">
                                @if($order->items->first()->product->image)
                                    <div class="w-16 h-16 rounded-lg bg-dark-700 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        <img src="{{ \Illuminate\Support\Str::startsWith($order->items->first()->product->image, ['http://', 'https://']) ? $order->items->first()->product->image : Storage::url($order->items->first()->product->image) }}" class="object-cover w-full h-full">
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-base font-bold text-white mb-1 truncate">{{ $order->items->first()->product_name }}</h4>
                                    <p class="text-sm text-dark-400">{{ $order->items->first()->quantity }} barang x Rp {{ number_format($order->items->first()->price, 0, ',', '.') }}</p>
                                    @if($order->items->count() > 1)
                                        <p class="text-xs text-dark-500 mt-2 font-medium">+ {{ $order->items->count() - 1 }} produk lainnya</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex-shrink-0 flex gap-3 w-full md:w-auto">
                                <a href="{{ route('orders.show', $order) }}" class="btn-primary py-2 px-6 text-sm flex-1 md:flex-none text-center">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center">
            {{ $orders->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
@endsection
