@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div class="min-h-screen bg-surface flex">
    
    <div class="w-64 bg-primary text-white p-6 hidden md:block">
        <h2 class="font-display font-bold text-xl text-yellow-500 mb-10 border-b border-white/20 pb-4">Panel Panitia PSB</h2>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 bg-white/10 px-4 py-3 rounded-xl font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard Utama
                </a>
            </li>

            @if(Auth::user()->role === 'super_admin')
            <li class="mt-6 border-t border-white/10 pt-6">
                <p class="text-[10px] font-bold text-white/40 uppercase mb-3 px-4 tracking-widest">Super Admin</p>
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 hover:bg-white/10 px-4 py-3 rounded-xl transition mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan Sistem
                </a>
                <a href="{{ route('admin.manage.admins') }}" class="flex items-center gap-3 hover:bg-white/10 px-4 py-3 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manajemen Panitia
                </a>
            </li>
            @endif
        </ul>
    </div>

    <div class="flex-1 p-8 lg:p-12 overflow-y-auto">
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
</div>
@endsection