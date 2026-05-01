<?php

namespace App\Mail;

use App\Models\Registration;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengumumanHasilMail extends Mailable
{
    use Queueable, SerializesModels;

    // Tambahkan tipe data di depan nama variabel
    public Registration $registration;
    public string $academicYear;
    public string $headOfCommittee;

    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
        // Mengambil data dinamis dari tabel Setting
        $this->academicYear = Setting::get('academic_year', '2026/2027');
        $this->headOfCommittee = Setting::get('head_of_committee', 'Panitia PSB');
    }
    
    // ... sisa kode di bawahnya tetap sama ...

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update Status Pendaftaran PSB Daar el-Haq',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pengumuman', // Kita akan buat file view ini
        );
    }
}