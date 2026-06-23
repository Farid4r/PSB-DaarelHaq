<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Tambahan agar lebar kolom Excel rapi otomatis

class RegistrationsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        // Ambil data santri yang minimal sudah bayar/lunas
        return Registration::with(['user', 'parentDetail'])
                ->whereIn('status', ['paid', 'verified', 'accepted'])
                ->get();
    }

    public function headings(): array
    {
        return [
            'No. Pendaftaran',
            'Nama Lengkap',
            'Panggilan', // Tambahan
            'Jenjang',
            'Tempat, Tanggal Lahir',
            'Jenis Kelamin',
            'Anak Ke', // Tambahan
            'Jml Saudara', // Tambahan
            'Asal Sekolah',
            'NISN',
            'Nomor Ijazah',//Tambahan baru
            'No. KIP', // Tambahan
            'No. WhatsApp',
            'Nama Ayah',
            'Pekerjaan Ayah', // Tambahan
            'Nama Ibu',
            'Pekerjaan Ibu', // Tambahan
            'Alamat Domisili', // Tambahan
            'Status Kelulusan',
            'Tanggal Daftar' // Tambahan
        ];
    }

    public function map($registration): array
    {
        return [
            $registration->registration_number,
            $registration->full_name ?? $registration->user->name,
            $registration->nickname ?? '-',
            $registration->level,
            $registration->place_of_birth . ', ' . $registration->date_of_birth,
            $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            $registration->child_order ?? '-',
            $registration->siblings_count ?? '-',
            $registration->previous_school_name ?? '-',
            $registration->nisn ?? '-',
            $registration->nomor_ijazah ?? '-',//tambahan baru
            $registration->kip_number ?? '-',
            $registration->user->phone ?? '-',
            
            // Menggunakan tanda "?->" (Null-safe operator) untuk mencegah error jika data ortu belum lengkap
            $registration->parentDetail?->father_name ?? '-',
            $registration->parentDetail?->father_occupation ?? '-',
            $registration->parentDetail?->mother_name ?? '-',
            $registration->parentDetail?->mother_occupation ?? '-',
            $registration->parentDetail?->address ?? '-',
            
            strtoupper($registration->status),
            $registration->created_at ? $registration->created_at->format('d/m/Y H:i') : '-'
        ];
    }
}