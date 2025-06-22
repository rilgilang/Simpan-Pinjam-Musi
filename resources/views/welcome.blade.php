<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Koperasi Simpan Pinjam | Musi Jaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 font-sans antialiased">

    <!-- Header -->
    <header class="bg-black text-white px-6 py-4 flex justify-between items-center">
        <div class="text-xl font-bold">KSMJ TSP-SB</div>
        <nav class="space-x-6 text-sm hidden md:block">
            <a href="#tentang" class="hover:underline">Tentang</a>
            <a href="#" class="hover:underline">Layanan</a>
            <a href='#kontak' class="hover:underline">Kontak</a>
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="bg-white text-black px-4 py-2 rounded-full hover:bg-gray-200 transition">Login</a>
            @endif
        </nav>
    </header>

    <body id="tentang">
    <section class="flex flex-col md:flex-row items-center justify-between px-6 py-16 bg-gray-50">
        <!-- Kiri (Teks) -->
        <div class="md:w-1/2 mb-8 md:mb-0">
            <h1 class="text-4xl font-bold mb-4">Tentang</h1>
            <p class="text-lg text-gray-700 mb-6">Kerjasama Sosial Musi Jaya Tamansiswa Pendawa Sungai Buah merupakan koperasi yang berdiri sejak tahun 1984 dengan tujuan utama meningkatkan kesejahteraan ekonomi dan sosial para anggotanya.</p>
            <p class="text-lg text-gray-700 mb-6">Selama lebih dari 40 tahun, kami telah tumbuh menjadi koperasi yang kuat dan stabil, dengan mengedepankan prinsip keterbukaan, kebersamaan, dan tanggung jawab.</p>
            <p class="text-lg text-gray-700 mb-6">Dengan dukungan seluruh anggota, kami siap menghadapi tantangan masa depan dan terus berinovasi demi kemajuan bersama.</p>
        </div>

        <!-- Kanan (Gambar/Latar) -->
        <div class="md:w-1/2">
            <img src="{{ asset('landing_page.PNG') }}" alt="Ilustrasi Koperasi" class="rounded-xl shadow-lg w-full h-auto">
        </div>
    </section>

    <footer id="kontak">
    <footer class="bg-black text-white py-10 mt-16">
        <div class="max-w-4xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-bold mb-3">Alamat KSP Musi Jaya</h4>
                <p>Jl. Sutan Syahrir Lrg. Masjid Rt.21/5 Ilir, Palembang</p>
                <p>Jl. Prajurit Kemas Ali Rt.29/2 Ilir, Palembang</p>
                <p>No HP: <a href="tel:+6281234567890" class="underline">+62 812-3456-7890</a></p>
                <p>Email: <a href="mailto:musijaya@gmail.com" class="underline">musijaya@gmail.com</a></p>
            </div>
            <div>
                <iframe
                    src="https://maps.app.goo.gl/Yoktnq6Li7BYaeou7?g_st=com.google.maps.preview.copy..."
                    width="100%" height="200" style="border:0;" allowfullscreen=""
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
        <div class="text-center text-sm mt-8 text-gray-400">
            &copy; {{ date('Y') }} KSP Musi Jaya Tamansiswa Pendawa Sei Buah. All rights reserved.
        </div>
    </footer>

</body>
</html>
