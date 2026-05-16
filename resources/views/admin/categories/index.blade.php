@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="card mb-6 p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-lg font-bold text-white">Daftar Kategori</h2>
        <p class="text-sm text-dark-400">Kelola semua kategori produk di toko Anda.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary text-sm whitespace-nowrap">
        + Tambah Kategori
    </a>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-dark-300">
            <thead class="text-xs text-dark-400 uppercase bg-dark-900 border-b border-dark-700">
                <tr>
                    <th class="px-6 py-4 font-medium">Gambar</th>
                    <th class="px-6 py-4 font-medium">Kategori</th>
                    <th class="px-6 py-4 font-medium">Total Produk</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-b border-dark-700 hover:bg-dark-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="w-12 h-12 rounded bg-dark-800 flex items-center justify-center overflow-hidden">
                                @if($category->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($category->image, ['http://', 'https://']) ? $category->image : Storage::url($category->image) }}" class="object-cover w-full h-full">
                                @else
                                    <svg class="w-6 h-6 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-white">{{ $category->name }}</p>
                            <p class="text-xs text-dark-500">{{ $category->slug }}</p>
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $category->products_count }} Produk</td>
                        <td class="px-6 py-4">
                            @if($category->is_active)
                                <span class="badge-green">Aktif</span>
                            @else
                                <span class="badge-red">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-400 hover:text-blue-300 font-medium">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Semua produk di dalamnya juga akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 font-medium">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-dark-500">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
        <div class="p-4 border-t border-dark-700">
            {{ $categories->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
@endsection
