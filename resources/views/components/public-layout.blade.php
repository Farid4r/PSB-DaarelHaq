<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $title ?? 'Daar el-Haq Islamic Boarding School' }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Manrope:wght@600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .shadow-level-1 { box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.05); }
        .shadow-level-2 { box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.08); }
        
        /* CSS khusus untuk CKEditor (Berita & Profil) */
        .prose ul { list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1rem; }
        .prose ol { list-style-type: decimal; margin-left: 1.5rem; margin-bottom: 1rem; }
        .prose p { margin-bottom: 1rem; line-height: 1.8; }
        .prose strong { font-weight: 700; color: inherit; }
        .prose a { color: #059669; text-decoration: underline; }
        .prose blockquote { border-left: 4px solid #10b981; padding-left: 1rem; font-style: italic; color: #4b5563; }
        .gallery-item { transition: all 0.4s ease-in-out; }
    </style>
</head>
<body class="bg-background text-on-background font-body-md antialiased min-h-screen flex flex-col">

{{-- HEADER / NAVBAR --}}
<header 
    x-data="{ open: false }" 
    class="bg-[#073216] dark:bg-emerald-950 font-['Manrope'] text-sm font-medium tracking-tight docked full-width top-0 z-50 border-b border-emerald-800/30 shadow-lg relative"
>
    <div class="flex justify-between items-center w-full px-8 py-4 max-w-7xl mx-auto">
        
        <a href="{{ route('welcome') }}" class="flex items-center gap-3">
            <img src="{{ asset('assets/images/logo-ponpes.png') }}" alt="Logo Daar el-Haq" class="h-10 w-auto object-contain">
            <div class="text-2xl font-bold text-yellow-500 dark:text-yellow-400 tracking-tighter">
                Daar el-Haq
            </div>
        </a>

        {{-- 🌟 NAVIGASI DESKTOP --}}
        <nav class="hidden md:flex gap-8">
            <a class="{{ request()->routeIs('welcome') ? 'text-yellow-500 font-bold border-b-2 border-yellow-500 pb-1' : 'text-emerald-50/80 hover:text-white hover:opacity-90 transition-all scale-95' }}" href="{{ route('welcome') }}">
                Beranda
            </a>
            <a class="{{ request()->routeIs('berita.*') ? 'text-yellow-500 font-bold border-b-2 border-yellow-500 pb-1' : 'text-emerald-50/80 hover:text-white hover:opacity-90 transition-all scale-95' }}" href="{{ route('berita.index') }}">
                Berita
            </a>
            <a class="{{ request()->routeIs('galeri.*') ? 'text-yellow-500 font-bold border-b-2 border-yellow-500 pb-1' : 'text-emerald-50/80 hover:text-white hover:opacity-90 transition-all scale-95' }}" href="{{ route('galeri.index') }}">
                Galeri
            </a>
        </nav>
        
        {{-- TOMBOL AUTH DESKTOP --}}
        <div class="hidden md:flex gap-4">
            @if (Route::has('login'))
                @auth
                    @if(Auth::user()->role === 'santri')
                        <a href="{{ url('/dashboard') }}" class="bg-tertiary-fixed-dim text-white font-label-sm text-label-sm px-6 py-3 rounded-lg hover:bg-tertiary-fixed transition-colors shadow-level-1">Dashboard Santri</a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="bg-tertiary-fixed-dim text-white font-label-sm text-label-sm px-6 py-3 rounded-lg hover:bg-tertiary-fixed transition-colors shadow-level-1">Panel Admin</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-emerald-50/80 hover:text-white px-6 py-3 transition-colors">Masuk</a>
                    
                    @php
                        $isOpen = \App\Models\Setting::where('key', 'is_registration_open')->value('value') == '1';
                    @endphp

                    @if (Route::has('register') && $isOpen)
                        <a href="{{ route('register') }}" class="bg-tertiary-fixed-dim text-white font-label-sm text-label-sm px-6 py-3 rounded-lg hover:bg-tertiary-fixed transition-colors shadow-level-1">Daftar Sekarang</a>
                    @endif
                @endauth
            @endif
        </div>
        
        {{-- 📱 TOMBOL HAMBURGER MOBILE --}}
        <button @click="open = !open" class="md:hidden text-emerald-50 focus:outline-none">
            <span x-show="!open" class="material-symbols-outlined text-3xl">menu</span>
            <span x-show="open" class="material-symbols-outlined text-3xl" x-cloak>close</span>
        </button>
    </div>

    {{-- 📱 MENU DROPDOWN MOBILE --}}
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden bg-[#052611] border-b border-emerald-800/30 px-8 py-6 space-y-4 shadow-xl"
        @click.away="open = false"
        x-cloak
    >
        <nav class="flex flex-col gap-4">
            <a href="{{ route('welcome') }}" class="py-2 {{ request()->routeIs('welcome') ? 'text-yellow-500 font-bold' : 'text-emerald-50/80' }}">Beranda</a>
            <a href="{{ route('berita.index') }}" class="py-2 {{ request()->routeIs('berita.*') ? 'text-yellow-500 font-bold' : 'text-emerald-50/80' }}">Berita</a>
            <a href="{{ route('galeri.index') }}" class="py-2 {{ request()->routeIs('galeri.*') ? 'text-yellow-500 font-bold' : 'text-emerald-50/80' }}">Galeri</a>
        </nav>

        <hr class="border-emerald-800/50">

        <div class="flex flex-col gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-yellow-500 font-bold">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-emerald-50/80 py-2">Masuk</a>
                @if (isset($isOpen) && $isOpen)
                    <a href="{{ route('register') }}" class="bg-tertiary-fixed-dim text-white text-center py-3 rounded-lg shadow-lg">Daftar Sekarang</a>
                @endif
            @endauth
        </div>
    </div>
</header>

{{-- SLOT KONTEN UTAMA --}}
{{ $slot }}

{{-- FOOTER --}}
<footer class="bg-[#073216] dark:bg-emerald-950 font-['Manrope'] text-xs uppercase tracking-widest w-full py-8 px-6 border-t border-emerald-800/50 mt-auto">
    <!-- Menggunakan items-center agar vertikalnya sejajar -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 md:gap-8 max-w-7xl mx-auto items-center">
        
        <!-- KOLOM 1: Nama Brand, Deskripsi, & Sosmed (Tengah di HP, Kiri di Desktop) -->
        <div class="md:col-span-1 flex flex-col gap-4 text-center md:text-left items-center md:items-start">
            <div class="flex items-center gap-3">
        <!-- Logo Pondok dari folder assets -->
        <img src="{{ asset('assets/images/logo-ponpes.png') }}" 
             alt="Logo Daar el-Haq" 
             class="h-10 w-auto object-contain">
        
        <!-- Nama Pesantren -->
        <span class="text-xl font-black text-yellow-500 tracking-tighter">Daar el-Haq</span>
    </div>
      <!-- Menggunakan font-sans (Inter) agar deskripsi lebih nyaman dibaca -->
            <p class="text-emerald-200/60 font-sans text-sm normal-case leading-relaxed">
                Mencetak generasi rabbani yang berakhlak mulia dan berwawasan global.
            </p>
            
            <!-- Daftar Ikon Sosial Media -->
            <div class="flex gap-5 mt-2">
                <!-- Instagram -->
                <a href="https://www.instagram.com/ponpes.modern.daarelhaq/" class="text-emerald-200/60 hover:text-yellow-500 transition-transform hover:scale-110" aria-label="Instagram">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                    </svg>
                </a>
                <!-- Facebook -->
                <a href="https://www.facebook.com/ponpes.Daarelhaq" class="text-emerald-200/60 hover:text-yellow-500 transition-transform hover:scale-110" aria-label="Facebook">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                </a>
                <!-- YouTube -->
                <a href="https://www.youtube.com/@daarelhaqmedia2015/videos" class="text-emerald-200/60 hover:text-yellow-500 transition-transform hover:scale-110" aria-label="YouTube">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418zM10 15l5-3-5-3v6z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- KOLOM 2: Navigasi Tautan (Tengah di Desktop dan HP) -->
        <div class="md:col-span-2 flex flex-col justify-center items-center gap-4">
            <!-- flex-col di HP (turun ke bawah), flex-row di layar lebih besar sm: -->
            <nav class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-8">
                <a class="text-emerald-200/60 hover:text-yellow-500 transition-colors" href="#">Kebijakan Privasi</a>
                <a class="text-emerald-200/60 hover:text-yellow-500 transition-colors" href="#">Syarat Ketentuan</a>
                <a class="text-emerald-200/60 hover:text-yellow-500 transition-colors" href="#">Kontak Kami</a>
            </nav>
        </div>

        <!-- KOLOM 3: Copyright (Tengah di HP, Kanan di Desktop) -->
        <div class="md:col-span-1 flex items-center justify-center md:justify-end">
            <!-- normal-case agar tulisan tidak huruf besar semua, dan text-center di HP -->
            <p class="text-emerald-50 opacity-80 text-center md:text-right normal-case font-sans text-sm leading-relaxed">
                © {{ date('Y') }} Daar el-Haq.<br>Sistem Penerimaan Santri Baru.
            </p>
        </div>
        
    </div>
</footer>

</body>
</html>