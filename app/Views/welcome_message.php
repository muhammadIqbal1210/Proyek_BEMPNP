<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>
<section class=" h-[90vh] bg-cover bg-center bg-no-repeat"
    style="background-image: url('<?= base_url('home.jpg') ?>');">
    <div
        class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-center items-center text-center text-white px-6">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2 tracking-tight">Badan Eksekutif Mahasiswa</h1>
        <p class="text-2xl md:text-3xl font-bold mb-1 max-w-2xl ">Keluarga Mahasiswa</p>
        <p class="text-lg md:text-xl mb-8 max-w-2xl text-orange-400">Politeknik Negeri Padang</p>

        <div class="flex gap-4">
            <a href="#profil"
                class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-full shadow-lg transform hover:-translate-y-1 transition duration-300">
                Pelajari Selengkapnya
            </a>
            <a href="<?= base_url('pengumuman') ?>"
                class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 font-bold px-8 py-3 rounded-full transition duration-300">
                Lihat Pengumuman
            </a>
        </div>
    </div>
</section>

<section id="profil" class="py-20 px-6 max-w-4xl mx-auto text-center">
    <span class="text-orange-600 font-bold tracking-widest uppercase text-sm">Tentang Kami</span>
    <h2 class="text-3xl md:text-4xl font-bold mb-8 text-gray-800">Suara Mahasiswa, Karya Nyata</h2>
    <p class="text-lg leading-relaxed text-gray-600 italic">
        "Badan Eksekutif Mahasiswa Politeknik Negeri Padang merupakan lembaga eksekutif tertinggi mahasiswa
        yang berperan sebagai jembatan antara mahasiswa dan pihak kampus, serta wadah pengembangan kepemimpinan dan
        advokasi mahasiswa."
    </p>
</section>

<section class="py-20 bg-white border-y border-gray-100">
    <div class="max-w-6xl mx-auto text-center px-6">
        <h2 class="text-3xl font-bold mb-12 text-gray-800">Program Kerja Unggulan</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div
                class="group p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:bg-green-700 transition duration-500">
                <div
                    class="w-14 h-14 bg-green-100 text-green-700 rounded-lg flex items-center justify-center mb-6 group-hover:bg-white/20 group-hover:text-white transition">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-white">Kegiatan Sosial</h3>
                <p class="text-gray-600 group-hover:text-green-50 group-hover:opacity-90">Program bakti sosial yang
                    melibatkan mahasiswa untuk membantu masyarakat sekitar kampus.</p>
            </div>
            <div
                class="group p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:bg-green-700 transition duration-500">
                <div
                    class="w-14 h-14 bg-green-100 text-green-700 rounded-lg flex items-center justify-center mb-6 group-hover:bg-white/20 group-hover:text-white transition">
                    <i class="fas fa-leaf text-2xl"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-white">Gerakan Hijau</h3>
                <p class="text-gray-600 group-hover:text-green-50 group-hover:opacity-90">Inisiatif pelestarian
                    lingkungan dengan menanam pohon dan kampanye bebas sampah plastik.</p>
            </div>
            <div
                class="group p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:bg-green-700 transition duration-500">
                <div
                    class="w-14 h-14 bg-green-100 text-green-700 rounded-lg flex items-center justify-center mb-6 group-hover:bg-white/20 group-hover:text-white transition">
                    <i class="fas fa-lightbulb text-2xl"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-white">Pekan Kreativitas</h3>
                <p class="text-gray-600 group-hover:text-green-50 group-hover:opacity-90">Ajang kompetisi dan inovasi
                    bagi mahasiswa dalam berbagai bidang keilmuan dan seni.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <!-- Judul Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
            <div class="text-left">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Pengumuman Terbaru</h2>
                <div class="h-1.5 w-16 bg-green-600 mt-3 rounded-full"></div>
                <p class="text-gray-500 mt-4 max-w-md">Informasi resmi, kebijakan kampus, dan agenda kegiatan organisasi
                    terbaru.</p>
            </div>
            <a href="<?= base_url('pengumuman') ?>"
                class="mt-6 md:mt-0 group inline-flex items-center text-green-700 font-bold hover:text-green-800 transition-all">
                Lihat Semua Pengumuman
                <span
                    class="ml-2 flex h-8 w-8 items-center justify-center rounded-full bg-green-100 group-hover:bg-green-600 group-hover:text-white transition-all">
                    <i class="fas fa-arrow-right text-xs"></i>
                </span>
            </a>
        </div>
        <div class="grid md:grid-cols- lg:grid-cols-2 gap-8">
            <?php if (!empty($latest_announcements)): foreach ($latest_announcements as $pengumuman): ?>
            <div
                class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-[1.01] transition duration-300 flex flex-col h-full">

                <!-- Area Preview File (Gambar / PDF / Doc) -->
                <div class="w-full h-56 bg-gray-100 relative overflow-hidden group">
                    <?php 
                    $filePath = $pengumuman['file_path'] ?? '';
                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    $fullPath = base_url('uploads/pengumuman/' . $filePath);
                    
                    if (!empty($filePath)): 
                        // KATEGORI 1: GAMBAR
                        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                    <img src="<?= $fullPath ?>" alt="Preview" class="w-full h-full object-cover">

                    <?php // KATEGORI 2: PDF
                        elseif ($extension === 'pdf'): ?>
                    <!-- Menggunakan tag <object> untuk render PDF langsung di card -->
                    <object data="<?= $fullPath ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf"
                        class="w-full h-full">
                        <div class="flex flex-col items-center justify-center h-full bg-red-50 text-red-600 p-4">
                            <i class="fas fa-file-pdf text-5xl mb-2"></i>
                            <span class="text-xs font-bold uppercase text-center">Preview PDF Tersedia</span>
                        </div>
                    </object>
                    <!-- Overlay transparan agar card tetap bisa diklik meskipun ada object PDF -->
                    <div class="absolute inset-0 z-10 cursor-pointer"></div>

                    <?php // KATEGORI 3: DOKUMEN LAIN (Word, Excel)
                        else: 
                            $bgBox = (in_array($extension, ['docx', 'doc'])) ? 'bg-blue-600' : ($extension == 'xlsx' ? 'bg-green-600' : 'bg-gray-700');
                        ?>
                    <div class="w-full h-full flex flex-col items-center justify-center <?= $bgBox ?> text-white p-6">
                        <i
                            class="fas <?= ($extension == 'xlsx') ? 'fa-file-excel' : 'fa-file-word' ?> text-6xl mb-3"></i>
                        <span
                            class="bg-white text-black px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                            <?= $extension ?>
                        </span>
                    </div>
                    <?php endif; ?>

                    <!-- Floating Badge Lampiran -->
                    <span
                        class="absolute top-3 right-3 z-20 bg-orange-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md">
                        <i class="fas fa-paperclip mr-1"></i> BERKAS
                    </span>
                    <?php else: ?>
                    <!-- JIKA TIDAK ADA FILE SAMA SEKALI -->
                    <div
                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-500 to-green-600">
                        <i class="fas fa-bullhorn text-7xl text-white opacity-20"></i>
                    </div>
                    <?php endif; ?>

                    <!-- Link Overlay ke Detail -->
                    <a href="<?= base_url('pengumuman/detail/' . $pengumuman['id']) ?>"
                        class="absolute inset-0 z-30"></a>
                </div>

                <!-- Bagian Konten Teks -->
                <div class="p-6 flex-grow flex flex-col">
                    <div class="flex items-center text-[11px] text-gray-500 mb-2 font-semibold">
                        <i class="fas fa-calendar-alt mr-2 text-orange-500"></i>
                        <?= date('d M Y', strtotime($pengumuman['tanggal_publikasi'] ?? $pengumuman['created_at'])) ?>
                    </div>

                    <h3
                        class="font-bold text-lg mb-2 text-gray-900 leading-tight line-clamp-2 hover:text-green-700 transition-colors">
                        <a href="<?= base_url('pengumuman/detail/' . $pengumuman['id']) ?>">
                            <?= htmlspecialchars($pengumuman['title']) ?>
                        </a>
                    </h3>

                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-2">
                        <?php 
                        $snippet = strip_tags($pengumuman['content'] ?? 'Tidak ada deskripsi.');
                        echo (strlen($snippet) > 100) ? substr($snippet, 0, 100) . '...' : $snippet;
                    ?>
                    </p>

                    <div class="pt-4 border-t border-gray-100 mt-auto">
                        <a href="<?= base_url('pengumuman/detail/' . $pengumuman['id']) ?>"
                            class="text-orange-600 hover:text-orange-700 font-bold text-sm inline-flex items-center group">
                            Baca Pengumuman
                            <i
                                class="fas fa-arrow-right ml-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-span-full py-10 text-center text-gray-400 border-2 border-dashed rounded-xl">
                Belum ada pengumuman terbaru.
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $this->endSection() ?>