<!DOCTYPE html>
<html>
<head>
    <style>
        .container { font-family: sans-serif; padding: 20px; color: #333; }
        .badge { padding: 10px; border-radius: 5px; font-weight: bold; color: white; }
        .success { background-color: #059669; }
        .danger { background-color: #dc2626; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Assalamu'alaikum, {{ $registration->full_name ?? $registration->user->name }}</h2>
        <p>Kami menginformasikan hasil seleksi pendaftaran santri baru untuk <strong>Tahun Ajaran {{ $academicYear }}</strong>.</p>
        
        <p>Status pendaftaran Anda saat ini adalah:</p>
        
        @if($registration->status == 'accepted')
            <div class="badge success">SELAMAT! ANDA DINYATAKAN LULUS</div>
            <p>Silakan login ke dashboard untuk langkah pendaftaran ulang.</p>
        @else
            <div class="badge danger">MOHON MAAF, ANDA BELUM LULUS</div>
            <p>Tetap semangat dan jangan menyerah.</p>
        @endif

        <p>Terima kasih,<br><strong>{{ $headOfCommittee }}</strong></p>
    </div>
</body>
</html>