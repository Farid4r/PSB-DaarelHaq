<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Panel' }} - Daar el-Haq</title>
    
    {{-- Link Ikon & Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Manrope:wght@600;700;900&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: false }">
    
    <div class="flex min-h-screen relative">
        
        {{-- OVERLAY: Muncul hanya di HP saat sidebar terbuka --}}
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-black/50 z-40 md:hidden transition-opacity"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        {{-- SIDEBAR: Responsif --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
               class="fixed md:sticky top-0 left-0 w-64 h-screen bg-[#001b09] dark:bg-emerald-950 overflow-y-auto text-white z-50 transition-transform duration-300 ease-in-out border-r border-white/10">
            @include('layouts.admin-sidebar')
        </aside>

        {{-- AREA KONTEN UTAMA --}}
        <div class="flex-1 flex flex-col min-w-0">
            
            {{-- NAVBAR ATAS RESPONSIF --}}
            <header class="bg-[#073216] dark:bg-emerald-950 h-16 flex items-center justify-between px-4 md:px-8 border-b border-gray-200 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    {{-- TOMBOL HAMBURGER (Hanya muncul di HP) --}}
                    <button @click="sidebarOpen = true" class="md:hidden text-gray-100 p-2 hover:bg-gray-100 rounded-lg">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="font-bold text-green-100 hidden md:block">Selamat Datang, {{ Auth::user()->name }}</h2>
                </div>
                
                {{-- INFO USER & LOGOUT --}}
                <div class="flex items-center gap-4">
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded font-bold uppercase">{{ Auth::user()->role }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded-lg transition" title="Log Out">
                            <span class="material-symbols-outlined">logout</span>
                        </button>
                    </form>
                </div>
            </header>

            {{-- ISI KONTEN --}}
            <main class="p-4 md:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>