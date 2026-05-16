<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? 'Elekoo - Your Future Tech, Today. Toko elektronik terpercaya dengan produk berkualitas.' }}">
    <title>@yield('title', 'Elekoo') | Elekoo Electronics</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-glass sticky top-0 z-50 border-b border-dark-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group" id="nav-logo">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-black gradient-text">Elekoo</span>
                </a>

                {{-- Search --}}
                <form action="{{ route('shop.index') }}" method="GET" class="hidden md:flex flex-1 max-w-md mx-8">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk, merek..."
                            class="w-full bg-dark-700 border border-dark-600 text-dark-100 rounded-xl pl-4 pr-12 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all placeholder-dark-500" id="nav-search">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-dark-400 hover:text-primary-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>

                {{-- Nav Items --}}
                <div class="flex items-center gap-2">
                    <a href="{{ route('shop.index') }}" class="nav-link hidden md:block px-3 py-2" id="nav-shop">Toko</a>

                    @auth
                        {{-- Wishlist --}}
                        <a href="{{ route('wishlist.index') }}" class="relative p-2 text-dark-400 hover:text-primary-400 transition-colors" id="nav-wishlist">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </a>

                        {{-- Cart --}}
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-dark-400 hover:text-primary-400 transition-colors" id="nav-cart">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            @php
                                $cartCount = auth()->user()->cart?->items->sum('quantity') ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-primary-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                            @endif
                        </a>

                        {{-- User Dropdown --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 p-2 text-dark-300 hover:text-white transition-colors rounded-xl hover:bg-dark-700" id="nav-user">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-52 card shadow-xl z-50 py-1">
                                <div class="px-4 py-3 border-b border-dark-700">
                                    <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-dark-400 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-accent-400 hover:bg-dark-700 transition-colors" id="nav-admin">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                        Admin Panel
                                    </a>
                                @endif
                                <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-dark-300 hover:text-white hover:bg-dark-700 transition-colors" id="nav-orders-link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Pesanan Saya
                                </a>
                                <div class="border-t border-dark-700 mt-1 pt-1">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-400 hover:bg-dark-700 transition-colors text-left" id="nav-logout">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary text-sm px-4 py-2" id="nav-login">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm px-4 py-2" id="nav-register">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="fixed top-20 right-4 z-50 animate-slide-up" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)">
            <div class="flex items-center gap-3 bg-green-500/20 border border-green-500/40 text-green-300 px-4 py-3 rounded-xl shadow-xl backdrop-blur-xl max-w-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="fixed top-20 right-4 z-50 animate-slide-up" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)">
            <div class="flex items-center gap-3 bg-red-500/20 border border-red-500/40 text-red-300 px-4 py-3 rounded-xl shadow-xl backdrop-blur-xl max-w-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark-950 border-t border-dark-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-black gradient-text">Elekoo</span>
                    </div>
                    <p class="text-dark-400 text-sm leading-relaxed max-w-xs">
                        Toko elektronik terpercaya dengan produk berkualitas tinggi. <br>
                        <span class="text-primary-400 font-medium">Your Future Tech, Today.</span>
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Navigasi</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-400 text-sm transition-colors">Beranda</a></li>
                        <li><a href="{{ route('shop.index') }}" class="text-dark-400 hover:text-primary-400 text-sm transition-colors">Toko</a></li>
                        @auth
                            <li><a href="{{ route('orders.index') }}" class="text-dark-400 hover:text-primary-400 text-sm transition-colors">Pesanan</a></li>
                            <li><a href="{{ route('wishlist.index') }}" class="text-dark-400 hover:text-primary-400 text-sm transition-colors">Wishlist</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-dark-400">
                        <li>📧 support@elekoo.id</li>
                        <li>📞 +62 812-3456-7890</li>
                        <li>📍 Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-dark-800 mt-8 pt-8 text-center text-dark-500 text-sm">
                © {{ date('Y') }} Elekoo Electronics. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
