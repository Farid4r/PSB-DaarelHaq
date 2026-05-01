<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Daar el-Haq Islamic Boarding School</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Manrope:wght@600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .shadow-level-1 { box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.05); }
        .shadow-level-2 { box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.08); }
    </style>
</head>
<body class="bg-background text-on-background font-body-md antialiased min-h-screen flex flex-col">

<header class="bg-[#073216] dark:bg-emerald-950 font-['Manrope'] text-sm font-medium tracking-tight docked full-width top-0 z-50 border-b border-emerald-800/30 shadow-lg">
    <div class="flex justify-between items-center w-full px-8 py-4 max-w-7xl mx-auto">
        
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/images/logo-ponpes.png') }}" alt="Logo Daar el-Haq" class="h-10 w-auto object-contain">
            <div class="text-2xl font-bold text-yellow-500 dark:text-yellow-400 tracking-tighter">
                Daar el-Haq
            </div>
        </div>

        <nav class="hidden md:flex gap-8">
            <a class="text-yellow-500 font-bold border-b-2 border-yellow-500 pb-1" href="#">Beranda</a>
            <a class="text-emerald-50/80 hover:text-white hover:opacity-90 transition-all scale-95" href="#">Program</a>
            <a class="text-emerald-50/80 hover:text-white hover:opacity-90 transition-all scale-95" href="#">Fasilitas</a>
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
                $isOpen = \App\Models\Setting::get('is_registration_open', '1') == '1';
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

<main class="flex-grow">
<section class="relative bg-primary-container text-on-primary min-h-screen flex items-center py-20 overflow-hidden">
    
    <div class="absolute inset-0 z-0 opacity-20 bg-cover bg-center" style="background-image: url('{{ asset('assets/images/kls6.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-primary-container to-transparent z-0"></div>
    
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-8 relative z-10 flex flex-col md:flex-row items-center gap-12">
        
        <div class="w-full md:w-3/5 space-y-6">
            @php
                $isOpen = \App\Models\Setting::get('is_registration_open', '1') == '1';
                $ta = \App\Models\Setting::get('academic_year', '2026/2027');
            @endphp

            <span class="inline-block py-1 px-3 rounded-full {{ $isOpen ? 'bg-green-500/20 text-inverse-primary border-green-500/30' : 'bg-red-500/20 text-red-200 border-red-500/30' }} font-label-sm text-label-sm border">
                Penerimaan Santri Baru TA {{ $ta }} : {{ $isOpen ? 'DIBUKA' : 'DITUTUP' }}
            </span>

            <h1 class="font-h1 text-h1 text-on-primary leading-tight">
                Daar El-Haq<br/>
                <span class="text-tertiary-fixed-dim">Islamic Boarding School</span>
            </h1>
            <p class="font-body-lg text-body-lg text-inverse-primary max-w-2xl">
                Pendidikan yang mengakar pada tradisi, disampaikan dengan presisi modern. Membentuk generasi unggul yang menguasai ilmu agama dan sains teknologi.
            </p>

            <div class="pt-4 flex flex-wrap gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-tertiary-fixed-dim text-white font-label-sm text-label-sm px-8 py-4 rounded-lg hover:bg-tertiary-fixed transition-colors shadow-level-2">
                        Lanjutkan ke Dashboard
                    </a>
                @else
                    @if($isOpen)
                        <a href="{{ route('register') }}" class="bg-tertiary-fixed-dim text-white font-label-sm text-label-sm px-8 py-4 rounded-lg hover:bg-tertiary-fixed transition-colors shadow-level-2">
                            Daftar Sekarang
                        </a>
                    @else
                        <div class="bg-red-600 text-white px-8 py-4 rounded-lg font-bold shadow-level-2">
                            Pendaftaran Gelombang Ini Telah Ditutup
                        </div>
                    @endif
                    
                    <a href="{{ route('login') }}" class="border border-inverse-primary text-inverse-primary font-label-sm text-label-sm px-8 py-4 rounded-lg hover:bg-surface-tint/20 transition-colors">
                        Sudah Punya Akun? Masuk
                    </a>
                @endauth
            </div>
        </div>

        <div class="w-full md:w-2/5 hidden md:block">
            <div class="relative rounded-xl overflow-hidden shadow-ambient border-4 border-primary/30 transform rotate-2 hover:rotate-0 transition-transform duration-500">
                <img alt="Santri Daar el-Haq" class="w-full h-auto object-cover aspect-[4/3]" src="{{ asset('assets/images/hero-pesantren.jpg') }}" onerror="this.src='https://placehold.co/600x450?text=Gambar+Belum+Ada'">
            </div>
        </div>
        
    </div>
</section>
    <section class="max-w-[1280px] mx-auto px-6 md:px-8 relative z-20 -mt-16 mb-24">
        <div class="bg-surface rounded-xl shadow-level-2 border border-outline-variant p-8 flex flex-col md:flex-row justify-between items-center gap-8 divide-y md:divide-y-0 md:divide-x divide-outline-variant">
            <div class="w-full md:w-1/3 text-center px-4">
                <div class="text-tertiary-fixed-dim font-h1 text-h1 mb-2">500+</div>
                <div class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Santri Aktif</div>
            </div>
            <div class="w-full md:w-1/3 text-center px-4 pt-6 md:pt-0">
                <div class="text-tertiary-fixed-dim font-h1 text-h1 mb-2">50+</div>
                <div class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Pengajar Tersertifikasi</div>
            </div>
            <div class="w-full md:w-1/3 text-center px-4 pt-6 md:pt-0">
                <div class="text-tertiary-fixed-dim font-h1 text-h1 mb-2">100%</div>
                <div class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Fasilitas Modern</div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-surface-container-low">
        <div class="max-w-[1280px] mx-auto px-6 md:px-8">
            <div class="text-center mb-16 space-y-4">
                <h2 class="font-h2 text-h2 text-on-surface">Program Unggulan</h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mx-auto">
                    Kurikulum komprehensif yang menyeimbangkan kecerdasan spiritual, akademik, dan keterampilan bahasa internasional.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 bg-surface rounded-xl shadow-level-1 border-t-4 border-tertiary-fixed-dim p-8 relative overflow-hidden group">
                    <div class="absolute right-0 bottom-0 opacity-5 group-hover:opacity-10 transition-opacity transform translate-x-4 translate-y-4">
                        <span class="material-symbols-outlined text-[200px]" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                    </div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full bg-primary-container text-tertiary-fixed-dim flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined">menu_book</span>
                        </div>
                        <h3 class="font-h3 text-h3 text-on-surface mb-3">Tahfidz Al-Qur'an</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-6 max-w-md">
                            Program intensif hafalan 30 juz dengan metode mutqin, didampingi oleh musyrif berpengalaman dan bersanad.
                        </p>
                    </div>
                </div>
                <div class="bg-surface rounded-xl shadow-level-1 border border-outline-variant p-8 relative overflow-hidden group hover:shadow-level-2 transition-shadow">
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined">science</span>
                        </div>
                        <h3 class="font-h3 text-h3 text-on-surface mb-3">Academic Excellence</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-6">
                            Kurikulum nasional yang diperkaya dengan pendekatan STEM untuk mempersiapkan generasi inovator.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-surface">
        <div class="max-w-[1280px] mx-auto px-6 md:px-8">
            <div class="text-center mb-16 space-y-4">
                <h2 class="font-h2 text-h2 text-on-surface">Alur Pendaftaran</h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mx-auto">
                    Proses penerimaan santri baru didesain sederhana dan transparan.
                </p>
            </div>
            <div class="relative max-w-4xl mx-auto">
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-surface-variant -translate-y-1/2 z-0"></div>
                <div class="hidden md:block absolute top-1/2 left-0 w-1/4 h-1 bg-primary-container -translate-y-1/2 z-0"></div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-primary-container text-on-primary flex items-center justify-center font-h3 text-h3 mb-4 shadow-level-1 border-4 border-surface">1</div>
                        <h4 class="font-label-sm text-label-sm text-on-surface mb-2">Pendaftaran Online</h4>
                        <p class="font-caption text-caption text-on-surface-variant">Mengisi formulir data diri melalui portal.</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-h3 text-h3 mb-4 shadow-level-1 border-4 border-surface">2</div>
                        <h4 class="font-label-sm text-label-sm text-on-surface mb-2">Seleksi Berkas</h4>
                        <p class="font-caption text-caption text-on-surface-variant">Verifikasi dokumen akademik dan pendukung.</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-h3 text-h3 mb-4 shadow-level-1 border-4 border-surface">3</div>
                        <h4 class="font-label-sm text-label-sm text-on-surface mb-2">Tes Potensi</h4>
                        <p class="font-caption text-caption text-on-surface-variant">Ujian akademik, baca Al-Qur'an & wawancara.</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-h3 text-h3 mb-4 shadow-level-1 border-4 border-surface">4</div>
                        <h4 class="font-label-sm text-label-sm text-on-surface mb-2">Pengumuman</h4>
                        <p class="font-caption text-caption text-on-surface-variant">Hasil seleksi & daftar ulang.</p>
                    </div>
                </div>
            </div>
            <div class="mt-16 text-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-block bg-primary-container text-on-primary font-label-sm text-label-sm px-8 py-4 rounded-lg hover:bg-surface-tint transition-colors shadow-level-2">Lanjutkan ke Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="inline-block bg-primary-container text-on-primary font-label-sm text-label-sm px-8 py-4 rounded-lg hover:bg-surface-tint transition-colors shadow-level-2">Mulai Pendaftaran Sekarang</a>
                @endauth
            </div>
        </div>
    </section>
</main>

<footer class="bg-[#073216] dark:bg-emerald-950 font-['Manrope'] text-xs uppercase tracking-widest full-width py-12 px-8 border-t border-emerald-800/50 shadow-none">
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