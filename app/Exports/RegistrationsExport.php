<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegistrationsExport implements FromCollection, WithHeadings, WithMapping
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
            'Jenjang',
            'Tempat, Tanggal Lahir',
            'Jenis Kelamin',
            'Asal Sekolah',
            'NISN',
            'No. WhatsApp',
            'Nama Ayah',
            'Nama Ibu',
            'Status Kelulusan'
        ];
    }

    public function map($registration): array
    {
        return [
            $registration->registration_number,
            $registration->full_name ?? $registration->user->name,
            $registration->level,
            $registration->place_of_birth . ', ' . $registration->date_of_birth,
            $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            $registration->previous_school_name ?? '-',
            $registration->nisn ?? '-',
            $registration->user->phone ?? '-',
            $registration->parentDetail->father_name ?? '-',
            $registration->parentDetail->mother_name ?? '-',
            strtoupper($registration->status)
        ];
    }
}