<x-admin-layout>

    <div class="flex-1 p-8 lg:p-12 overflow-y-auto">
        <div class="max-w-6xl mx-auto">
            
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
</x-admin-layout>