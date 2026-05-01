@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-surface flex">
    
    <div class="w-64 bg-primary text-white p-6 hidden md:block">
        <h2 class="font-display font-bold text-xl text-yellow-500 mb-10 border-b border-white/20 pb-4">Panel Panitia PSB</h2>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 hover:bg-white/10 px-4 py-3 rounded-xl transition font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard Utama
                </a>
            </li>

            @if(Auth::user()->role === 'super_admin')
            <li class="mt-6 border-t border-white/10 pt-6">
                <p class="text-[10px] font-bold text-white/40 uppercase mb-3 px-4 tracking-widest">Super Admin</p>
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 bg-white/10 px-4 py-3 rounded-xl transition mb-2 font-bold">
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
        <div class="max-w-4xl mx-auto">
            
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-on-surface/40 hover:text-primary mb-6 inline-flex items-center gap-2">
                &larr; Kembali ke Dashboard Utama
            </a>

            <h1 class="text-3xl font-display font-bold text-primary mb-2">Pengaturan Sistem</h1>
            <p class="text-on-surface/60 mb-8">Konfigurasi parameter global pendaftaran santri.</p>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl font-bold border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                <div class="bg-white rounded-3xl border border-surface-container shadow-sm overflow-hidden">
                    <div class="p-8 space-y-8">
                        <div class="flex items-center justify-between border-b border-surface-container pb-6">
                            <div>
                                <h3 class="font-bold text-primary text-lg">Status Pendaftaran</h3>
                                <p class="text-sm text-on-surface/60">Aktifkan atau nonaktifkan akses form pendaftaran baru.</p>
                            </div>
                            <select name="is_registration_open" class="rounded-xl border-surface-container font-bold text-primary focus:ring-tertiary">
                                <option value="1" {{ ($settings['is_registration_open'] ?? '1') == '1' ? 'selected' : '' }}>DIBUKA</option>
                                <option value="0" {{ ($settings['is_registration_open'] ?? '1') == '0' ? 'selected' : '' }}>DITUTUP</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="font-bold text-primary">Biaya Pendaftaran (Rp)</label>
                            <input type="number" name="registration_fee" value="{{ $settings['registration_fee'] ?? '150000' }}" class="w-full p-4 rounded-2xl border-surface-container focus:ring-tertiary font-bold text-primary" placeholder="Contoh: 150000">
                        </div>

                        <div class="space-y-2">
                            <label class="font-bold text-primary">Tahun Ajaran Aktif</label>
                            <input type="text" name="academic_year" value="{{ $settings['academic_year'] ?? '2026/2027' }}" class="w-full p-4 rounded-2xl border-surface-container focus:ring-tertiary font-bold text-primary" placeholder="Contoh: 2026/2027">
                        </div>

                        <div class="space-y-2">
                            <label class="font-bold text-primary">Nama Ketua Panitia (Untuk TTD Kartu)</label>
                            <input type="text" name="head_of_committee" value="{{ $settings['head_of_committee'] ?? '' }}" class="w-full p-4 rounded-2xl border-surface-container focus:ring-tertiary font-bold text-primary" placeholder="Contoh: Ust. Ahmad Fauzi, M.Pd">
                        </div>
                    </div>
                    <div class="bg-surface-container-low p-6 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-tertiary text-white rounded-xl font-bold shadow-ambient hover:scale-105 transition-transform">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection