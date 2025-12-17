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
    
    <!-- Header Halaman -->
    <header class="bg-green-700 pt-16 pb-12 mb-10 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h1 class="text-4xl font-extrabold text-white mb-2">Pusat Informasi Pengumuman</h1>
            <p class="text-gray-200 text-lg">Semua pengumuman resmi dan terkini dari Badan Eksekutif Mahasiswa KM Politeknik Negeri Padang.</p>
        </div>
    </header>

    <!-- Daftar Pengumuman -->
    <main class="max-w-6xl mx-auto px-6 py-8">
        
        <?php 
        // Cek apakah variabel $pengumuman_list tersedia dan memiliki data
        // $pengumuman_list di sini adalah hasil dari $query->paginate()
        if (isset($pengumuman_list) && is_array($pengumuman_list) && count($pengumuman_list) > 0): 
        ?>
            <!-- Grid untuk menampilkan pengumuman dalam 3 kolom pada desktop -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            
                <?php 
                // Loop data pengumuman
                foreach ($pengumuman_list as $pengumuman):
                ?>
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-[1.02] transition duration-300">
                        
                        <!-- Visual/Placeholder -->
                        <div class="w-full h-52 bg-green-500 flex items-center justify-center relative">
                            <i class="fas fa-bullhorn text-7xl text-white opacity-40"></i>
                            <?php if (!empty($pengumuman['file_path'])): ?>
                                <span class="absolute top-2 right-2 bg-orange-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                                    <i class="fas fa-paperclip mr-1"></i> Berkas
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="p-6 text-left">
                            <p class="text-xs text-gray-500 mb-2 font-medium flex items-center">
                                <i class="fas fa-calendar-alt mr-2 text-orange-500"></i> 
                                Tanggal Publikasi: <?= date('d F Y', strtotime($pengumuman['tanggal_publikasi'] ?? $pengumuman['created_at'] ?? 'now')) ?>
                            </p>

                            <!-- Judul Pengumuman (Menggunakan 'title') -->
                            <h3 class="font-bold text-xl mb-3 text-gray-900 leading-snug line-clamp-2">
                                <?= htmlspecialchars($pengumuman['title']) ?>
                            </h3>
                            
                            <!-- Ringkasan Isi Pengumuman (Menggunakan 'content') -->
                            <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                <?= substr(strip_tags($pengumuman['content'] ?? 'Tidak ada deskripsi singkat.'), 0, 150) ?><?= (strlen(strip_tags($pengumuman['content'] ?? '')) > 150) ? '...' : '' ?>
                            </p>
                            
                            <!-- Link Baca Detail (Mengarah ke route /pengumuman/detail/{id}) -->
                            <a href="<?= base_url('pengumuman/detail/' . $pengumuman['id']) ?>" class="text-orange-600 hover:text-orange-700 font-semibold text-sm inline-flex items-center transition">
                                Baca Selengkapnya
                                <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>

                <?php 
                endforeach; 
                ?>

            </div>
            
            <!-- Pagination Link BARU -->
            <div class="mt-10 flex justify-center">
                <!-- MEMANGGIL TEMPLATE BAWAAN: default_full (yang kini berisi kode Tailwind Anda) -->
                <?= $pager->links('pengumuman', 'default_full') ?> 
            </div>
            
        <?php 
        else: 
        ?>
            <!-- Pesan jika tidak ada pengumuman yang ditemukan -->
            <div class="flex justify-center items-center h-[50vh]">
                <div class="bg-white border border-gray-200 text-gray-700 p-8 rounded-xl shadow-xl max-w-lg text-center">
                    <i class="fas fa-bullhorn text-6xl text-orange-500 mb-4"></i>
                    <p class="font-bold text-2xl mb-2">Belum Ada Pengumuman Aktif</p>
                    <p class="text-gray-600">Saat ini tidak ada pengumuman resmi yang tersedia. Silakan cek kembali nanti.</p>
                    <a href="<?= base_url() ?>" class="mt-5 inline-block bg-green-700 hover:bg-green-800 text-white font-semibold px-6 py-2 rounded-lg transition">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        <?php endif; ?>

    </main>

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