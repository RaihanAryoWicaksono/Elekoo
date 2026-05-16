@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-dark-400 hover:text-white">&larr; Kembali ke Daftar Kategori</a>
    </div>

    <div class="card p-6 md:p-8">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="label">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="input-field" required>
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label">Deskripsi</label>
                    <textarea name="description" rows="3" class="input-field">{{ old('description', $category->description) }}</textarea>
                    @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label">Gambar Kategori</label>
                    @if($category->image)
                        <div class="mb-3 w-20 h-20 rounded bg-dark-800 overflow-hidden border border-dark-600">
                            <img src="{{ \Illuminate\Support\Str::startsWith($category->image, ['http://', 'https://']) ? $category->image : Storage::url($category->image) }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <input type="file" name="image" class="w-full text-sm text-dark-300 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-dark-700 file:text-white hover:file:bg-dark-600 transition-all cursor-pointer" accept="image/*">
                    <p class="text-xs text-dark-500 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                    @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" id="is_active" class="w-5 h-5 rounded bg-dark-700 border-dark-600 text-primary-500 focus:ring-primary-500 focus:ring-offset-dark-800" {{ $category->is_active ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm font-medium text-white cursor-pointer">Kategori Aktif</label>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-dark-700 flex justify-end">
                <button type="submit" class="btn-primary">Perbarui Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection
