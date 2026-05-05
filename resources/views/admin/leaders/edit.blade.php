<x-admin-layout>
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('admin.leaders.index') }}" class="text-gray-500 hover:text-gray-700">
                    &larr; Kembali
                </a>
                <h2 class="text-2xl font-bold text-emerald-900">Edit Data Pimpinan</h2>
            </div>

            <form action="{{ route('admin.leaders.update', $leader->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ $leader->name }}" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>

                <div class="mb-4">
                    <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">Jabatan</label>
                    <input type="text" name="position" id="position" value="{{ $leader->position }}" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Saat Ini</label>
                    @if($leader->photo)
                        <img src="{{ asset('storage/' . $leader->photo) }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200 mb-2">
                    @else
                        <p class="text-sm text-gray-500 italic mb-2">Belum ada foto.</p>
                    @endif
                    
                    <label for="photo" class="block text-sm font-semibold text-gray-700 mb-2 mt-4">Ganti Foto (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" name="photo" id="photo" accept="image/png, image/jpeg, image/jpg" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">{{ $leader->description }}</textarea>
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
</x-admin-layout>