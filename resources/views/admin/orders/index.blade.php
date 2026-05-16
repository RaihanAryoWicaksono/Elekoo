@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="card mb-6 p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-lg font-bold text-white">Daftar Pesanan</h2>
        <p class="text-sm text-dark-400">Pantau dan kelola pesanan masuk.</p>
    </div>
    
    <div class="flex gap-2">
        <a href="{{ route('admin.orders.index') }}" class="btn-secondary text-sm {{ !request('status') ? 'border-primary-500 text-white' : '' }}">Semua</a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn-secondary text-sm {{ request('status') == 'pending' ? 'border-yellow-500 text-yellow-400' : '' }}">Menunggu</a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="btn-secondary text-sm {{ request('status') == 'processing' ? 'border-blue-500 text-blue-400' : '' }}">Diproses</a>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-dark-300">
            <thead class="text-xs text-dark-400 uppercase bg-dark-900 border-b border-dark-700">
                <tr>
                    <th class="px-6 py-4 font-medium">Order ID / Tanggal</th>
                    <th class="px-6 py-4 font-medium">Pelanggan</th>
                    <th class="px-6 py-4 font-medium">Total</th>
                    <th class="px-6 py-4 font-medium">Pembayaran</th>
                    <th class="px-6 py-4 font-medium">Status Pengiriman</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b border-dark-700 hover:bg-dark-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-mono font-bold text-white mb-1">{{ $order->order_number }}</p>
                            <p class="text-xs text-dark-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-white">{{ $order->shipping_name }}</p>
                            <p class="text-xs text-dark-400">{{ $order->user->email }}</p>
                        </td>
                        <td class="px-6 py-4 font-bold text-primary-400">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs uppercase mb-1 font-medium">{{ $order->payment_method }}</p>
                            @if($order->payment_status === 'paid')
                                <span class="badge-green text-[10px]">Lunas</span>
                            @else
                                <span class="badge-red text-[10px]">Belum Dibayar</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php $badge = $order->status_badge; @endphp
                            <span class="badge-{{ $badge['color'] }}">{{ $badge['text'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-primary py-1.5 px-4 text-xs">Detail & Proses</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-dark-500">Tidak ada pesanan ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
        <div class="p-4 border-t border-dark-700">
            {{ $orders->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
@endsection
