<x-admin-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-on-surface/40 hover:text-primary mb-6 inline-flex items-center gap-2"> &larr; Kembali ke Dashboard</a>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2  class="text-2xl font-bold text-emerald-900">Daftar Galleri</h2>
                <a href="{{ route('admin.galleries.create') }}" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    + Tambah Foto
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
                            <th class="p-4 font-semibold">Foto</th>
                            <th class="p-4 font-semibold">Keterangan (Judul)</th>
                            <th class="p-4 font-semibold">Kategori</th>
                            <th class="p-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galleries as $gallery)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-4">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-32 h-20 object-cover rounded shadow-sm border border-gray-200">
                                </td>
                                <td class="p-4 font-medium text-gray-800">{{ $gallery->title }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full uppercase border border-gray-200">
                                        {{ $gallery->category }}
                                    </span>
                                </td>
                                <td class="p-4 text-center space-x-2">
                                    <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                    
                                    <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus foto ini dari galeri?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">Belum ada foto di galeri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-admin-layout>