<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Pendaftaran - {{ $registration->registration_number }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        /* Kop Surat */
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #065F46; /* Emerald-800 */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h1 {
            margin: 0;
            font-size: 22px;
            color: #065F46;
            text-transform: uppercase;
        }
        .kop-surat h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #92400E; /* Gold/Amber */
        }
        .kop-surat p {
            margin: 2px 0;
            font-size: 11px;
        }
        .garis-ganda {
            border-top: 1px solid #065F46;
            margin-top: 2px;
            margin-bottom: 20px;
        }
        /* Judul Kartu */
        .judul-kartu {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
        }
        .nomor-daftar {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #b45309;
            margin-bottom: 30px;
        }
        /* Tabel Data */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .td-label {
            width: 25%;
            font-weight: bold;
            padding: 6px 0;
            vertical-align: top;
        }
        .td-titik {
            width: 5%;
            padding: 6px 0;
            vertical-align: top;
        }
        .td-isi {
            width: 45%;
            padding: 6px 0;
            vertical-align: top;
            text-transform: capitalize;
        }
        /* Area Foto */
        .td-foto {
            width: 25%;
            text-align: right;
            vertical-align: top;
        }
        .kotak-foto {
            width: 113px; /* Ukuran pas foto 3x4 */
            height: 151px;
            border: 2px solid #065F46;
            padding: 3px;
            float: right;
        }
        .kotak-foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        /* Footer / TTD */
        .footer-ttd {
            margin-top: 50px;
            width: 100%;
        }
        .ttd-box {
            width: 40%;
            float: right;
            text-align: center;
        }
    </style>
</head>
<body>

<table style="width: 100%; border-bottom: 3px solid #065F46; padding-bottom: 10px; margin-bottom: 2px;">
        <tr>
            <td style="width: 15%; text-align: left; vertical-align: middle;">
                <!-- UBAH: Cek langsung isi variabelnya, tidak perlu menggunakan file_exists -->
                @if($logoPath)
                    <img src="{{ $logoPath }}" style="width: 80px; height: auto;">
                @else
                    <div style="width: 70px; height: 70px; background-color: #eee; border: 1px solid #ccc; line-height: 70px; text-align: center; font-size: 10px;">
                        LOGO
                    </div>
                @endif
            </td>
            
            <td style="width: 85%; text-align: center; vertical-align: middle;">
                <h1 style="margin: 0; font-size: 22px; color: #065F46; text-transform: uppercase;">
                    Pondok Pesantren Daar El Haq
                </h1>
                <h2 style="margin: 5px 0; font-size: 16px; color: #92400E;">
                    Panitia Penerimaan Santri Baru (PSB) Tahun Ajaran {{ $academicYear }}
                </h2>
                <p style="margin: 2px 0; font-size: 11px;">
                    Jl. Maulana Hasanudin. Kp. Ojar RT.02 / 01 Desa Cilangkap Kecamatan Kalanganyar Kabupaten Lebak Provinsi Banten
                </p>
                <p style="margin: 2px 0; font-size: 11px;">
                    Website: www.daarelhaq.sch.id | Email: info@daarelhaq.sch.id | Telp: (021) 1234567
                </p>
            </td>
        </tr>
    </table>

    <div class="garis-ganda"></div>

    <div class="judul-kartu">KARTU TANDA PENDAFTARAN SANTRI</div>
    <div class="nomor-daftar">NO: {{ $registration->registration_number }}</div>

    <table>
        <tr>
            <td class="td-label">Nama Lengkap</td>
            <td class="td-titik">:</td>
            <td class="td-isi"><strong>{{ $registration->full_name ?? $user->name }}</strong></td>
            <td rowspan="8" class="td-foto">
                <div class="kotak-foto">
                    <!-- UBAH: Cek langsung variabel fotoPath tanpa file_exists -->
                    @if($fotoPath)
                        <img src="{{ $fotoPath }}" alt="Pas Foto">
                    @else
                        <div style="text-align:center; padding-top:60px; color:#aaa;">3 x 4</div>
                    @endif
                </div>
            </td>
        </tr>
        <tr>
            <td class="td-label">Jenjang Pilihan</td>
            <td class="td-titik">:</td>
            <td class="td-isi">{{ $registration->level }}</td>
        </tr>
        <tr>
            <td class="td-label">Tempat, Tgl Lahir</td>
            <td class="td-titik">:</td>
            <td class="td-isi">{{ $registration->place_of_birth }}, {{ \Carbon\Carbon::parse($registration->date_of_birth)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="td-label">Jenis Kelamin</td>
            <td class="td-titik">:</td>
            <td class="td-isi">{{ $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td class="td-label">Asal Sekolah</td>
            <td class="td-titik">:</td>
            <td class="td-isi">{{ $registration->previous_school_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">NISN</td>
            <td class="td-titik">:</td>
            <td class="td-isi">{{ $registration->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">Nama Wali / Ayah</td>
            <td class="td-titik">:</td>
            <td class="td-isi">{{ $registration->parentDetail->father_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">Nomor Kontak (WA)</td>
            <td class="td-titik">:</td>
            <td class="td-isi">{{ $user->phone }}</td>
        </tr>
    </table>

    <div style="margin-top: 40px; background-color: #f0fdf4; border: 1px dashed #065F46; padding: 15px;">
        <strong>Catatan Penting:</strong>
        <ol style="margin-top: 5px; margin-bottom: 0; padding-left: 20px;">
            <li>Kartu ini wajib dibawa saat pelaksanaan tes seleksi masuk / wawancara.</li>
            <li>Harap hadir 30 menit sebelum jadwal tes yang ditentukan.</li>
            <li>Segala informasi kelulusan akan diumumkan melalui Dashboard website resmi.</li>
        </ol>
    </div>

    <div class="footer-ttd">
        <div class="ttd-box">
            <p>Diterbitkan pada: {{ $tanggalCetak }}</p>
            <p>Panitia PSB Daar el-Haq,</p>
            <br><br><br><br>
            <p style="text-decoration: underline; font-weight: bold;">{{ $headOfCommittee }}</p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>