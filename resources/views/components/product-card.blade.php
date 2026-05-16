<div class="product-card flex flex-col h-full group">
    <div class="relative aspect-square overflow-hidden bg-dark-700">
        @if($product->image)
            <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-12 h-12 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        @endif

        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex flex-col gap-2">
            @if($product->discount_percentage)
                <span class="badge bg-red-500 text-white shadow-lg">-{{ $product->discount_percentage }}%</span>
            @endif
            @if($product->is_featured)
                <span class="badge bg-accent-500 text-white shadow-lg">Featured</span>
            @endif
        </div>

        {{-- Wishlist Button overlay --}}
        <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                @csrf
                <button type="submit" class="p-2 rounded-full bg-dark-800/80 backdrop-blur text-dark-300 hover:text-red-500 hover:bg-dark-800 transition-all shadow-lg" title="Tambah ke Wishlist">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </button>
            </form>
        </div>
    </div>

    <div class="p-5 flex flex-col flex-1">
        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="text-xs font-semibold text-primary-400 mb-2 hover:underline tracking-wide uppercase">{{ $product->category->name }}</a>
        <a href="{{ route('shop.show', $product) }}" class="text-lg font-bold text-white mb-2 line-clamp-2 hover:text-primary-400 transition-colors">
            {{ $product->name }}
        </a>
        
        <div class="flex items-center gap-1 mb-4">
            <div class="flex text-yellow-400">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 {{ $i <= round($product->rating) ? 'fill-current' : 'text-dark-600' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
            </div>
            <span class="text-xs text-dark-400 ml-1">({{ $product->review_count }})</span>
        </div>

        <div class="mt-auto">
            <div class="flex items-end justify-between gap-2 mb-4">
                <div>
                    @if($product->original_price > $product->price)
                        <span class="text-sm text-dark-400 line-through block mb-0.5">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                    @endif
                    <span class="text-xl font-bold text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full btn-primary py-2 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Tambah ke Keranjang
                    </button>
                </form>
            @else
                <button disabled class="w-full btn-secondary py-2 text-sm opacity-50 cursor-not-allowed">Stok Habis</button>
            @endif
        </div>
    </div>
</div>
