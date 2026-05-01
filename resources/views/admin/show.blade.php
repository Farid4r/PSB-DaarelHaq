@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-surface p-8 lg:p-12">
    <div class="max-w-6xl mx-auto">
        
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8 border-b border-surface-container pb-6">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-on-surface/40 hover:text-primary mb-2 inline-flex items-center gap-2">
                    &larr; Kembali ke Dashboard
                </a>
                <h1 class="text-3xl font-display font-bold text-primary">Detail Verifikasi</h1>
                <p class="text-on-surface/60">No. Daftar: <span class="font-bold text-primary">{{ $registration->registration_number }}</span></p>
            </div>
            
            <div class="bg-white p-4 rounded-xl border border-surface-container shadow-sm flex items-center gap-4">
                <span class="text-sm font-bold text-on-surface/60">Ubah Status:</span>
                <form action="{{ route('admin.update.status', $registration->id) }}" method="POST" class="flex gap-2">
                    @csrf
                    <button type="submit" name="status" value="verified" class="px-4 py-2 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg text-sm font-bold transition">
                        Validasi Berkas
                    </button>
                    <button type="submit" name="status" value="accepted" class="px-4 py-2 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg text-sm font-bold transition">
                        Luluskan
                    </button>
                    <button type="submit" name="status" value="rejected" class="px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-bold transition" onclick="return confirm('Yakin ingin MENOLAK santri ini?')">
                        Tolak
                    </button>
                </form>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-surface-container shadow-sm">
                    <h3 class="font-display font-bold text-primary text-lg mb-4 border-b pb-2">Biodata Santri</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-bold text-on-surface/40 uppercase">Nama Lengkap</p>
                            <p class="font-bold text-primary">{{ $registration->full_name ?? $registration->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-on-surface/40 uppercase">Jenjang</p>
                            <p class="font-bold text-primary">{{ $registration->level }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-on-surface/40 uppercase">Asal Sekolah</p>
                            <p class="font-bold text-primary">{{ $registration->previous_school_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-on-surface/40 uppercase">NISN</p>
                            <p class="font-bold text-primary">{{ $registration->nisn ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-on-surface/40 uppercase">No. WhatsApp</p>
                            <p class="font-bold text-primary">{{ $registration->user->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white p-6 rounded-2xl border border-surface-container shadow-sm">
                    <h3 class="font-display font-bold text-primary text-lg mb-6 border-b pb-2">Pengecekan Dokumen</h3>
                    
                    <div class="grid grid-cols-2 gap-6">
                        @forelse($registration->documents as $doc)
                            <div class="border border-surface-container rounded-xl p-4">
                                <p class="text-sm font-bold text-primary uppercase tracking-widest mb-3">{{ str_replace('_', ' ', $doc->type) }}</p>
                                
                                <div class="bg-surface rounded-lg flex items-center justify-center overflow-hidden h-40 relative group">
                                    @php
                                        $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                                    @endphp

                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $doc->file_path) }}" class="object-cover w-full h-full opacity-90 group-hover:opacity-100 transition">
                                    @else
                                        <div class="text-center">
                                            <svg class="w-12 h-12 text-red-500 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                                            <span class="text-xs font-bold text-on-surface/60 uppercase">Dokumen PDF</span>
                                        </div>
                                    @endif
                                    
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="absolute inset-0 bg-primary/60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <span class="bg-white text-primary text-[10px] font-bold px-3 py-1 rounded-full">LIHAT FULL</span>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-2 text-center text-on-surface/40 italic py-8">Belum ada dokumen yang diunggah.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection