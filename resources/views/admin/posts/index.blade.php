@extends('layouts.app')

@section('title', 'Manajemen Berita - Admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-emerald-900">Daftar Berita & Kegiatan</h2>
                <a href="{{ route('admin.posts.create') }}" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    + Tulis Berita
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-emerald-50 text-emerald-900 border-b border-emerald-200">
                            <th class="p-4 font-semibold">Thumbnail</th>
                            <th class="p-4 font-semibold">Judul Berita</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold">Tanggal Dibuat</th>
                            <th class="p-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-4">
                                    @if($post->thumbnail)
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail" class="w-20 h-14 object-cover rounded shadow-sm">
                                    @else
                                        <div class="w-20 h-14 bg-gray-200 rounded flex items-center justify-center text-gray-500 text-xs">No Image</div>
                                    @endif
                                </td>
                                <td class="p-4 font-medium text-gray-800">{{ $post->title }}</td>
                                <td class="p-4">
                                    @if($post->status === 'publish')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase">Publish</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full uppercase">Draft</span>
                                    @endif
                                </td>
                                <td class="p-4 text-gray-600 text-sm">{{ $post->created_at->format('d M Y') }}</td>
                                <td class="p-4 text-center space-x-2">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                    
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">Belum ada berita yang ditulis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection