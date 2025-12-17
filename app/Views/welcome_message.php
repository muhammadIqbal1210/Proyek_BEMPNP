<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BEM POLITEKNIK NEGERI PADANG</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar --> 
    <nav class="bg-green-700/70 backdrop-blur-sm fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="/bem.png" alt="Logo BEM PNP" class="h-12 w-12 object-contain">
                <div class="flex flex-col leading-none">
                    <span class="font-bold text-white">BEM KM</span>
                    <span class="text-sm text-gray-200 text-xs">Politeknik Negeri Padang</span>
                </div>
            </div>
            <ul class="hidden md:flex space-x-6 font-semibold text-white">
                <li><a href="#" class="hover:text-orange-600">Home</a></li>
                <li><a href="<?= base_url('pengumuman') ?>" class="hover:text-orange-600">Pengumuman</a></li>
                <li><a href="#" class="hover:text-orange-600">Profil</a></li>
                <li><a href="#" class="hover:text-orange-600">Layanan</a></li>
                <li><a href="#" class="hover:text-orange-600">Berita</a></li>
                <li><a href="#" class="hover:text-orange-600">Katalog</a></li>
                <li><a href="#" class="hover:text-orange-600">Kontak</a></li>
                <li><a href="/login" class="bg-orange-500 hover:bg-orange-400 text-white font-semibold px-6 pt-1 pb-2 rounded-full transition">Login</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative h-[90vh] bg-cover bg-center" 
        style="background-image: url('/home.jpg'">
        
        <!-- Lapisan hitam transparan -->
        <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-center items-center text-center text-white px-6">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Badan Eksekutif Mahasiswa</h1>
            <p class="text-3xl mb-1 max-w-2xl font-bold">Keluarga Mahasiswa </p>
            <p class="text-lg mb-6 max-w-2xl">Politeknik Negeri Padang</p>
            <a href="#profil" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                Pelajari Selengkapnya
            </a>
        </div>
    </section>

    <!-- Profil Singkat -->
    <section id="profil" class="py-16 px-6 max-w-6xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-6 text-orange-600">Tentang Kami</h2>
        <p class="text-lg leading-relaxed text-gray-700">
            Badan Eksekutif Mahasiswa Politeknik Negeri Padang merupakan lembaga eksekutif tertinggi mahasiswa
            yang berperan sebagai jembatan antara mahasiswa dan pihak kampus, serta wadah pengembangan kepemimpinan dan advokasi mahasiswa.
        </p>
    </section>

    <!-- Program Unggulan -->   
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-10 text-orange-600">Program Kami</h2>
            <div class="grid md:grid-cols-3 gap-8 px-6">
                <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-xl mb-2 text-gray-800">Kegiatan Sosial Mahasiswa</h3>
                    <p class="text-gray-600">Program bakti sosial yang melibatkan mahasiswa untuk membantu masyarakat sekitar kampus.</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-xl mb-2 text-gray-800">Gerakan Hijau Kampus</h3>
                    <p class="text-gray-600">Inisiatif pelestarian lingkungan dengan menanam pohon dan mengurangi penggunaan plastik.</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-xl mb-2 text-gray-800">Pekan Kreativitas Mahasiswa</h3>
                    <p class="text-gray-600">Ajang kompetisi dan inovasi bagi mahasiswa dalam berbagai bidang keilmuan dan seni.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pengumuman -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-10 text-orange-600">Pengumuman</h2>
            <div class="grid md:grid-cols-2 gap-8 px-6">
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <img src="/umum1.png" alt="Bakti Sosial Mahasiswa" class="w-full h-48 object-cover">
                    <div class="p-5 text-left">
                        <h3 class="font-bold text-lg mb-2 text-gray-800">Pengumuman Libur Semester</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                        Pengumuman Resmi Terkiat Hari Libur dan Waktu Perkulihan
                        </p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <img src="/umum2.png" alt="Bakti Sosial Mahasiswa" class="w-full h-48 object-cover">
                    
                    <div class="p-5 text-left">
                        <h3 class="font-bold text-lg mb-2 text-gray-800">Pengajuan Banding UKT</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                        Penurunan dan Banding UKT Mahasiswa Politeknik Negeri Padang
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita Terbaru -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-10 text-orange-600">Berita Terbaru</h2>
            <div class="grid md:grid-cols-3 gap-8 px-6">
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <img src="/bem2.jpg" alt="Bakti Sosial Mahasiswa" class="w-full h-48 object-cover">
                    <div class="p-5 text-left">
                        <h3 class="font-bold text-lg mb-2 text-gray-800">Bakti Sosial Mahasiswa</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                        Kegiatan sosial di daerah pinggiran kota Padang bersama warga sekitar.
                        </p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <img src="/home.jpg" alt="Bakti Sosial Mahasiswa" class="w-full h-48 object-cover">
                    
                    <div class="p-5 text-left">
                        <h3 class="font-bold text-lg mb-2 text-gray-800">Bakti Sosial Mahasiswa</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                        Kegiatan sosial di daerah pinggiran kota Padang bersama warga sekitar.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <img src="/bem2.jpg" alt="Bakti Sosial Mahasiswa" class="w-full h-48 object-cover">
                    <div class="p-5 text-left">
                        <h3 class="font-bold text-lg mb-2 text-gray-800">Bakti Sosial Mahasiswa</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                        Kegiatan sosial di daerah pinggiran kota Padang bersama warga sekitar.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

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
                    <li><a href="#" class="hover:text-orange-400">Home</a></li>
                    <li><a href="#" class="hover:text-orange-400">Program</a></li>
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
