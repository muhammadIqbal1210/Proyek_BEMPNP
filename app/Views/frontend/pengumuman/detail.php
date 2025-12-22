<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Detail Pengumuman' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; } 
        /* Styling untuk konten (jika menggunakan editor WYSIWYG) */
        .content-body h1, .content-body h2 { font-weight: bold; margin-top: 1.5rem; margin-bottom: 0.5rem; }
        .content-body h1 { font-size: 1.875rem; } /* text-3xl */
        .content-body h2 { font-size: 1.5rem; } /* text-2xl */
        .content-body p { margin-bottom: 1rem; line-height: 1.6; }
        .content-body ul, .content-body ol { margin-left: 1.5rem; margin-bottom: 1rem; }
        .content-body ul { list-style-type: disc; }
        .content-body ol { list-style-type: decimal; }
        .content-body a { color: #f97316; text-decoration: underline; } /* orange-500 */
    </style>
</head>
<body class="bg-gray-50 text-gray-800 pt-20"> 
    
    <!-- Navbar (Diambil dari file list.php sebelumnya) --> 
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

            <li>
                <a href="<?= base_url('profil') ?>" 
                   class="<?= url_is('profil*') ? 'text-orange-400 border-b-2 border-orange-400' : 'hover:text-orange-400' ?> pb-1 transition-all duration-300">
                   Profil
                </a>
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
            <li><a href="#" class="hover:text-orange-400 pb-1 transition">Katalog</a></li>
            <li><a href="#" class="hover:text-orange-400 pb-1 transition">Kontak</a></li>
            
            <li>
                <a href="<?= base_url('login') ?>" 
                   class="bg-orange-500 hover:bg-orange-400 text-white font-semibold px-6 pt-1 pb-2 rounded-full transition shadow-md">
                   Login
                </a>
            </li>
        </ul>
        </div>
    </nav>

    <!-- Konten Detail Pengumuman -->
    <main class="max-w-4xl mx-auto px-6 py-12">
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-10 border-t-8 border-green-600">
            
            <!-- Breadcrumb / Kembali -->
            <a href="<?= base_url('pengumuman') ?>" class="inline-flex items-center text-green-600 hover:text-green-800 transition mb-6 font-medium text-sm">
                <i class="fas fa-chevron-left mr-2 text-xs"></i>
                Kembali ke Daftar Pengumuman
            </a>

            <!-- Metadata -->
            <div class="mb-6 pb-4 border-b">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight">
                    <?= htmlspecialchars($pengumuman['title'] ?? 'Judul Tidak Tersedia') ?>
                </h1>
                
                <p class="text-sm text-gray-500 mt-3 flex flex-wrap items-center space-x-4">
                    <span class="inline-flex items-center"><i class="fas fa-calendar-alt mr-2 text-orange-500"></i> Publikasi: <?= date('d F Y', strtotime($pengumuman['tanggal_publikasi'] ?? $pengumuman['created_at'] ?? 'now')) ?></span>
                    <span class="inline-flex items-center"><i class="fas fa-user-tag mr-2 text-orange-500"></i> Sumber: BEM KM PNP</span>
                </p>
            </div>

            <!-- Konten Utama -->
            <div class="text-gray-700 content-body">
                <!-- Tampilkan konten pengumuman (diasumsikan ini bisa berisi HTML dari editor WYSIWYG) -->
                <?= $pengumuman['content'] ?? 'Isi pengumuman tersedia dalam file.' ?>
            </div>

            <?php if (!empty($pengumuman['file_path'])): ?>
                <!-- Bagian Lampiran -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-paperclip mr-3 text-green-600"></i>
                        Lampiran Resmi
                    </h2>
                    <a href="<?= $pengumuman['file_path'] ?>" 
                       target="_blank" 
                       class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200">
                        <i class="fas fa-download mr-3"></i>
                        Unduh Berkas Lampiran
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </main>
    
    <!-- Footer (Diambil dari file list.php sebelumnya) -->
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
                    <li><a href="#" class="hover:text-orange-400">Berita</a></li>
                    <li><a href="#" class="hover:text-orange-400">Kontak</a></li>
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

</body>
</html>