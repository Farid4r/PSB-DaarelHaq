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
                        Penerimaan Santri Baru {{ $ta }} : {{ $isOpen ? 'DIBUKA' : 'DITUTUP' }}
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

        {{-- SECTION VISI & MISI --}}
        <section class="py-20 bg-surface">
            <div class="max-w-[1280px] mx-auto px-6 md:px-8">
                <!-- Section header -->
                <div class="text-center mb-14">
                    <h1 class="font-h2 text-h2 font-bold text-on-surface">Visi & Misi</h1>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6 lg:gap-8">
                    {{-- Visi --}}
                    <div class="group bg-surface rounded-2xl p-8 md:p-10 shadow-level-1 border-t-4 border-on-primary-container transition-all duration-300 hover:shadow-level-2 hover:-translate-y-1 relative overflow-hidden">
                        <!-- Subtle gradient overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-br  opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-primary-container flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <span class="material-symbols-outlined text-on-primary-container text-3xl">visibility</span>
                            </div>
                            <h3 class="font-h3 text-h3 text-on-surface mb-5">Visi Pondok</h3>
                            <div class="prose text-on-surface-variant font-body-md leading-relaxed">
                                {!! $visi ?: '<p class="italic opacity-60">Data Visi belum diisi oleh Admin.</p>' !!}
                            </div>
                        </div>
                    </div>

                    {{-- Misi --}}
                    <div class="group bg-surface rounded-2xl p-8 md:p-10 shadow-level-1 border-t-4 border-on-tertiary-container transition-all duration-300 hover:shadow-level-2 hover:-translate-y-1 relative overflow-hidden">
                        <!-- Subtle gradient overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-br  opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="relative">
                            <div class="w-14 h-14 rounded-2xl bg-tertiary-container flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <span class="material-symbols-outlined text-on-tertiary-container text-3xl">flag</span>
                            </div>
                            <h3 class="font-h3 text-h3 text-on-surface mb-5">Misi Pondok</h3>
                            <div class="prose text-on-surface-variant font-body-md leading-relaxed">
                                {!! $misi ?: '<p class="italic opacity-60">Data Misi belum diisi oleh Admin.</p>' !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION PIMPINAN --}}
        <section class="py-15 bg-surface">
            <div class="max-w-[1280px] mx-auto px-6 md:px-8">
                <div class="text-center mb-16 space-y-4">
                    <h2 class="font-h2 text-h2 font-bold text-primary-container ">Pimpinan & Pengasuh</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mx-auto">
                        Dibimbing oleh para kyai dan ustadz yang berdedikasi tinggi dalam mencetak generasi qur'ani.
                    </p>
                </div>
                
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($leaders as $leader)
                    <!-- Tambahkan h-96 atau h-[400px] agar tinggi kartu seragam -->
                    <div class="relative bg-surface rounded-xl shadow-level-1 overflow-hidden group hover:shadow-level-2 transition-all duration-300 h-70 border-b-4 border-tertiary">
                        
                        <!-- Bagian Foto: Diubah menjadi h-full agar memenuhi seluruh kartu -->
                        @if($leader->photo)
                            <img src="{{ asset('storage/' . $leader->photo) }}" alt="{{ $leader->name }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-surface-variant flex items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[80px] opacity-50">person</span>
                            </div>
                        @endif
                        
                        <!-- ========================================== -->
                        <!-- BAGIAN TEKS OVERLAY DENGAN GRADASI -->
                        <!-- ========================================== -->
                        <!-- absolute, bottom-0, w-full: Menempel di bawah gambar -->
                        <!-- bg-gradient-to-t: Gradasi dari bawah ke atas -->
                        <!-- pt-24: Memberikan ruang kosong di atas teks agar gradasinya halus -->
                        <div class="absolute bottom-0 left-0 w-full p-6 pt-24 text-center bg-gradient-to-t from-primary via-primary/80 to-transparent flex flex-col justify-end">
                            
                            <h3 class="font-h3 text-h3 font-bold text-white mb-1">
                                {{ $leader->name }}
                            </h3>
                            
                            <p class="font-label-sm text-label-sm text-white/70 uppercase tracking-wider mb-2 font-bold drop-shadow-md">
                                {{ $leader->position }}
                            </p>
                            
                            <p class="font-body-sm text-body-sm text-white/90 line-clamp-2 leading-relaxed">
                                {{ $leader->description }}
                            </p>
                            
                        </div>
                        <!-- ========================================== -->

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