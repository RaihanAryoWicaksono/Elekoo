@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-dark-400 hover:text-white">&larr; Kembali ke Daftar Pesanan</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Order Detail --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="card p-6">
            <div class="flex items-start justify-between mb-6 pb-6 border-b border-dark-700">
                <div>
                    <h2 class="text-xl font-bold text-white font-mono">{{ $order->order_number }}</h2>
                    <p class="text-sm text-dark-400">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div class="text-right">
                    @php $badge = $order->status_badge; @endphp
                    <span class="badge-{{ $badge['color'] }} text-sm px-3 py-1">{{ $badge['text'] }}</span>
                </div>
            </div>

            <h3 class="font-bold text-white mb-4">Item Pesanan</h3>
            <div class="space-y-4 mb-6">
                @foreach($order->items as $item)
                    <div class="flex gap-4">
                        <div class="w-16 h-16 rounded bg-dark-700 flex-shrink-0 flex items-center justify-center overflow-hidden border border-dark-600">
                            @if($item->product && $item->product->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($item->product->image, ['http://', 'https://']) ? $item->product->image : Storage::url($item->product->image) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 flex justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-white mb-1">{{ $item->product_name }}</h4>
                                <p class="text-xs text-dark-400">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="font-bold text-white">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-dark-700 pt-4 space-y-2 text-sm">
                <div class="flex justify-between text-dark-300">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-dark-300">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-white font-bold pt-2 border-t border-dark-700 mt-2">
                    <span class="text-base">Total Akhir</span>
                    <span class="text-xl text-primary-400">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="font-bold text-white mb-4">Informasi Pengiriman</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-dark-400 mb-1">Nama Penerima</p>
                    <p class="font-medium text-white">{{ $order->shipping_name }}</p>
                </div>
                <div>
                    <p class="text-dark-400 mb-1">No. Telepon</p>
                    <p class="font-medium text-white">{{ $order->shipping_phone }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-dark-400 mb-1">Alamat Lengkap</p>
                    <p class="font-medium text-white">{{ $order->shipping_address }}</p>
                    <p class="text-dark-300 mt-1">{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
                </div>
                @if($order->notes)
                    <div class="md:col-span-2 bg-dark-900/50 p-4 rounded-lg border border-dark-700">
                        <p class="text-dark-400 mb-1 text-xs uppercase font-bold">Catatan Pembeli:</p>
                        <p class="text-white">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Action & Update --}}
    <div class="lg:col-span-1 space-y-6">
        <div class="card p-6">
            <h3 class="font-bold text-white mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="space-y-4">
                    <div>
                        <label class="label">Status Pesanan</label>
                        <select name="status" class="input-field py-3 appearance-none">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Selesai / Terkirim</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="label">Status Pembayaran</label>
                        <select name="payment_status" class="input-field py-3 appearance-none">
                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Lunas</option>
                            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary w-full py-3 mt-2">Update Pesanan</button>
                </div>
            </form>
        </div>

        <div class="card p-6">
            <h3 class="font-bold text-white mb-4">Info Pelanggan</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-dark-400 mb-1">Nama Akun</p>
                    <p class="font-medium text-white">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-dark-400 mb-1">Email</p>
                    <p class="font-medium text-white">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-dark-400 mb-1">Terdaftar Sejak</p>
                    <p class="font-medium text-white">{{ $order->user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
