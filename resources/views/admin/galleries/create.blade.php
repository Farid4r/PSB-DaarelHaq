@extends('layouts.app')

@section('title', 'Tambah Foto Galeri - Admin')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('admin.galleries.index') }}" class="text-gray-500 hover:text-gray-700">
                    &larr; Kembali
                </a>
                <h2 class="text-2xl font-bold text-emerald-900">Tambah Foto Galeri</h2>
            </div>

            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Keterangan Foto</label>
                    <input type="text" name="title" id="title" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required placeholder="Contoh: Gedung Asrama Putra">
                </div>

                <div class="mb-4">
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="category" id="category" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                        <option value="Fasilitas">Fasilitas</option>
                        <option value="Kegiatan">Kegiatan</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="image_path" class="block text-sm font-semibold text-gray-700 mb-2">Unggah Foto</label>
                    <input type="file" name="image_path" id="image_path" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" required>
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal ukuran: 2MB.</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Simpan Foto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection