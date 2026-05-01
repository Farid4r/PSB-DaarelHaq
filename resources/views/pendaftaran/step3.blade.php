@extends('layouts.app')
@section('title', 'Unggah Dokumen')
@section('content')
<div class="min-h-screen bg-surface flex items-stretch">
    
    <div class="hidden lg:flex w-1/3 bg-primary p-12 flex-col relative overflow-hidden text-white shadow-ambient z-10">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-20 -left-10 w-40 h-40 rounded-full bg-tertiary blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <h3 class="font-display text-2xl font-bold text-white mb-12">Alur Pendaftaran</h3>
            
            <nav class="space-y-12">
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

                <div class="flex items-start gap-6 group">
                    <div class="flex flex-col items-center">
                        <div class="w-4 h-4 rounded-full bg-yellow-500 shadow-[0_0_15px_rgba(115,92,0,0.5)] flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div class="w-0.5 h-16 bg-yellow-500 mt-2"></div>
                    </div>
                    <div>
                        <p class="font-display font-bold text-lg text-yellow-500">Data Orang Tua</p>
                        <p class="text-sm text-white/40 italic">Langkah Selesai</p>
                    </div>
                </div>


                <div class="flex items-start gap-6">
                    <div class="flex flex-col items-center">
                        <div class="w-4 h-4 rounded-full bg-white shadow-[0_0_15px_rgba(255,255,255,0.3)]"></div>
                    </div>
                    <div>
                        <p class="font-display font-bold text-lg text-white">Unggah Berkas</p>
                        <p class="text-sm text-white/60">Verifikasi dokumen sakral</p>
                    </div>
                </div>
            </nav>
        </div>

    </div> <div class="flex-1 p-8 lg:p-24 overflow-y-auto">
        <div class="max-w-2xl mx-auto">
            <header class="mb-12">
                <a href="{{ route('register.step2') }}" class="text-secondary text-sm font-bold uppercase tracking-widest hover:text-tertiary transition-colors mb-6 inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
                <h1 class="text-4xl font-display font-extrabold text-primary mb-4 tracking-tight">Dokumen Pendaftaran</h1>
                <p class="text-on-surface/70 leading-relaxed text-lg">Silakan unggah pindaian dokumen asli. Pastikan dokumen terbaca dengan jelas untuk mempercepat proses verifikasi oleh panitia.</p>
            </header>

            <form action="{{ route('register.step3.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                @php
                    $uploadFields = [
                        'ijazah' => ['label' => 'Ijazah / SKL', 'format' => 'Format: JPG, PNG, atau PDF (Maks. 2MB)'],
                        'kk' => ['label' => 'Kartu Keluarga', 'format' => 'Format: JPG, PNG, atau PDF (Maks. 2MB)'],
                        'akta' => ['label' => 'Akta Kelahiran', 'format' => 'Format: JPG, PNG, atau PDF (Maks. 2MB)'],
                        'bpjs' => ['label' => 'Kartu BPJS / KIS (Opsional)', 'format' => 'Format: JPG, PNG, atau PDF (Maks. 2MB)'],
                        'ktp' => ['label' => 'KTP Orang Tua / Wali', 'format' => 'Format: JPG, PNG, atau PDF (Maks. 2MB)'],
                        'pas_foto' => ['label' => 'Pas Foto (Berlatar Merah)', 'format' => 'Format: HANYA JPG atau PNG (Maks. 2MB)'],
                    ];
                @endphp

                @foreach($uploadFields as $name => $info)
                <div class="p-6 rounded-2xl bg-surface-container-low border @error($name)border-red-500 @else border-surface-container hover:border-primary/30 @enderror transition-all group relative">
                    <label class="block mb-4">
                        <span class="block text-sm font-bold uppercase tracking-widest text-primary mb-1">{{ $info['label'] }}</span>
                        <span class="text-sm text-on-surface/50 italic">{{ $info['format'] }}</span>
                    </label>
                    
                    <input type="file" name="{{ $name }}" class="block w-full text-sm text-on-surface/70 
                        file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 
                        file:text-sm file:font-bold file:bg-primary/10 file:text-primary 
                        hover:file:bg-primary hover:file:text-white file:transition-colors cursor-pointer">
                    
                    @error($name)
                        <span class="text-red-500 text-xs mt-3 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </span>
                    @enderror

                    @if(isset($documents[$name]))
                        <div class="mt-4 items-center gap-2 text-primary-container font-bold text-sm bg-primary-container/10 p-3 rounded-xl inline-flex border border-primary-container/20">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Berkas tersimpan. Unggah file baru untuk mengganti.
                        </div>
                    @endif
                </div>
                @endforeach

                <div class="pt-8">
                    <button type="submit" class="w-full px-12 py-4 bg-primary text-white font-display font-bold text-lg rounded-xl shadow-ambient hover:bg-primary-dark transition-all flex items-center justify-center gap-3 group">
                        Selesaikan Pendaftaran
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection