{{-- Sidebar Container dengan warna hijau tua --}}
<div class="flex flex-col h-full p-6 bg-[#073216] text-white">
    
    {{-- Header Sidebar --}}
    <div class="flex items-center justify-between mb-10 border-b border-white/20 pb-4">
        <h2 class="font-['Manrope'] font-bold text-xl text-yellow-500 tracking-tight">Panel Admin</h2>
        
        {{-- TOMBOL CLOSE (Muncul hanya di Mobile melalui Alpine.js) --}}
        <button @click="sidebarOpen = false" class="md:hidden text-white/70 hover:text-white transition">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    
    {{-- Navigasi Menu --}}
    <ul class="space-y-2 overflow-y-auto flex-1 custom-scrollbar">
        
        {{-- MENU UTAMA --}}
        <li>
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 font-bold text-yellow-400 shadow-sm' : 'text-emerald-50/80 hover:bg-white/10 hover:text-white' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm">Dashboard Utama</span>
            </a>
        </li>
        
        {{-- MENU MANAJEMEN KONTEN (Admin & Super Admin) --}}
        @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
            <li class="pt-6 pb-2">
                <p class="text-[10px] font-bold text-white/40 uppercase px-4 tracking-widest">Manajemen Konten</p>
            </li>

            <li>
                <a href="{{ route('admin.posts.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.posts.*') ? 'bg-white/20 font-bold text-yellow-400' : 'text-emerald-50/80 hover:bg-white/10 hover:text-white' }}">
                    <span class="material-symbols-outlined">newspaper</span>
                    <span class="text-sm">Berita & Kegiatan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.galleries.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.galleries.*') ? 'bg-white/20 font-bold text-yellow-400' : 'text-emerald-50/80 hover:bg-white/10 hover:text-white' }}">
                    <span class="material-symbols-outlined">photo_library</span>
                    <span class="text-sm">Galeri Foto</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.profil.edit') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.profil.edit') ? 'bg-white/20 font-bold text-yellow-400' : 'text-emerald-50/80 hover:bg-white/10 hover:text-white' }}">
                    <span class="material-symbols-outlined">account_balance</span>
                    <span class="text-sm">Profil Pondok</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.leaders.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.leaders.*') ? 'bg-white/20 font-bold text-yellow-400' : 'text-emerald-50/80 hover:bg-white/10 hover:text-white' }}">
                    <span class="material-symbols-outlined">groups</span>
                    <span class="text-sm">Pimpinan</span>
                </a>
            </li>
        @endif

        {{-- MENU KHUSUS SUPER ADMIN --}}
        @if(Auth::user()->role === 'super_admin')
            <li class="pt-6 pb-2">
                <p class="text-[10px] font-bold text-white/40 uppercase px-4 tracking-widest">Sistem & Akses</p>
            </li>

            <li>
                <a href="{{ route('admin.settings') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.settings') ? 'bg-white/20 font-bold text-yellow-400' : 'text-emerald-50/80 hover:bg-white/10 hover:text-white' }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="text-sm">Pengaturan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.manage.admins') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.manage.admins') ? 'bg-white/20 font-bold text-yellow-400' : 'text-emerald-50/80 hover:bg-white/10 hover:text-white' }}">
                    <span class="material-symbols-outlined">manage_accounts</span>
                    <span class="text-sm">Kelola Admin</span>
                </a>
            </li>
        @endif

    </ul>
</div>

<style>
    /* Merapikan scrollbar sidebar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
</style>