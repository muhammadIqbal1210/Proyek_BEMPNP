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
    body {
        font-family: 'Inter', sans-serif;
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
    </style>
</head>

<body class="bg-gray-50 text-gray-800 pt-20">

    <!-- Navbar -->
    <nav class="bg-green-700/70 backdrop-blur-sm fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="<?= base_url('bem.png') ?>" alt="Logo BEM PNP" class="h-12 w-12 object-contain">
                <div class="flex flex-col leading-none">
                    <span class="font-bold text-white">BEM KM</span>
                    <span class="text-xs text-gray-200">Politeknik Negeri Padang</span>
                </div>
            </div>
            <ul class="hidden md:flex space-x-6 font-semibold text-white items-center">
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
                    <a href="<?= base_url('login') ?>"
                        class="bg-orange-500 hover:bg-orange-400 text-white font-semibold px-6 pt-1 pb-2 rounded-full transition shadow-md">
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <?= $this->renderSection('content') ?>
    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-10 mt-10">
        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 px-6">
            <div>
                <h3 class="font-bold text-xl text-white mb-3">BEM PNP</h3>
                <p>Badan Eksekutif Mahasiswa Politeknik Negeri Padang.
                    Mengabdi, Berkarya, dan Berinovasi untuk Negeri.</p>
            </div>
            <div>
                <h3 class="font-bold text-xl text-white mb-3">Navigasi</h3>
                <ul>
                    <li><a href="<?= base_url() ?>" class="hover:text-orange-400">Home</a></li>
                    <li><a href="<?= base_url('pengumuman') ?>" class="hover:text-orange-400">Pengumuman</a></li>
                    <li><a href="<?= base_url('berita') ?>" class="hover:text-orange-400">Berita</a></li>
                    <li><a href="<?= base_url('kontak') ?>" class="hover:text-orange-400">Kontak</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-xl text-white mb-3">Kontak</h3>
                <p>Jl. Limau Manis, Kec. Pauh, Padang</p>
                <p>Email: bem@pnp.ac.id</p>
                <p>Instagram: @bem_pnp</p>
            </div>
        </div>
        <div class="text-center mt-8 text-gray-500 text-sm">
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
    </script>
</body>

</html>
