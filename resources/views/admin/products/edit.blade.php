@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-sm text-dark-400 hover:text-white">&larr; Kembali ke Daftar Produk</a>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Info --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Informasi Dasar</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="label">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="input-field" required>
                            @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label">Kategori <span class="text-red-500">*</span></label>
                                <select name="category_id" class="input-field py-3 appearance-none" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="label">Brand</label>
                                <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="input-field">
                            </div>
                        </div>

                        <div>
                            <label class="label">Deskripsi Produk</label>
                            <textarea name="description" rows="5" class="input-field">{{ old('description', $product->description) }}</textarea>
                        </div>
                        
                        <div>
                            <label class="label">Spesifikasi</label>
                            <textarea name="specifications" rows="4" class="input-field">{{ old('specifications', $product->specifications) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-6">
                <div class="card p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Harga & Stok</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="label">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" value="{{ old('price', (int)$product->price) }}" class="input-field" required min="0">
                        </div>
                        <div>
                            <label class="label">Harga Coret (Opsional)</label>
                            <input type="number" name="original_price" value="{{ old('original_price', (int)$product->original_price) }}" class="input-field" min="0">
                        </div>
                        <div>
                            <label class="label">Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="input-field" required min="0">
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Media & Status</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="label">Foto Utama</label>
                            @if($product->image)
                                <div class="mb-3 w-full aspect-video rounded-xl bg-dark-800 overflow-hidden border border-dark-600">
                                    <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : Storage::url($product->image) }}" class="w-full h-full object-contain">
                                </div>
                            @endif
                            <input type="file" name="image" class="w-full text-sm text-dark-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-dark-700 file:text-white hover:file:bg-dark-600 transition-all cursor-pointer" accept="image/*">
                            <p class="text-xs text-dark-500 mt-2">Biarkan kosong jika tidak mengubah gambar.</p>
                        </div>

                        <hr class="border-dark-700 my-4">

                        <div class="flex items-center justify-between">
                            <label for="is_active" class="text-sm font-medium text-white cursor-pointer">Produk Aktif</label>
                            <input type="checkbox" name="is_active" value="1" id="is_active" class="w-5 h-5 rounded bg-dark-700 border-dark-600 text-primary-500 focus:ring-primary-500" {{ $product->is_active ? 'checked' : '' }}>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <label for="is_featured" class="text-sm font-medium text-white cursor-pointer">Featured (Unggulan)</label>
                            <input type="checkbox" name="is_featured" value="1" id="is_featured" class="w-5 h-5 rounded bg-dark-700 border-dark-600 text-primary-500 focus:ring-primary-500" {{ $product->is_featured ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full py-4 text-lg shadow-lg shadow-primary-500/25">Perbarui Produk</button>
            </div>
        </div>
    </form>
</div>
@endsection
