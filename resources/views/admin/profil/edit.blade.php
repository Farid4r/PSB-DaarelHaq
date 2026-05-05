<x-admin-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-on-surface/40 hover:text-primary mb-6 inline-flex items-center gap-2"> &larr; Kembali ke Dashboard</a>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-emerald-800/20">
            <h2 class="text-2xl font-bold text-[#073216] mb-6 font-['Manrope']">Manajemen Profil Pondok</h2>

            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.profil.update') }}" method="POST">
                @csrf
                
                {{-- Tentang Kami --}}
                <div class="mb-6">
                    <label for="tentang_kami" class="block text-sm font-semibold text-gray-700 mb-2">Tentang Kami</label>
                    <textarea name="tentang_kami" id="editor_tentang" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ $tentangKami }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Visi --}}
                    <div>
                        <label for="visi" class="block text-sm font-semibold text-gray-700 mb-2">Visi</label>
                        <textarea name="visi" id="editor_visi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ $visi }}</textarea>
                    </div>

                    {{-- Misi --}}
                    <div>
                        <label for="misi" class="block text-sm font-semibold text-gray-700 mb-2">Misi</label>
                        <textarea name="misi" id="editor_misi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ $misi }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-[#073216] hover:bg-emerald-800 text-white font-bold py-2 px-6 rounded-lg transition duration-200 shadow-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-admin-layout>
{{-- Script CKEditor 5 untuk mempercantik textarea --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    const editors = ['#editor_tentang', '#editor_visi', '#editor_misi'];
    editors.forEach(id => {
        ClassicEditor
            .create(document.querySelector(id), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
            })
            .catch(error => { console.error(error); });
    });
</script>

<style>
    .ck-editor__editable { min-height: 200px; }
</style>
