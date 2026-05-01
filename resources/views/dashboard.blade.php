@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-surface py-12 px-6 lg:px-24">
    <div class="max-w-5xl mx-auto">
        
        <header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <span class="text-tertiary font-bold uppercase tracking-widest text-xs">Pusat Informasi Santri</span>
                <h1 class="text-5xl font-display font-extrabold text-primary mt-2">Ahlan wa Sahlan, <br>{{ $user->name }}</h1>
            </div>
            <div class="bg-white p-4 rounded-2xl shadow-ambient flex items-center gap-4 border border-surface-container">
                <div class="text-right">
                    <p class="text-xs text-on-surface/40 uppercase font-bold tracking-tighter">No. Pendaftaran</p>
                    <p class="font-display font-bold text-primary">{{ $registration->registration_number }}</p>
                </div>
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
        </header>

        <div class="grid lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
    
    <!-- 1. Sembunyikan tombol Kembali jika sudah bayar/divalidasi -->
    @if($registration->status === 'pending')
        <a href="{{ route('register.step3') }}" class="text-tertiary text-sm font-bold uppercase tracking-widest hover:underline mb-1 inline-block">← Kembali ke Berkas</a>
    @endif
    
    <div class="bg-white p-8 rounded-3xl shadow-ambient relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16"></div>
        
        <h3 class="font-display font-bold text-primary mb-6 relative z-10">Status Pendaftaran</h3>
        
        @php
            $statusClasses = [
                'pending' => 'bg-tertiary-fixed text-tertiary border-tertiary/20',
                'paid' => 'bg-blue-100 text-secondary border-secondary/20',
                'verified' => 'bg-primary/10 text-primary border-primary/20',
                'accepted' => 'bg-green-100 text-green-800',
                'rejected' => 'bg-red-100 text-red-800'
            ];
            $statusLabels = [
                'pending' => 'Menunggu Pembayaran',
                'paid' => 'Menunggu Verifikasi Admin',
                'verified' => 'Berkas Terverifikasi',
                'accepted' => 'Lulus Seleksi',
                'rejected' => 'Tidak Lulus'
            ];
            // 2. Ambil biaya pendaftaran dari pengaturan Admin
            $fee = \App\Models\Setting::get('registration_fee', 150000);
        @endphp

        <div class="inline-block px-4 py-2 rounded-full font-bold text-sm border {{ $statusClasses[$registration->status] ?? 'bg-gray-100' }} mb-6">
            {{ $statusLabels[$registration->status] ?? $registration->status }}
        </div>

        <p class="text-sm text-on-surface/60 leading-relaxed italic">
            "Teruslah berikhtiar dan berdoa, hasil terbaik adalah ketetapan-Nya."
        </p>
    </div>

    <!-- Logika Tombol Bayar Midtrans -->
    @if($registration->status == 'pending' && $registration->snap_token)
        <button id="pay-button" class="w-full py-4 bg-tertiary text-white rounded-2xl font-bold shadow-ambient hover:scale-[1.02] transition-transform flex items-center justify-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            <!-- Menampilkan angka secara dinamis dengan format Rupiah -->
            Bayar Rp {{ number_format($fee, 0, ',', '.') }}
        </button>
        
        <!-- 3. URL Script Midtrans yang mendeteksi .env (Sandbox/Production) otomatis -->
        @php
            $midtransUrl = config('midtrans.is_production') 
                ? 'https://app.midtrans.com/snap/snap.js' 
                : 'https://app.sandbox.midtrans.com/snap/snap.js';
        @endphp
        <script src="{{ $midtransUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
        
        <script>
            document.getElementById('pay-button').onclick = function(){
                snap.pay('{{ $registration->snap_token }}', {
                    onSuccess: function(result){
                        alert("Pembayaran Berhasil! Halaman akan dimuat ulang.");
                        setTimeout(function() { location.reload(); }, 2500);
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran Anda. Silakan selesaikan transfer.");
                        location.reload();
                    },
                    onError: function(result){
                        alert("Pembayaran Gagal!");
                        location.reload();
                    }
                });
            };
        </script>
    @endif

    <!-- Logika Tombol Cetak / Peringatan -->
    @if(in_array($registration->status, ['verified', 'accepted']))
        
        <a href="{{ route('cetak.kartu') }}" target="_blank" class="w-full py-4 bg-green-600 text-white rounded-2xl font-bold shadow-ambient hover:scale-[1.02] transition-transform flex items-center justify-center gap-3">
            <!-- Tambahan Ikon Printer agar lebih cantik -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Kartu Pendaftaran
        </a>

    @elseif($registration->status == 'paid')
        
        <div class="w-full py-4 bg-blue-100 border border-blue-200 text-blue-700 rounded-2xl shadow-ambient flex items-center px-6 gap-3">
            <!-- Tambahan Ikon Info -->
            <svg class="w-8 h-8 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm font-semibold leading-snug">Pembayaran berhasil. Silakan tunggu Panitia memvalidasi berkas Anda sebelum dapat mencetak kartu.</p>
        </div>

    @elseif($registration->status == 'rejected')
        
        <!-- 4. Penanganan Jika Ditolak -->
        <div class="w-full py-4 bg-red-100 border border-red-200 text-red-700 rounded-2xl shadow-ambient flex items-center px-6 gap-3">
            <svg class="w-8 h-8 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-sm font-semibold leading-snug">Mohon maaf, Anda dinyatakan Tidak Lulus. Silakan hubungi panitia untuk info lebih lanjut.</p>
        </div>

    @endif

</div>
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white p-8 rounded-3xl">
                    <h3 class="font-display font-bold text-primary text-xl mb-8 flex items-center gap-3">
                        <span class="w-8 h-8 bg-primary text-white rounded-lg flex items-center justify-center text-sm">01</span>
                        Ringkasan Profil
                    </h3>
                    
                    <div class="grid md:grid-cols-2 gap-y-6 gap-x-8">
                        <div class="md:col-span-2">
                            <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">Nama Lengkap</p>
                            <p class="font-bold text-primary text-lg">{{ $registration->full_name ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">Nama Panggilan</p>
                            <p class="font-bold text-primary">{{ $registration->nickname ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">Jenjang Pilihan</p>
                            <p class="font-bold text-primary">{{ $registration->level ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">Tempat, Tanggal Lahir</p>
                            <p class="font-bold text-primary">{{ $registration->place_of_birth ?? '-' }}, {{ $registration->date_of_birth ? \Carbon\Carbon::parse($registration->date_of_birth)->format('d F Y') : '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">Jenis Kelamin</p>
                            <p class="font-bold text-primary">{{ $registration->gender == 'L' ? 'Laki-laki' : ($registration->gender == 'P' ? 'Perempuan' : '-') }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">Status Saudara</p>
                            <p class="font-bold text-primary">Anak ke-{{ $registration->child_order ?? '-' }} dari {{ $registration->siblings_count ?? '-' }} bersaudara</p>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">Nomor WhatsApp</p>
                            <p class="font-bold text-primary">{{ $user->phone ?? '-' }}</p>
                        </div>

                        <div class="md:col-span-2 border-t border-surface-container pt-6 mt-2">
                            <p class="text-sm font-bold text-primary mb-4 opacity-80 uppercase tracking-wider">Data Pendidikan & Beasiswa</p>
                            <div class="grid md:grid-cols-2 gap-y-6 gap-x-8">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">Sekolah Asal</p>
                                    <p class="font-bold text-primary">{{ $registration->previous_school_name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">NISN</p>
                                    <p class="font-bold text-primary">{{ $registration->nisn ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">Nomor KIP</p>
                                    <p class="font-bold text-primary">{{ $registration->kip_number ? $registration->kip_number : 'Tidak Ada / Tidak Mengisi' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-1">Alamat Sekolah Asal</p>
                                    <p class="font-bold text-primary leading-relaxed">{{ $registration->previous_school_address ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl">
                    <h3 class="font-display font-bold text-primary text-xl mb-8 flex items-center gap-3">
                        <span class="w-8 h-8 bg-primary text-white rounded-lg flex items-center justify-center text-sm">02</span>
                        Data Orang Tua
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between border-b border-surface-container pb-4">
                            <span class="text-on-surface/60">Nama Ayah</span>
                            <span class="font-bold text-primary">{{ $registration->parentDetail->father_name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-surface-container pb-4">
                            <span class="text-on-surface/60">Nama Ibu</span>
                            <span class="font-bold text-primary">{{ $registration->parentDetail->mother_name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-on-surface/60">Alamat</span>
                            <span class="font-bold text-primary text-right max-w-xs">{{ $registration->parentDetail->address ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl">
                    <h3 class="font-display font-bold text-primary text-xl mb-8 flex items-center gap-3">
                        <span class="w-8 h-8 bg-primary text-white rounded-lg flex items-center justify-center text-sm">03</span>
                        Dokumen Digital
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        @forelse($registration->documents as $doc)
                            <div class="bg-white p-4 rounded-2xl border border-surface-container group hover:shadow-ambient transition-all">
                                <div class="aspect-video bg-surface rounded-xl mb-4 flex items-center justify-center overflow-hidden relative">
                                    @php
                                        $isImage = in_array(pathinfo($doc->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']);
                                    @endphp

                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $doc->file_path) }}" class="object-cover w-full h-full opacity-80 group-hover:opacity-100 transition-opacity">
                                    @else
                                        <svg class="w-10 h-10 text-primary/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    @endif
                                    
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="absolute inset-0 bg-primary/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="bg-white text-primary text-[10px] font-bold px-3 py-1 rounded-full">LIHAT BERKAS</span>
                                    </a>
                                </div>

                                <div class="text-center">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface/40 mb-1">Jenis Dokumen</p>
                                    <p class="text-sm font-display font-bold text-primary uppercase">{{ $doc->type }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-on-surface/40 italic py-8">Belum ada dokumen yang diunggah.</p>
                        @endforelse
                    </div>
                </div>

            </div> 
        </div>
    </div>
</div>
@endsection