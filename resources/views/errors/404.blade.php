<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 – Halaman Tidak Ditemukan | Saung Angklung Udjo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Spirax&family=Inter:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#F7F7F2] flex items-center justify-center px-6">

    <div class="text-center">

        {{-- Logo --}}
        <img src="{{ asset('images/UdjoFullColor.png') }}" alt="Saung Angklung Udjo" class="mx-auto mb-6 w-14 opacity-60">

        {{-- 404 --}}
        <p class="font-['Spirax'] text-8xl text-indigo-950 mb-2">404</p>

        <h1 class="text-2xl font-semibold text-indigo-950 mb-3">
            Halaman Tidak Ditemukan
        </h1>

        <p class="text-gray-500 text-sm font-light mb-10 max-w-sm mx-auto leading-relaxed">
            Halaman yang kamu cari mungkin telah dipindahkan atau tidak tersedia.
        </p>

        <a href="{{ route('home') }}"
           class="inline-block bg-indigo-950 text-white px-10 py-4
                  text-[11px] font-bold uppercase tracking-widest
                  hover:bg-[#c4a47c] hover:text-indigo-950 transition-all duration-300">
            Kembali ke Beranda
        </a>

    </div>

</body>
</html>
