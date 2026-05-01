<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - PSB Daar el-Haq</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@500;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans text-on-surface min-h-screen flex items-center justify-center p-4 relative overflow-hidden antialiased">

    <div class="absolute top-0 left-0 w-full h-96 bg-primary/95 -skew-y-6 transform origin-top-left -z-10 shadow-ambient"></div>
    <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-tertiary/15 rounded-full blur-3xl -z-10"></div>

    <div class="w-full max-w-md bg-surface-container-lowest rounded-2xl shadow-ambient overflow-hidden relative z-10 border border-surface-container">
        
        <div class="px-8 pt-10 pb-6 text-center">
            
            <div class="w-24 h-24 mx-auto mb-4 bg-surface-container-low rounded-full shadow-inner flex items-center justify-center p-2 border border-surface-container">
                <img src="{{ asset('assets/images/logo-ponpes.png') }}" 
                     alt="Logo Daar el-Haq" 
                     class="w-full h-full object-contain"
                     onerror="this.outerHTML='<span class=\'text-3xl font-display font-bold text-primary\'>DH</span>'"> 
            </div>
            
            <h2 class="text-2xl font-display font-bold text-on-surface">Selamat Datang</h2>
            <p class="text-sm text-on-surface/70 mt-2">Masuk ke Portal PSB Daar el-Haq</p>
        </div>

        <div class="px-8 pb-10">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-primary-container bg-primary/10 p-3 rounded-lg border border-primary-container/30">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-on-surface/80 mb-1">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="w-full px-4 py-3 rounded-xl border @error('email'border-red-600 @else border-surface-container @enderror focus:ring-2 focus:ring-primary-container focus:border-primary-container transition-colors outline-none bg-surface-container-low focus:bg-surface-container-lowest"
                        placeholder="contoh@email.com">
                    
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-medium text-on-surface/80">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-secondary hover:text-tertiary transition-colors">Lupa sandi?</a>
                        @endif
                    </div>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-xl border @error('password')border-red-600 @else border-surface-container @enderror focus:ring-2 focus:ring-primary-container focus:border-primary-container transition-colors outline-none bg-surface-container-low focus:bg-surface-container-lowest"
                        placeholder="••••••••">
                    
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center mt-4">
                    <input id="remember_me" type="checkbox" name="remember" 
                        class="w-4 h-4 text-primary bg-surface-container border-surface-container rounded focus:ring-primary-container focus:ring-2">
                    <label for="remember_me" class="ml-2 text-sm text-on-surface/80 cursor-pointer">Ingat saya</label>
                </div>

                <button type="submit" 
                    class="w-full bg-primary hover:bg-primary/90 text-white font-display font-bold tracking-wide py-3.5 px-4 rounded-xl shadow-ambient hover:shadow-lg transition-all duration-300 mt-6 flex justify-center items-center gap-2">
                    Masuk
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>

            @if (Route::has('register'))
                <div class="mt-8 pt-6 border-t border-surface-container text-center">
                    <p class="text-sm text-on-surface/70">
                        Belum mendaftar sebagai santri baru? 
                        <a href="{{ route('register') }}" class="font-bold text-secondary hover:text-tertiary transition-colors">Buat Akun</a>
                    </p>
                </div>
            @endif
        </div>
    </div>

</body>
</html>