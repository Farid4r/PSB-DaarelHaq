<x-public-layout>
    <x-slot name="title">Berita & Kegiatan - Daar el-Haq</x-slot>

    <main class="flex-grow pt-12 pb-24">
        <div class="max-w-7xl mx-auto px-6 md:px-8">
        {{-- Judul Halaman --}}
        <div class="text-center mt-16 mb-16 space-y-4">
            <h1 class="text-4xl md:text-5xl font-extrabold font-['Manrope'] text-[#073216]">BERITA & KEGIATAN</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Ikuti terus informasi, artikel, dan kegiatan terbaru dari Pondok Pesantren Daar el-Haq.
            </p>
        </div>

        {{-- Grid Berita --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <div class="bg-white rounded-xl shadow-level-1 border border-gray-100 overflow-hidden group hover:shadow-level-2 transition-all duration-300 flex flex-col">
                    {{-- Thumbnail --}}
                    <div class="relative h-56 overflow-hidden bg-gray-200">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span class="material-symbols-outlined text-[64px]">newspaper</span>
                            </div>
                        @endif
                        {{-- Badge Tanggal --}}
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-bold text-[#073216] shadow">
                            {{ $post->created_at->format('d M Y') }}
                        </div>
                    </div>

                    {{-- Isi Kartu --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold font-['Manrope'] text-gray-900 mb-3 line-clamp-2 hover:text-[#073216] transition-colors">
                            <a href="{{ route('berita.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        
                        {{-- Cuplikan Isi --}}
                        <p class="text-gray-600 mb-6 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                        </p>

                        {{-- Tombol Baca --}}
                        <div class="mt-auto">
                            <a href="{{ route('berita.show', $post->slug) }}" class="inline-flex items-center gap-2 text-[#073216] font-bold hover:text-yellow-600 transition-colors">
                                Baca Selengkapnya <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-xl shadow-level-1 border border-gray-100">
                    <span class="material-symbols-outlined text-[80px] text-gray-300 mb-4">article</span>
                    <h3 class="text-2xl font-bold text-gray-700 font-['Manrope']">Belum Ada Berita</h3>
                    <p class="text-gray-500 mt-2">Saat ini belum ada berita atau kegiatan yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        {{-- Navigasi Halaman (Pagination) --}}
        <div class="mt-16 flex justify-center">
            {{ $posts->links() }}
        </div>

    </div>
</main>

</x-public-layout>
