<x-public-layout>
    <x-slot name="title">Berita & Kegiatan - Daar el-Haq</x-slot>

    <main class="flex-grow pt-12 pb-24">
        <div class="max-w-4xl mx-auto px-6 md:px-8">
        <!-- Daftar Berita -->       
        {{-- Tombol Kembali --}}
        <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#073216] font-semibold mb-8 transition-colors">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Daftar Berita
        </a>

        <article class="bg-white rounded-2xl shadow-level-1 border border-gray-100 overflow-hidden">
            
            {{-- Gambar Header Artikel --}}
            @if($post->thumbnail)
                <div class="w-full h-70 md:h-96 overflow-hidden bg-gray-100">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-8 md:p-12">
                {{-- Meta Data (Tanggal & Waktu) --}}
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 font-semibold uppercase tracking-wider">
                    <span class="material-symbols-outlined text-base text-yellow-600">calendar_today</span>
                    {{ $post->created_at->format('d M Y') }}
                </div>

                {{-- Judul Artikel --}}
                <h1 class="text-3xl md:text-4xl font-extrabold font-['Manrope'] text-[#073216] mb-8 leading-tight">
                    {{ $post->title }}
                </h1>

                {{-- Isi Artikel --}}
                <div class="prose max-w-none text-gray-700">
                    {!! $post->content !!}
                </div>
            </div>
            
        </article>

    </div>
</main>
</x-public-layout>