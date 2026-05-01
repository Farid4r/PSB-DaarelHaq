@extends('layouts.app')
@section('title', 'Data Orang Tua')
@section('content')
<div class="min-h-screen bg-surface flex items-stretch">
    <div class="hidden lg:flex w-1/3 bg-primary p-12 flex-col justify-between relative overflow-hidden text-white">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-20 -left-10 w-40 h-40 rounded-full bg-tertiary blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <h3 class="font-display text-2xl font-bold text-white mb-12">Alur Pendaftaran</h3>
            
            <nav class="    space-y-12">
                <div class="flex items-start gap-6 group">
                    <div class="flex flex-col items-center">
                        <div class="w-4 h-4 rounded-full bg-yellow-500 shadow-[0_0_15px_rgba(115,92,0,0.5)] flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div class="w-0.5 h-16 bg-yellow-500 mt-2"></div>
                    </div>
                    <div>
                        <p class="font-display font-bold text-lg text-yellow-500">Biodata Pribadi</p>
                        <p class="text-sm text-white/40 italic">Langkah Selesai</p>
                    </div>
                </div>

                <div class="flex items-start gap-6">
                    <div class="flex flex-col items-center">
                        <div class="w-4 h-4 rounded-full bg-white shadow-[0_0_15px_rgba(255,255,255,0.3)]"></div>
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
            <header class="mb-16">
                <a href="{{ route('register.step1') }}" class="text-secondary text-sm font-bold uppercase tracking-widest hover:text-tertiary transition-colors mb-6 inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
                <h1 class="text-4xl font-display font-extrabold text-primary mb-4 tracking-tight">Data Orang Tua</h1>
                <p class="text-on-surface/60 leading-relaxed">
                    Hormat kami kepada orang tua/wali. Mohon lengkapi informasi berikut untuk memudahkan koordinasi pendidikan ananda di masa depan.
                </p>
            </header>

            <form action="{{ route('register.step2.post') }}" method="POST" class="space-y-10">
                @csrf
                
                <div class="space-y-8">
                    <h2 class="font-display font-bold text-primary text-xl">Informasi Ayah</h2>
                    
                    <div class="group relative">
                        <label class="block text-sm font-bold text-on-surface/60 mb-2">Nama Lengkap Ayah</label>
                        <input type="text" name="father_name" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" value="{{ old('father_name', $parent->father_name ?? '') }}" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group relative">
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">Pekerjaan</label>
                            <input type="text" name="father_occupation" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" value="{{ old('father_occupation', $parent->father_occupation ?? '') }}" required>
                        </div>
                        <div class="group relative">
                            <label class="block text-sm font-bold text-on-surface/60 mb-2">No. WhatsApp</label>
                            <input type="text" name="father_phone" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" value="{{ old('father_phone', $parent->father_phone ?? '') }}" required>
                        </div>
                    </div>
                </div>

                <hr class="border-surface-container-highest">

                <div class="space-y-8">
                    <h2 class="font-display font-bold text-primary text-xl">Informasi Ibu</h2>
                    <div class="group relative">
                        <label class="block text-sm font-bold text-on-surface/60 mb-2">Nama Lengkap Ibu</label>
                        <input type="text" name="mother_name" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" value="{{ old('mother_name', $parent->mother_name ?? '') }}" required>
                    </div>
                    <div class="group relative">
                        <label class="block text-sm font-bold text-on-surface/60 mb-2">Pekerjaan Ibu</label>
                        <input type="text" name="mother_occupation" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" value="{{ old('mother_occupation', $parent->mother_occupation ?? '') }}" required>
                    </div>
                </div>

                <hr class="border-surface-container-highest">

                <div class="group relative">
                    <label class="block text-sm font-bold text-on-surface/60 mb-2">Alamat Lengkap Rumah</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-3 rounded-xl border border-surface-container focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>{{ old('address', $parent->address ?? '') }}</textarea>
                </div>

                <div class="pt-8">
                    <button type="submit" class="w-full lg:w-max px-12 py-4 bg-primary text-white font-bold rounded-xl shadow-ambient hover:bg-primary-container transition-all transform hover:-translate-y-1">
                        Lanjutkan ke Unggah Berkas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection