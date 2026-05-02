@extends('layouts.app')

@section('title', 'Tambah Pimpinan - Admin')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('admin.leaders.index') }}" class="text-gray-500 hover:text-gray-700">
                    &larr; Kembali
                </a>
                <h2 class="text-2xl font-bold text-emerald-900">Tambah Data Pimpinan</h2>
            </div>

            <form action="{{ route('admin.leaders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required placeholder="Contoh: K.H. Ahmad Dahlan">
                </div>

                <div class="mb-4">
                    <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">Jabatan</label>
                    <input type="text" name="position" id="position" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required placeholder="Contoh: Pimpinan Pondok">
                </div>

                <div class="mb-4">
                    <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2">Unggah Foto (Opsional)</label>
                    <input type="file" name="photo" id="photo" accept="image/png, image/jpeg, image/jpg" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal ukuran: 2MB.</p>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat (Opsional)</label>
                    <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Biografi atau profil singkat pimpinan..."></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection