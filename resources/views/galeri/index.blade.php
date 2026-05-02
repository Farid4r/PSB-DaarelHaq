<x-public-layout>
    <x-slot name="title">Berita & Kegiatan - Daar el-Haq</x-slot>

    <main class="flex-grow pt-12 pb-24">
        <div class="max-w-[1280px] mx-auto px-6 md:px-8">

    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Manrope:wght@600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .shadow-level-1 { box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.05); }
        .gallery-item { transition: all 0.4s ease-in-out; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-body-md antialiased min-h-screen flex flex-col">
    <div class="max-w-[1280px] mx-auto px-6 md:px-8">
        
        {{-- Judul Halaman --}}
        <div class="text-center mb-10 space-y-4">
            <h1 class="text-4xl md:text-5xl font-extrabold font-['Manrope'] text-[#073216]">Galeri Pondok</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Dokumentasi fasilitas dan berbagai kegiatan santri di Pondok Pesantren Daar el-Haq.
            </p>
        </div>

        {{-- Tombol Filter --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <button class="filter-btn active bg-[#073216] text-white px-6 py-2 rounded-full font-bold text-sm shadow-md transition-colors" data-filter="all">
                Semua Foto
            </button>
            <button class="filter-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-6 py-2 rounded-full font-bold text-sm shadow-sm transition-colors" data-filter="Fasilitas">
                Fasilitas
            </button>
            <button class="filter-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-6 py-2 rounded-full font-bold text-sm shadow-sm transition-colors" data-filter="Kegiatan">
                Kegiatan
            </button>
        </div>

        {{-- Grid Foto Galeri --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="gallery-grid">
            @forelse($galleries as $gallery)
                {{-- Data atribut 'data-category' digunakan oleh JavaScript untuk memfilter foto --}}
                <div class="gallery-item relative rounded-xl overflow-hidden shadow-level-1 cursor-pointer group aspect-square bg-gray-200" data-category="{{ $gallery->category }}">
                    
                    {{-- Gambar --}}
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                    
                    {{-- Overlay Teks (Muncul saat di-hover) --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-[#073216]/90 via-[#073216]/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                        <span class="inline-block bg-yellow-500 text-[#073216] text-xs font-black uppercase tracking-wider px-2 py-1 rounded w-max mb-2">
                            {{ $gallery->category }}
                        </span>
                        <h3 class="text-white font-bold font-['Manrope'] text-lg leading-tight drop-shadow-md">
                            {{ $gallery->title }}
                        </h3>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-xl shadow-level-1 border border-gray-100">
                    <span class="material-symbols-outlined text-[80px] text-gray-300 mb-4">photo_library</span>
                    <h3 class="text-2xl font-bold text-gray-700 font-['Manrope']">Galeri Kosong</h3>
                    <p class="text-gray-500 mt-2">Saat ini belum ada foto yang diunggah ke dalam galeri.</p>
                </div>
            @endforelse
        </div>


{{-- SCRIPT UNTUK FITUR FILTER FOTO --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // 1. Ubah desain tombol agar yang diklik terlihat aktif
                filterButtons.forEach(btn => {
                    btn.classList.remove('bg-[#073216]', 'text-white');
                    btn.classList.add('bg-white', 'text-gray-600');
                });
                button.classList.add('bg-[#073216]', 'text-white');
                button.classList.remove('bg-white', 'text-gray-600');

                // 2. Ambil nilai kategori yang mau dicari (all, Fasilitas, Kegiatan)
                const filterValue = button.getAttribute('data-filter');

                // 3. Sembunyikan atau tampilkan foto sesuai kategori
                galleryItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    if (filterValue === 'all' || itemCategory === filterValue) {
                        item.style.display = 'block';
                        // Tambahkan sedikit animasi agar tidak kaku saat muncul
                        setTimeout(() => { item.style.opacity = '1'; item.style.transform = 'scale(1)'; }, 50);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.9)';
                        setTimeout(() => { item.style.display = 'none'; }, 300); // Tunggu animasi selesai baru disembunyikan
                    }
                });
            });
        });
    });
</script>
</main>
</x-public-layout>