<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{-- Memanggil logo pesantren yang ada di folder public --}}
<img src="{{ asset('assets/images/logo-b&w.png') }}" class="logo" alt="{{ config('app.name') }}" style="width: 80px;">
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
Jl. Maulana Hasanudin, Kalanganyar Lebak-Banten
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>