<!-- Kita hapus penggunaan variabel $url yang menyebabkan eror -->
<!-- Kita gunakan asset() yang sudah pasti aman untuk halaman web -->
<img src="{{ asset('/assets/images/logo-ponpes.png') }}" {{ $attributes }} alt="Logo Daar el-Haq">