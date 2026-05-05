<x-admin-layout>
    {{-- Ini adalah isi dari Halaman Dashboard --}}    <div class="flex-1 p-8 lg:p-12 overflow-y-auto">
        <header class="mb-10">
            <h1 class="text-3xl font-display font-bold text-primary">Rekapitulasi Pendaftaran</h1>
            <p class="text-on-surface/60">Pantau dan kelola data seluruh calon santri Daar el-Haq.</p>
            
            @if(Auth::user()->role === 'super_admin')
            <div class="mt-6">
                <a href="{{ route('admin.export.excel') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white font-bold rounded-xl shadow-sm hover:bg-green-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Download Laporan (Excel)
                </a>
            </div>
            @endif
        </header>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl border border-surface-container shadow-sm">
                <p class="text-sm font-bold text-on-surface/40 uppercase tracking-wider mb-2">Total Pendaftar</p>
                <p class="text-4xl font-display font-bold text-primary">{{ $totalPendaftar }}</p>
            </div>
            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 shadow-sm">
                <p class="text-sm font-bold text-blue-600/60 uppercase tracking-wider mb-2">Menunggu Verifikasi</p>
                <p class="text-4xl font-display font-bold text-blue-700">{{ $menungguVerifikasi }}</p>
            </div>
            <div class="bg-yellow-50 p-6 rounded-2xl border border-yellow-100 shadow-sm">
                <p class="text-sm font-bold text-yellow-600/60 uppercase tracking-wider mb-2">Belum Bayar</p>
                <p class="text-4xl font-display font-bold text-yellow-700">{{ $menungguPembayaran }}</p>
            </div>
            <div class="bg-green-50 p-6 rounded-2xl border border-green-100 shadow-sm">
                <p class="text-sm font-bold text-green-600/60 uppercase tracking-wider mb-2">Lulus Seleksi</p>
                <p class="text-4xl font-display font-bold text-green-700">{{ $lulus }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-surface-container shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface/60 text-sm uppercase tracking-wider">
                            <th class="p-4 font-bold border-b border-surface-container">No. Daftar</th>
                            <th class="p-4 font-bold border-b border-surface-container">Nama Lengkap</th>
                            <th class="p-4 font-bold border-b border-surface-container">Asal Sekolah</th>
                            <th class="p-4 font-bold border-b border-surface-container">Status</th>
                            <th class="p-4 font-bold border-b border-surface-container text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @forelse($registrations as $reg)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="p-4 font-bold text-primary">{{ $reg->registration_number }}</td>
                            <td class="p-4">
                                <p class="font-bold text-primary">{{ $reg->full_name ?? $reg->user->name }}</p>
                                <p class="text-xs text-on-surface/60">{{ $reg->level }} - {{ $reg->user->phone }}</p>
                            </td>
                            <td class="p-4 text-sm text-on-surface/80">{{ $reg->previous_school_name ?? '-' }}</td>
                            <td class="p-4">
                                @php
                                    $statusBadge = [
                                        'pending' => '<span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">Pending</span>',
                                        'paid' => '<span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold animate-pulse">Perlu Verifikasi</span>',
                                        'verified' => '<span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-bold">Berkas Valid</span>',
                                        'accepted' => '<span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Lulus</span>',
                                        'rejected' => '<span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Tidak Lulus</span>',
                                    ];
                                @endphp
                                {!! $statusBadge[$reg->status] ?? $reg->status !!}
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.verifikasi', $reg->id) }}" class="inline-block px-4 py-2 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-lg text-sm font-bold transition-colors">
                                    Cek Berkas
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-on-surface/40 italic">Belum ada data pendaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div></div>
</x-admin-layout>