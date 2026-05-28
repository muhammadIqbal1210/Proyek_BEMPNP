<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Pengumuman Resmi - BEM KM PNP' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
    html,
    body {
        overflow-x: hidden;
        min-width: 100%;
    }

    body {
        font-family: 'Inter', sans-serif;
        margin: 0;
    }

    /* Helper class for line clamping */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    html {
        scroll-padding-top: 5rem;
    }

    main {
        overflow-x: hidden;
    }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 overflow-x-hidden">

    <!-- Navbar -->
    <nav class="sticky bg-green-700/70 backdrop-blur-sm top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <img src="<?= base_url('bem.png') ?>" alt="Logo BEM PNP" class="h-10 w-10 object-contain">
                <div class="flex flex-col leading-none">
                    <span class="font-bold text-white">BEM KM</span>
                    <span class="text-xs text-gray-200">Politeknik Negeri Padang</span>
                </div>
            </div>
            <button id="mobileNavToggle" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-white hover:bg-green-600/80 focus:outline-none focus:ring-2 focus:ring-white">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="hidden md:flex gap-6 list-none font-semibold text-white items-center m-0 p-0">
                <li>
                    <a href="<?= base_url('/') ?>"
                        class="<?= url_is('/') ? 'text-orange-400 border-b-2 border-orange-400' : 'hover:text-orange-400' ?> pb-1 transition-all duration-300">
                        Home
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('pengumuman') ?>"
                        class="<?= url_is('pengumuman*') ? 'text-orange-400 border-b-2 border-orange-400' : 'hover:text-orange-400' ?> pb-1 transition-all duration-300">
                        Pengumuman
                    </a>
                </li>

                <li
                    class="menu-item menu-item-has-children <?= url_is('profil*') ? 'current-menu-item' : '' ?> group relative">
                    <a href="#"
                        class="flex items-center gap-1 <?= url_is('profil*') ? 'text-orange-400' : 'hover:text-orange-400' ?> transition-all duration-300">
                        <span class="nav-drop-title-wrap">Profil</span>
                        <svg aria-hidden="true" class="w-4 h-4 fill-current transition-transform group-hover:rotate-180"
                            viewBox="0 0 24 24">
                            <path
                                d="M5.293 9.707l6 6c0.391 0.391 1.024 0.391 1.414 0l6-6c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z">
                            </path>
                        </svg>
                    </a>

                    <ul
                        class="sub-menu absolute hidden group-hover:block bg-white shadow-xl rounded-lg py-2 min-w-[200px] z-50 border border-gray-100 top-full">
                        <li class="menu-item px-4 py-2 hover:bg-orange-50">
                            <a href="<?= base_url('profil') ?>"
                                class="block text-gray-700 hover:text-orange-500">Tentang Kami</a>
                        </li>

                        <li class="menu-item menu-item-has-children relative group/sub px-4 py-2 hover:bg-orange-50">
                            <a href="<?= base_url('struktur') ?>" class="flex justify-between items-center text-gray-700 hover:text-orange-500">
                                <span>Struktur</span>
                                <svg class="w-4 h-4 -rotate-90" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M5.293 9.707l6 6c0.391 0.391 1.024 0.391 1.414 0l6-6c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z">
                                    </path>
                                </svg>
                            </a>

                            <ul
                                class="absolute hidden group-hover/sub:block left-full top-0 bg-white shadow-xl rounded-lg py-2 min-w-[220px] border border-gray-100">

                                <li><a href="<?= base_url('struktur') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Semua</a>
                                </li>
                                <li><a href="<?= base_url('struktur?kementerian=kepresidenan') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Kepresidenan</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=audit_internal') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Audit
                                        Internal</a></li>

                                <li><a href="<?= base_url('struktur?kementerian=kesekretariatan') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Kesekretariatan</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=keuangan') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Keuangan</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=psdm') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">PSDM</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=adkesma') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Adkesma</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=sosmas') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Sosmas</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=dagri') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Dagri</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=mitbis') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Mitbis</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=lugri') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Lugri</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=kastrat') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Kastrat</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=komris') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Komris</a>
                                </li>

                                <li><a href="<?= base_url('struktur?kementerian=pp') ?>"
                                        class="block px-5 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">Pemberdayaan
                                        Perempuan (PP)</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="<?= base_url('berita') ?>"
                        class="<?= url_is('berita*') ? 'text-orange-400 border-b-2 border-orange-400' : 'hover:text-orange-400' ?> pb-1 transition-all duration-300">
                        Berita
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('layanan') ?>"
                        class="<?= url_is('layanan*') ? 'text-orange-400 border-b-2 border-orange-400' : 'hover:text-orange-400' ?> pb-1 transition-all duration-300">
                        Layanan
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('katalog') ?>"
                        class="<?= url_is('katalog*') ? 'text-orange-400 border-b-2 border-orange-400' : 'hover:text-orange-400' ?> pb-1 transition-all duration-300">
                        Katalog
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('kontak') ?>"
                        class="<?= url_is('kontak*') ? 'text-orange-400 border-b-2 border-orange-400' : 'hover:text-orange-400' ?> pb-1 transition-all duration-300">
                        Kontak
                    </a>
                </li>

                <li>
                    <?php if (session()->get('isLoggedIn')): ?>
                        <a href="<?= base_url(session()->get('role') === 'admin' ? 'admin/dashboard' : 'member/dashboard') ?>"
                            class="bg-orange-500 hover:bg-orange-400 text-white font-semibold px-6 pt-1 pb-2 rounded-full transition shadow-md">
                            Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>"
                            class="bg-orange-500 hover:bg-orange-400 text-white font-semibold px-6 pt-1 pb-2 rounded-full transition shadow-md">
                            Login
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        <div id="mobileNavMenu" class="absolute left-0 right-0 top-full hidden md:hidden border-t border-green-600 bg-green-700/95 shadow-xl">
            <div class="max-w-7xl mx-auto px-6 py-4 space-y-2 text-white font-semibold">
                <a href="<?= base_url('/') ?>" class="block rounded-xl px-4 py-3 hover:bg-green-600/80 transition">
                    Home
                </a>
                <a href="<?= base_url('pengumuman') ?>" class="block rounded-xl px-4 py-3 hover:bg-green-600/80 transition">
                    Pengumuman
                </a>
                <div class="space-y-1 rounded-xl border border-green-600 bg-green-800/80">
                    <button id="mobileProfilToggle" type="button" class="w-full text-left px-4 py-3 flex items-center justify-between hover:bg-green-600/80 transition">
                        <span>Profil</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="mobileProfilMenu" class="hidden space-y-1 px-4 pb-3">
                        <a href="<?= base_url('profil') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Tentang Kami</a>
                        <a href="<?= base_url('struktur') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Struktur</a>
                        <a href="<?= base_url('struktur?kementerian=kepresidenan') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Kepresidenan</a>
                        <a href="<?= base_url('struktur?kementerian=audit_internal') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Audit Internal</a>
                        <a href="<?= base_url('struktur?kementerian=kesekretariatan') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Kesekretariatan</a>
                        <a href="<?= base_url('struktur?kementerian=keuangan') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Keuangan</a>
                        <a href="<?= base_url('struktur?kementerian=psdm') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">PSDM</a>
                        <a href="<?= base_url('struktur?kementerian=adkesma') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Adkesma</a>
                        <a href="<?= base_url('struktur?kementerian=sosmas') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Sosmas</a>
                        <a href="<?= base_url('struktur?kementerian=dagri') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Dagri</a>
                        <a href="<?= base_url('struktur?kementerian=mitbis') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Mitbis</a>
                        <a href="<?= base_url('struktur?kementerian=lugri') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Lugri</a>
                        <a href="<?= base_url('struktur?kementerian=kastrat') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Kastrat</a>
                        <a href="<?= base_url('struktur?kementerian=komris') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Komris</a>
                        <a href="<?= base_url('struktur?kementerian=pp') ?>" class="block rounded-lg px-3 py-2 hover:bg-green-600/80 transition">Pemberdayaan Perempuan (PP)</a>
                    </div>
                </div>
                <a href="<?= base_url('berita') ?>" class="block rounded-xl px-4 py-3 hover:bg-green-600/80 transition">
                    Berita
                </a>
                <a href="<?= base_url('layanan') ?>" class="block rounded-xl px-4 py-3 hover:bg-green-600/80 transition">
                    Layanan
                </a>
                <a href="<?= base_url('katalog') ?>" class="block rounded-xl px-4 py-3 hover:bg-green-600/80 transition">
                    Katalog
                </a>
                <a href="<?= base_url('kontak') ?>" class="block rounded-xl px-4 py-3 hover:bg-green-600/80 transition">
                    Kontak
                </a>
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url(session()->get('role') === 'admin' ? 'admin/dashboard' : 'member/dashboard') ?>" class="block rounded-xl px-4 py-3 bg-orange-500 text-white text-center font-semibold hover:bg-orange-400 transition">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="block rounded-xl px-4 py-3 bg-orange-500 text-white text-center font-semibold hover:bg-orange-400 transition">
                        Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="pt-2 md:pt-4">
        <?= $this->renderSection('content') ?>
    </main>
    <!-- Footer -->
     <footer class="bg-gray-900 text-gray-400 py-12 mt-12 border-t-4 border-orange-500">
        <!-- Kontainer Utama -->
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">
            
            <!-- Kolom 1: Profil BEM -->
            <div class="space-y-4">
                <h3 class="font-bold text-2xl text-white tracking-wide border-b-2 border-orange-500 pb-2 inline-block">
                    BEM PNP
                </h3>
                <p class="text-sm leading-relaxed">
                    Badan Eksekutif Mahasiswa Politeknik Negeri Padang.<br>
                    <span class="italic text-orange-400 font-medium">"Berdampak, bergerak, bermanfaat"</span>
                </p>
            </div>

            <!-- Kolom 2: Navigasi -->
            <div class="space-y-4">
                <h3 class="font-bold text-xl text-white tracking-wide border-b-2 border-orange-500 pb-2 inline-block">
                    Navigasi
                </h3>
                <ul class="grid grid-cols-2 gap-2 text-sm">
                    <li><a href="<?= base_url() ?>" class="hover:text-orange-400 transition-colors duration-200">Home</a></li>
                    <li><a href="<?= base_url('pengumuman') ?>" class="hover:text-orange-400 transition-colors duration-200">Pengumuman</a></li>
                    <li><a href="<?= base_url('profil') ?>" class="hover:text-orange-400 transition-colors duration-200">Profil</a></li>
                    <li><a href="<?= base_url('layanan') ?>" class="hover:text-orange-400 transition-colors duration-200">Layanan</a></li>
                    <li><a href="<?= base_url('berita') ?>" class="hover:text-orange-400 transition-colors duration-200">Berita</a></li>
                    <li><a href="<?= base_url('kontak') ?>" class="hover:text-orange-400 transition-colors duration-200">Kontak</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kontak -->
            <div class="space-y-4">
                <h3 class="font-bold text-xl text-white tracking-wide border-b-2 border-orange-500 pb-2 inline-block">
                    Kontak
                </h3>
                <p class="text-sm leading-relaxed">
                    Belakang Gedung PKM Lt 2 Kampus Politeknik Negeri Padang, Limau Manis, Kecamatan Pauh, Kota Padang, 25164, Provinsi Sumatera Barat
                </p>
                <div class="pt-2 text-sm space-y-1 text-gray-300">
                    <p><span class="text-orange-400 font-semibold">Email:</span> bem@pnp.ac.id</p>
                    <p><span class="text-orange-400 font-semibold">Instagram:</span> @bemkmpnp</p>
                </div>
            </div>
        </div>

        <!-- Area Google Maps (Responsif) -->
        <div class="max-w-6xl mx-auto px-6 mt-10">
            <div class="w-full overflow-hidden rounded-xl shadow-lg border border-gray-800">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1109.8832084808494!2d100.46593682922463!3d-0.9130307421905041!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b7bebfb55129%3A0xb6bd64e88c833b4a!2sGedung%20D%20%2F%20Gedung%20PKM%20Politeknik%20Negeri%20Padang!5e1!3m2!1sid!2sid!4v1779976411237!5m2!1sid!2sid" 
                    class="w-full h-64 border-0"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe >
            </div>
        </div>

        <!-- Garis Pembatas Atas Copyright -->
        <div class="max-w-6xl mx-auto px-6 mt-10 pt-6 border-t border-gray-800 text-center text-gray-500 text-xs tracking-wider">
            © 2025 BEM POLITEKNIK NEGERI PADANG. All Rights Reserved.
        </div>
    </footer>

    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        const mobileNavToggle = document.getElementById('mobileNavToggle');
        const mobileNavMenu = document.getElementById('mobileNavMenu');
        const mobileProfilToggle = document.getElementById('mobileProfilToggle');
        const mobileProfilMenu = document.getElementById('mobileProfilMenu');

        mobileNavToggle?.addEventListener('click', () => {
            mobileNavMenu?.classList.toggle('hidden');
        });

        mobileProfilToggle?.addEventListener('click', () => {
            mobileProfilMenu?.classList.toggle('hidden');
        });
    </script>
</body>

</html>
