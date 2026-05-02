<x-public-layout>
    <x-slot name="title">Beranda - Daar el-Haq</x-slot>

    <main class="flex-grow">
        {{-- HERO SECTION --}}
        <section class="relative bg-primary-container text-on-primary min-h-screen flex items-center py-20 overflow-hidden">
            <div class="absolute inset-0 z-0 opacity-20 bg-cover bg-center" style="background-image: url('{{ asset('assets/images/kls6.jpg') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-primary-container to-transparent z-0"></div>
            
            <div class="max-w-[1280px] w-full mx-auto px-6 md:px-8 relative z-10 flex flex-col md:flex-row items-center gap-12">
                <div class="w-full md:w-3/5 space-y-6">
                    @php
                        $isOpen = \App\Models\Setting::where('key', 'is_registration_open')->value('value') == '1';
                        $ta = \App\Models\Setting::where('key', 'academic_year')->value('value') ?? '2026/2027';
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

        {{-- STATISTIK SECTION --}}
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

        {{-- SECTION TENTANG KAMI --}}
        <section class="py-16 bg-surface-container-lowest">
            <div class="max-w-[1280px] mx-auto px-6 md:px-8">
                <div class="bg-surface rounded-xl shadow-level-1 border border-outline-variant p-8 md:p-12">
                    <h2 class="font-h2 text-h2 text-on-surface mb-8 text-center">Tentang Kami</h2>
                    <div class="prose max-w-4xl mx-auto text-on-surface-variant font-body-md text-center leading-relaxed">
                        {!! $tentangKami ?: '<p>Data Profil belum diisi oleh Admin.</p>' !!}
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION VISI & MISI --}}
        <section class="py-16 bg-surface">
            <div class="max-w-[1280px] mx-auto px-6 md:px-8 grid md:grid-cols-2 gap-8">
                {{-- Visi --}}
                <div class="bg-surface-container-low rounded-xl shadow-level-1 p-8 border border-outline-variant hover:shadow-level-2 transition-shadow">
                    <h2 class="font-h3 text-h3 text-on-surface mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined text-tertiary-fixed-dim text-3xl">visibility</span> Visi Pondok
                    </h2>
                    <div class="prose text-on-surface-variant font-body-md">
                        {!! $visi ?: '<p>Data Visi belum diisi oleh Admin.</p>' !!}
                    </div>
                </div>

                {{-- Misi --}}
                <div class="bg-surface-container-low rounded-xl shadow-level-1 p-8 border border-outline-variant hover:shadow-level-2 transition-shadow">
                    <h2 class="font-h3 text-h3 text-on-surface mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined text-tertiary-fixed-dim text-3xl">flag</span> Misi Pondok
                    </h2>
                    <div class="prose text-on-surface-variant font-body-md">
                        {!! $misi ?: '<p>Data Misi belum diisi oleh Admin.</p>' !!}
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION PIMPINAN --}}
        <section class="py-24 bg-surface-container-low">
            <div class="max-w-[1280px] mx-auto px-6 md:px-8">
                <div class="text-center mb-16 space-y-4">
                    <h2 class="font-h2 text-h2 text-on-surface">Pimpinan & Pengasuh</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mx-auto">
                        Dibimbing oleh para kyai dan ustadz yang berdedikasi tinggi dalam mencetak generasi qur'ani.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse($leaders as $leader)
                        <div class="bg-surface rounded-xl shadow-level-1 border border-outline-variant overflow-hidden group hover:shadow-level-2 transition-all duration-300">
                            @if($leader->photo)
                                <img src="{{ asset('storage/' . $leader->photo) }}" alt="{{ $leader->name }}" class="w-full h-72 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-72 bg-surface-variant flex items-center justify-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[80px] opacity-50">person</span>
                                </div>
                            @endif
                            <div class="p-6 text-center relative bg-surface">
                                <h3 class="font-h3 text-h3 text-on-surface mb-2">{{ $leader->name }}</h3>
                                <p class="font-label-sm text-label-sm text-tertiary-fixed-dim uppercase tracking-wider mb-4">{{ $leader->position }}</p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-3">{{ $leader->description }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-on-surface-variant py-8">
                            Belum ada data pimpinan yang ditambahkan.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- PROGRAM UNGGULAN SECTION --}}
        <section class="py-24 bg-surface">
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

        {{-- ALUR PENDAFTARAN SECTION --}}
        <section class="py-24 bg-surface-container-low">
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
</x-public-layout>