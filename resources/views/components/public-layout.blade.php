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
<header class="bg-[#073216] dark:bg-emerald-950 font-['Manrope'] text-sm font-medium tracking-tight docked full-width top-0 z-50 border-b border-emerald-800/30 shadow-lg">
    <div class="flex justify-between items-center w-full px-8 py-4 max-w-7xl mx-auto">
        
        <a href="{{ route('welcome') }}" class="flex items-center gap-3">
            <img src="{{ asset('assets/images/logo-ponpes.png') }}" alt="Logo Daar el-Haq" class="h-10 w-auto object-contain">
            <div class="text-2xl font-bold text-yellow-500 dark:text-yellow-400 tracking-tighter">
                Daar el-Haq
            </div>
        </a>

        {{-- 🌟 NAVIGASI DINAMIS --}}
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
        
        <button class="md:hidden text-emerald-50">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </div>
</header>

{{-- SLOT KONTEN UTAMA --}}
{{ $slot }}

{{-- FOOTER --}}
<footer class="bg-[#073216] dark:bg-emerald-950 font-['Manrope'] text-xs uppercase tracking-widest full-width py-12 px-8 border-t border-emerald-800/50 shadow-none mt-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-7xl mx-auto">
        <div class="md:col-span-1 flex flex-col gap-4">
            <span class="text-lg font-black text-yellow-500">Daar el-Haq</span>
            <p class="text-emerald-200/60 font-caption text-caption normal-case">
                Mencetak generasi rabbani yang berakhlak mulia dan berwawasan global.
            </p>
        </div>
        <div class="md:col-span-2 flex flex-col justify-center items-center gap-4">
            <nav class="flex flex-wrap justify-center gap-6">
                <a class="text-emerald-200/60 hover:text-yellow-500 transition-colors" href="#">Kebijakan Privasi</a>
                <a class="text-emerald-200/60 hover:text-yellow-500 transition-colors" href="#">Syarat Ketentuan</a>
                <a class="text-emerald-200/60 hover:text-yellow-500 transition-colors" href="#">Kontak Kami</a>
            </nav>
        </div>
        <div class="md:col-span-1 flex items-center justify-end">
            <p class="text-emerald-50 opacity-80 text-right">
                © {{ date('Y') }} Daar el-Haq.<br>Sistem Penerimaan Santri Baru.
            </p>
        </div>
    </div>
</footer>

</body>
</html>