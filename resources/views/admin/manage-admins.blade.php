<x-admin-layout>

    <div class="flex-1 p-8 lg:p-12 overflow-y-auto">
        <div class="max-w-6xl mx-auto">
            
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-on-surface/40 hover:text-primary mb-6 inline-flex items-center gap-2">
                &larr; Kembali ke Dashboard Utama
            </a>

            <h1 class="text-3xl font-display font-bold text-primary mb-8">Manajemen Akun Panitia</h1>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl font-bold border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl border border-surface-container shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface/60 text-xs uppercase font-bold tracking-widest">
                            <th class="p-6">Nama & Kontak</th>
                            <th class="p-6 text-center">Status Role</th>
                            <th class="p-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @forelse($users as $user)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="p-6">
                                <p class="font-bold text-primary">{{ $user->name }}</p>
                                <p class="text-sm text-on-surface/60">{{ $user->email }}</p>
                            </td>
                            <td class="p-6 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-surface-container text-on-surface/40' }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="p-6 text-right">
                                <form action="{{ route('admin.toggle.role', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 border-2 border-primary text-primary hover:bg-primary hover:text-white rounded-xl text-xs font-bold transition">
                                        {{ $user->role === 'admin' ? 'Jadikan Santri' : 'Angkat Jadi Admin' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-8 text-center text-on-surface/40 italic">Tidak ada user lain.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-admin-layout>