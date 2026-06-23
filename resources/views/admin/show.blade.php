<x-admin-layout>
    <div class="flex-1 p-8 lg:p-12 overflow-y-auto">
          
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8 border-b border-surface-container pb-6">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-on-surface/40 hover:text-primary mb-2 inline-flex items-center gap-2">
                    &larr; Kembali ke Dashboard
                </a>
                <h1 class="text-3xl font-display font-bold text-primary">Detail Verifikasi</h1>
                <p class="text-on-surface/60">No. Daftar: <span class="font-bold text-primary">{{ $registration->registration_number }}</span></p>
            </div>
            
            <div class="bg-white p-4 rounded-xl border border-surface-container shadow-sm flex items-center gap-4">
                <span class="text-sm font-bold text-on-surface/60">Status Saat Ini:</span>
                @php
                    $isRevision = ($registration->status === 'rejected' && !empty($registration->admin_note));
                    $statusLabelsAdmin = [
                        'pending'  => 'Menunggu Verifikasi Berkas',
                        'paid'     => 'Berkas Valid (Menunggu Pembayaran)',
                        'verified' => 'Pembayaran Lunas',
                        'accepted' => 'Lulus Seleksi Akhir',
                        'rejected' => 'Tidak Lulus / Perlu Revisi'
                    ];
                    $displayLabel = $isRevision ? 'Perlu Revisi Berkas' : ($statusLabelsAdmin[$registration->status] ?? $registration->status);
                @endphp
                <span class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-bold uppercase tracking-widest border border-gray-200">
                    {{ $displayLabel }}
                </span>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                    <h2 class="font-bold text-lg text-gray-800 mb-5">Data Santri Lengkap</h2>
                    
                    <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap & Panggilan</p>
                            <p class="font-bold text-gray-800">{{ $registration->full_name }} <span class="font-normal text-gray-500">({{ $registration->nickname }})</span></p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jenjang</p>
                                <p class="font-bold text-gray-800">{{ $registration->level }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jenis Kelamin</p>
                                <p class="font-bold text-gray-800">{{ $registration->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</p>
                            <p class="font-bold text-gray-800">{{ $registration->place_of_birth }}, {{ \Carbon\Carbon::parse($registration->date_of_birth)->translatedFormat('d F Y') }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Asal Sekolah</p>
                                <p class="font-bold text-gray-800">{{ $registration->previous_school_name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Sekolah</p>
                                <p class="font-bold text-gray-800">{{ $registration->previous_school_address }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">NISN</p>
                                <p class="font-bold text-gray-800">{{ $registration->nisn }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nomor Ijazah</p>
                            <p class="font-bold {{ $registration->nomor_ijazah ? 'text-gray-800' : 'text-red-500 italic text-sm' }}">
                                {{ $registration->nomor_ijazah ?: 'Belum diisi (Opsional)' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Anak Ke</p>
                                <p class="font-bold text-gray-800">{{ $registration->child_order }} dari {{ $registration->siblings_count }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">No. KIP</p>
                                <p class="font-bold text-gray-800">{{ $registration->kip_number ?: '-' }}</p>
                            </div>
                        </div>

                        <hr class="border-dashed border-gray-200 my-4">

                         <h2 class="font-bold text-lg text-gray-800 mb-5">Data Orang Tua / Wali</h2>
                        
                        @if($registration->parentDetail)
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Ayah (Pekerjaan)</p>
                                <p class="font-bold text-gray-800">{{ $registration->parentDetail->father_name }} <span class="font-normal text-gray-500">({{ $registration->parentDetail->father_occupation }})</span></p>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Ibu (Pekerjaan)</p>
                                <p class="font-bold text-gray-800">{{ $registration->parentDetail->mother_name }} <span class="font-normal text-gray-500">({{ $registration->parentDetail->mother_occupation }})</span></p>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">No. WhatsApp Wali</p>
                                <p class="font-bold text-green-700">{{ $registration->parentDetail->father_phone }}</p>
                            </div>

                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Domisili</p>
                                <p class="font-bold text-gray-800 text-sm leading-relaxed">{{ $registration->parentDetail->address }}</p>
                            </div>
                        @else
                            <div class="bg-red-50 text-red-500 text-xs p-3 rounded-lg border border-red-100">
                                Data orang tua belum dilengkapi oleh santri.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-surface-container shadow-sm">
                    <h3 class="font-display font-bold text-primary text-lg mb-4 border-b pb-2">Keputusan Admin</h3>
                    
                    <form action="{{ route('admin.update.status', $registration->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-on-surface/40 uppercase mb-2">Pilih Keputusan</label>
                            <select name="status" id="statusSelect" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                                <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi Berkas</option>
                                <option value="paid" {{ $registration->status == 'paid' ? 'selected' : '' }}>Setujui Berkas (Valid)</option>
                                <option value="rejected" {{ ($registration->status == 'rejected' && !empty($registration->admin_note)) ? 'selected' : '' }} data-type="revision">Revisi Berkas (Tidak Valid)</option>
                                <option value="accepted" {{ $registration->status == 'accepted' ? 'selected' : '' }}>Nyatakan Lulus Seleksi Akhir</option>
                                <option value="rejected" {{ ($registration->status == 'rejected' && empty($registration->admin_note)) ? 'selected' : '' }} data-type="reject_final">Tolak Permanen (Tidak Lulus)</option>
                            </select>
                        </div>

                        <div id="noteContainer" class="mb-6 {{ ($registration->status == 'rejected' && !empty($registration->admin_note)) ? 'block' : 'hidden' }}">
                            <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-r-lg">
                                <label class="block text-xs font-bold text-red-700 uppercase mb-1">Catatan Koreksi Berkas</label>
                                <p class="text-[10px] text-red-600 mb-2 leading-tight">Wajib ditulis agar santri tahu dokumen mana yang wajib diunggah ulang.</p>
                                <textarea name="admin_note" id="adminNoteTextarea" rows="3" class="w-full border-red-300 rounded-lg shadow-sm focus:border-red-500 focus:ring focus:ring-red-500/20 text-sm" placeholder="Contoh: Foto kartu keluarga buram, tolong upload ulang berkas asli...">{{ $registration->admin_note }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-primary text-white font-bold py-3 px-4 rounded-xl hover:bg-primary/90 transition shadow-sm text-sm">
                            Simpan Keputusan
                        </button>
                    </form>
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
                                    
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="absolute inset-0 bg-primary/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('statusSelect');
        const noteContainer = document.getElementById('noteContainer');
        const adminNoteTextarea = document.getElementById('adminNoteTextarea');

        statusSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const dataType = selectedOption.getAttribute('data-type');

            if (this.value === 'rejected' && dataType === 'revision') {
                noteContainer.classList.remove('hidden');
                noteContainer.classList.add('block');
                adminNoteTextarea.setAttribute('required', 'required'); 
            } else {
                noteContainer.classList.remove('block');
                noteContainer.classList.add('hidden');
                adminNoteTextarea.removeAttribute('required');
            }
        });
    });
</script>
</x-admin-layout>