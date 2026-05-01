@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-surface flex items-stretch">
    <div class="hidden lg:flex w-1/3 bg-primary p-12 flex-col justify-between relative overflow-hidden text-white">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-20 -left-10 w-40 h-40 rounded-full bg-tertiary blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <h3 class="font-display text-2xl font-bold text-white mb-12">Alur Pendaftaran</h3>
            
            <nav class="space-y-12">
                <div class="flex items-start gap-6 group">
                    <div class="flex flex-col items-center">
                        <div class="w-4 h-4 rounded-full bg-white shadow-[0_0_15px_rgba(115,92,0,0.5)]"></div>
                        <div class="w-0.5 h-16 bg-white mt-2"></div>
                    </div>
                    <div>
                        <p class="font-display font-bold text-lg text-yellow-500">Biodata Pribadi</p>
                        <p class="text-sm text-white/60">Informasi dasar calon santri</p>
                    </div>
                </div>

                <div class="flex items-start gap-6 opacity-40">
                    <div class="flex flex-col items-center">
                        <div class="w-4 h-4 rounded-full border-2 border-white/30"></div>
                        <div class="w-0.5 h-16 bg-white/10 mt-2"></div>
                    </div>
                    <div>
                        <p class="font-display font-bold text-lg text-white">Data Orang Tua</p>
                        <p class="text-sm text-white/60">Informasi wali & kontak</p>
                    </div>
                </div>

                <div class="flex items-start gap-6 opacity-40">
                    <div class="w-4 h-4 rounded-full border-2 border-white/30"></div>
                    <div>
                        <p class="font-display font-bold text-lg text-white">Unggah Berkas</p>
                        <p class="text-sm text-white/60">Verifikasi dokumen sakral</p>
                    </div>
                </div>
            </nav>
        </div>

        <div class="relative z-10">
            <p class="text-xs text-white/40 tracking-widest uppercase italic">Pondok Pesantren Daar el-Haq</p>
        </div>
    </div>

    <div class="flex-1 p-8 lg:p-24 overflow-y-auto">
        <div class="max-w-xl mx-auto">
            <header class="mb-10">
                <h1 class="text-4xl font-display font-extrabold text-primary mb-4 tracking-tight">Identitas Diri</h1>
                <p class="text-on-surface/60 leading-relaxed">
                    Mulailah langkah pertama Anda dengan mengisi informasi pribadi dengan seksama. Data ini akan menjadi bagian dari catatan akademik sakral Anda.
                </p>
            </header>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-8 relative shadow-sm" role="alert">
                    <strong class="font-bold">Oops! Ada isian yang kurang tepat:</strong>
                    <ul class="mt-2 list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.step1.post') }}" method="POST" class="space-y-10">
                @csrf

                <div>
                    <h3 class="text-xl font-display font-bold text-primary mb-4 border-b pb-2">Program Pilihan</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex cursor-pointer">
                            <input type="radio" name="level" value="SMP" class="peer sr-only" {{ (old('level', $registration->level ?? '') == 'SMP') ? 'checked' : '' }}>
                            <div class="w-full p-4 rounded-xl border border-surface-container bg-white peer-checked:border-primary peer-checked:bg-primary/5 hover:bg-surface transition-all text-center">
                                <span class="font-bold text-primary">Tingkat SMP</span>
                            </div>
                        </label>
                        <label class="relative flex cursor-pointer">
                            <input type="radio" name="level" value="SMA" class="peer sr-only" {{ (old('level', $registration->level ?? '') == 'SMA') ? 'checked' : '' }}>
                            <div class="w-full p-4 rounded-xl border border-surface-container bg-white peer-checked:border-primary peer-checked:bg-primary/5 hover:bg-surface transition-all text-center">
                                <span class="font-bold text-primary">Tingkat SMA</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-display font-bold text-primary mb-4 border-b pb-2">Biodata Pribadi</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">Nama Lengkap (Sesuai Akta/Ijazah)</label>
                            <input type="text" name="full_name" value="{{ old('full_name', $registration->full_name ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">Nama Panggilan</label>
                            <input type="text" name="nickname" value="{{ old('nickname', $registration->nickname ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">Nomor KIP <span class="text-xs font-normal italic">(Opsional)</span></label>
                            <input type="text" name="kip_number" value="{{ old('kip_number', $registration->kip_number ?? '') }}" placeholder="Kosongkan jika tidak ada" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">Tempat Lahir</label>
                            <input type="text" name="place_of_birth" value="{{ old('place_of_birth', $registration->place_of_birth ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $registration->date_of_birth ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">Jenis Kelamin</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" name="gender" value="L" class="peer sr-only" {{ (old('gender', $registration->gender ?? '') == 'L') ? 'checked' : '' }}>
                                    <div class="w-full p-4 rounded-xl border border-surface-container bg-white peer-checked:border-primary peer-checked:bg-primary/5 hover:bg-surface transition-all text-center">
                                        <span class="font-bold text-primary">Laki-laki</span>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" name="gender" value="P" class="peer sr-only" {{ (old('gender', $registration->gender ?? '') == 'P') ? 'checked' : '' }}>
                                    <div class="w-full p-4 rounded-xl border border-surface-container bg-white peer-checked:border-primary peer-checked:bg-primary/5 hover:bg-surface transition-all text-center">
                                        <span class="font-bold text-primary">Perempuan</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="md:col-span-2 bg-surface p-4 rounded-xl border border-surface-container flex flex-col sm:flex-row items-center gap-4">
                            <span class="text-sm font-bold text-on-surface/60">Anak Ke</span>
                            <div class="flex-1 w-full">
                                <input type="number" name="child_order" value="{{ old('child_order', $registration->child_order ?? '') }}" placeholder="Contoh: 1" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary outline-none text-center">
                            </div>
                            <span class="text-sm font-bold text-on-surface/60">Dari</span>
                            <div class="flex-1 w-full">
                                <input type="number" name="siblings_count" value="{{ old('siblings_count', $registration->siblings_count ?? '') }}" placeholder="Contoh: 3" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary outline-none text-center">
                            </div>
                            <span class="text-sm font-bold text-on-surface/60">Bersaudara</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-display font-bold text-primary mb-4 border-b pb-2">Identitas Sekolah Asal</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">Nama Sekolah (SD/MI/MTs/SMP)</label>
                            <input type="text" name="previous_school_name" value="{{ old('previous_school_name', $registration->previous_school_name ?? '') }}" placeholder="Contoh: SDN 01 Jakarta" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">NISN</label>
                            <input type="number" name="nisn" value="{{ old('nisn', $registration->nisn ?? '') }}" placeholder="Wajib 10 Digit Angka" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">Alamat Sekolah Asal</label>
                            <textarea name="previous_school_address" rows="3" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">{{ old('previous_school_address', $registration->previous_school_address ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-8">
                    <button type="submit" class="w-full lg:w-max px-12 py-4 bg-primary text-white font-bold rounded-xl shadow-ambient hover:bg-primary-container transition-all transform hover:-translate-y-1">
                        Lanjutkan ke Data Wali
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection