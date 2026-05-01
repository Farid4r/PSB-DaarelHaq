<nav x-data="{ open: false }" class="bg-[#073216] dark:bg-emerald-950 font-['Manrope'] text-sm font-medium tracking-tight border-b border-emerald-800/30 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/logo-ponpes.png') }}" class="block h-10 w-auto object-contain" alt="Logo Daar el-Haq" />
                        <div class="hidden sm:block text-2xl font-bold text-yellow-500 dark:text-yellow-400 tracking-tighter">
                            Daar el-Haq
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- MENU KHUSUS ADMIN & SUPER ADMIN --}}
                    @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Verifikasi Santri') }}
                        </x-nav-link>
                    @endif

                    {{-- MENU KHUSUS SUPER ADMIN SAJA --}}
                    @if(Auth::user()->role === 'super_admin')
                        <x-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')">
                            {{ __('Pengaturan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.manage.admins')" :active="request()->routeIs('admin.manage.admins')">
                            {{ __('Kelola Admin') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-emerald-50/80 hover:text-white hover:bg-emerald-800/40 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }} <span class="text-[10px] bg-emerald-700 px-2 py-0.5 rounded ml-1 uppercase">{{ Auth::user()->role }}</span></div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-emerald-50 hover:text-white hover:bg-emerald-800/40 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#052611] dark:bg-emerald-900 border-t border-emerald-800/30">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- MENU KHUSUS ADMIN & SUPER ADMIN (MOBILE) --}}
            @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Verifikasi Santri') }}
                </x-responsive-nav-link>
            @endif

            {{-- MENU KHUSUS SUPER ADMIN SAJA (MOBILE) --}}
            @if(Auth::user()->role === 'super_admin')
                <x-responsive-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')">
                    {{ __('Pengaturan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.manage.admins')" :active="request()->routeIs('admin.manage.admins')">
                    {{ __('Kelola Admin') }}
                </x-responsive-nav-link>
            @endif
        </div>
        
        <!-- User Info & Logout (Mobile) -->
        <div class="pt-4 pb-1 border-t border-emerald-800/30">
            <div class="px-4">
                <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-bold text-[10px] text-yellow-400 uppercase ">{{ Auth::user()->role }}</div>
                <div class="font-bold text-sm text-emerald-50/70">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>