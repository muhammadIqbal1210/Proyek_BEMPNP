<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Pengumuman Resmi - BEM KM PNP' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; } 
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
            <ul class="hidden md:flex space-x-6 font-semibold text-white">
                <li><a href="<?= base_url() ?>" class="hover:text-orange-600">Home</a></li>
                <!-- Navigasi Aktif -->
                <li><a href="<?= base_url('pengumuman') ?>" class="text-orange-400 border-b-2 border-orange-400 pb-1">Pengumuman</a></li> 
                <li><a href="#" class="hover:text-orange-600">Profil</a></li>
                <li><a href="#" class="hover:text-orange-600">Layanan</a></li>
                <li><a href="#" class="hover:text-orange-600">Berita</a></li>
                <li><a href="#" class="hover:text-orange-600">Katalog</a></li>
                <li><a href="#" class="hover:text-orange-600">Kontak</a></li>
                <li><a href="<?= base_url('login') ?>" class="bg-orange-500 hover:bg-orange-400 text-white font-semibold px-6 pt-1 pb-2 rounded-full transition">Login</a></li>
            </ul>
        </div>
    </nav>
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
    