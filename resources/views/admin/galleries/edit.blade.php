@extends('layouts.app')

@section('title', 'Edit Foto Galeri - Admin')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('admin.galleries.index') }}" class="text-gray-500 hover:text-gray-700">
                    &larr; Kembali
                </a>
                <h2 class="text-2xl font-bold text-emerald-900">Edit Data Galeri</h2>
            </div>

            <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Keterangan Foto</label>
                    <input type="text" name="title" id="title" value="{{ $gallery->title }}" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>

                <div class="mb-4">
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category" id="category" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                        <option value="Fasilitas" {{ $gallery->category == 'Fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                        <option value="Kegiatan" {{ $gallery->category == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Saat Ini</label>
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" class="w-48 h-auto object-cover rounded-lg border border-gray-200 mb-4">
                    
                    <label for="image_path" class="block text-sm font-semibold text-gray-700 mb-2">Ganti Foto (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" name="image_path" id="image_path" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection