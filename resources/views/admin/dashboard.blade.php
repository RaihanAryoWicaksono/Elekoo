@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 bg-gradient-to-br from-dark-800 to-dark-900 border-l-4 border-l-primary-500">
        <p class="text-sm text-dark-400 font-medium mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>
    
    <div class="card p-6 bg-gradient-to-br from-dark-800 to-dark-900 border-l-4 border-l-green-500">
        <p class="text-sm text-dark-400 font-medium mb-1">Total Pesanan</p>
        <h3 class="text-2xl font-bold text-white">{{ number_format($totalOrders) }}</h3>
    </div>
    
    <div class="card p-6 bg-gradient-to-br from-dark-800 to-dark-900 border-l-4 border-l-purple-500">
        <p class="text-sm text-dark-400 font-medium mb-1">Total Produk</p>
        <h3 class="text-2xl font-bold text-white">{{ number_format($totalProducts) }}</h3>
    </div>
    
    <div class="card p-6 bg-gradient-to-br from-dark-800 to-dark-900 border-l-4 border-l-yellow-500">
        <p class="text-sm text-dark-400 font-medium mb-1">Pelanggan Aktif</p>
        <h3 class="text-2xl font-bold text-white">{{ number_format($totalCustomers) }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Recent Orders --}}
    <div class="lg:col-span-2">
        <div class="card">
            <div class="p-6 border-b border-dark-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-primary-400 hover:text-primary-300">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-dark-300">
                    <thead class="text-xs text-dark-400 uppercase bg-dark-900 border-b border-dark-700">
                        <tr>
                            <th class="px-6 py-4 font-medium">Order ID</th>
                            <th class="px-6 py-4 font-medium">Pelanggan</th>
                            <th class="px-6 py-4 font-medium">Total</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr class="border-b border-dark-700 hover:bg-dark-700/50 transition-colors">
                                <td class="px-6 py-4 font-mono text-white">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-primary-400">{{ $order->order_number }}</a>
                                </td>
                                <td class="px-6 py-4">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 font-medium text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php $badge = $order->status_badge; @endphp
                                    <span class="badge-{{ $badge['color'] }}">{{ $badge['text'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-dark-500">Belum ada pesanan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Stats Sidebar --}}
    <div class="space-y-8">
        {{-- Order Status Stats --}}
        <div class="card p-6">
            <h3 class="text-lg font-bold text-white mb-6">Status Pesanan</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-yellow-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-yellow-400"></span> Menunggu
                    </span>
                    <span class="font-bold text-white">{{ $orderStats['pending'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-blue-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-400"></span> Diproses
                    </span>
                    <span class="font-bold text-white">{{ $orderStats['processing'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-purple-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-purple-400"></span> Dikirim
                    </span>
                    <span class="font-bold text-white">{{ $orderStats['shipped'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-green-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-400"></span> Selesai
                    </span>
                    <span class="font-bold text-white">{{ $orderStats['delivered'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-red-400 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-400"></span> Dibatalkan
                    </span>
                    <span class="font-bold text-white">{{ $orderStats['cancelled'] }}</span>
                </div>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="card p-6">
            <h3 class="text-lg font-bold text-white mb-6">Produk Terlaris</h3>
            <div class="space-y-4">
                @forelse($topProducts as $product)
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded bg-dark-700 flex-shrink-0 flex items-center justify-center overflow-hidden">
                            @if($product->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : Storage::url($product->image) }}" class="object-cover w-full h-full">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-white truncate">{{ $product->name }}</h4>
                            <p class="text-xs text-dark-400">{{ $product->order_items_count }} Terjual</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-dark-500 text-center">Belum ada data penjualan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
