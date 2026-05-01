<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - PSB Daar el-Haq</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@500;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans text-on-surface min-h-screen flex items-center justify-center p-4 relative overflow-hidden antialiased">

    <div class="absolute top-0 left-0 w-full h-96 bg-primary/95 -skew-y-6 transform origin-top-left -z-10 shadow-ambient"></div>
    <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-tertiary/15 rounded-full blur-3xl -z-10"></div>

    <div class="w-full max-w-lg bg-surface-container-lowest rounded-2xl shadow-ambient overflow-hidden relative z-10 border border-surface-container my-8">
        
        <div class="px-8 pt-10 pb-4 text-center">
            <div class="w-20 h-20 mx-auto mb-4 bg-surface-container-low rounded-full shadow-inner flex items-center justify-center p-2 border border-surface-container">
                <img src="{{ asset('assets/images/logo-ponpes.png') }}" 
                     alt="Logo Daar el-Haq" 
                     class="w-full h-full object-contain"
                     onerror="this.outerHTML='<span class=\'text-2xl font-display font-bold text-primary\'>DH</span>'"> 
            </div>
            
            <h2 class="text-2xl font-display font-bold text-on-surface">Buat Akun Baru</h2>
            <p class="text-sm text-on-surface/70 mt-2">Lengkapi data di bawah untuk memulai pendaftaran</p>
        </div>

        <div class="px-8 pb-10">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-on-surface/80 mb-1">Nama Lengkap Santri / Wali</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="w-full px-4 py-3 rounded-xl border @error('name') border-red-500 @else border-surface-container @enderror focus:ring-2 focus:ring-primary-container focus:border-primary-container transition-colors outline-none bg-surface-container-low focus:bg-surface-container-lowest"
                        placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-on-surface/80 mb-1">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="w-full px-4 py-3 rounded-xl border @error('email') border-red-500 @else border-surface-container @enderror focus:ring-2 focus:ring-primary-container focus:border-primary-container transition-colors outline-none bg-surface-container-low focus:bg-surface-container-lowest"
                        placeholder="contoh@email.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-on-surface/80 mb-1">Nomor HP (WhatsApp)</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                        class="w-full px-4 py-3 rounded-xl border @error('phone') border-red-500 @else border-surface-container @enderror focus:ring-2 focus:ring-primary-container focus:border-primary-container transition-colors outline-none bg-surface-container-low focus:bg-surface-container-lowest"
                        placeholder="Contoh: 081234567890">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-on-surface/80 mb-1">Kata Sandi</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                            class="w-full px-4 py-3 rounded-xl border @error('password') border-red-500 @else border-surface-container @enderror focus:ring-2 focus:ring-primary-container focus:border-primary-container transition-colors outline-none bg-surface-container-low focus:bg-surface-container-lowest"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-on-surface/80 mb-1">Konfirmasi Sandi</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                            class="w-full px-4 py-3 rounded-xl border @error('password_confirmation') border-red-500 @else border-surface-container @enderror focus:ring-2 focus:ring-primary-container focus:border-primary-container transition-colors outline-none bg-surface-container-low focus:bg-surface-container-lowest"
                            placeholder="Ulangi kata sandi">
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-primary hover:bg-primary/90 text-white font-display font-bold tracking-wide py-3.5 px-4 rounded-xl shadow-ambient hover:shadow-lg transition-all duration-300 mt-6 flex justify-center items-center gap-2">
                    Daftar Akun
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-surface-container text-center">
                <p class="text-sm text-on-surface/70">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-bold text-secondary hover:text-tertiary transition-colors">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>