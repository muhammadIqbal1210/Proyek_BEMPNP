<?= $this->extend('layouts/layout_utama') ?> 

<?php $this->section('content') ?>
<section class=" h-[90vh] bg-cover bg-center bg-no-repeat" style="background-image: url('<?= base_url('home.jpg') ?>');">
    <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-center items-center text-center text-white px-6">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2 tracking-tight">Badan Eksekutif Mahasiswa</h1>
        <p class="text-2xl md:text-3xl font-bold mb-1 max-w-2xl ">Keluarga Mahasiswa</p>
        <p class="text-lg md:text-xl mb-8 max-w-2xl text-orange-400">Politeknik Negeri Padang</p>
        
        <div class="flex gap-4">
            <a href="#profil" class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-full shadow-lg transform hover:-translate-y-1 transition duration-300">
                Pelajari Selengkapnya
            </a>
            <a href="<?= base_url('pengumuman') ?>" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 font-bold px-8 py-3 rounded-full transition duration-300">
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
            <div class="group p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:bg-green-700 transition duration-500">
                <div class="w-14 h-14 bg-green-100 text-green-700 rounded-lg flex items-center justify-center mb-6 group-hover:bg-white/20 group-hover:text-white transition">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-white">Kegiatan Sosial</h3>
                <p class="text-gray-600 group-hover:text-green-50 group-hover:opacity-90">Program bakti sosial yang melibatkan mahasiswa untuk membantu masyarakat sekitar kampus.</p>
            </div>
            <div class="group p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:bg-green-700 transition duration-500">
                <div class="w-14 h-14 bg-green-100 text-green-700 rounded-lg flex items-center justify-center mb-6 group-hover:bg-white/20 group-hover:text-white transition">
                    <i class="fas fa-leaf text-2xl"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-white">Gerakan Hijau</h3>
                <p class="text-gray-600 group-hover:text-green-50 group-hover:opacity-90">Inisiatif pelestarian lingkungan dengan menanam pohon dan kampanye bebas sampah plastik.</p>
            </div>
            <div class="group p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:bg-green-700 transition duration-500">
                <div class="w-14 h-14 bg-green-100 text-green-700 rounded-lg flex items-center justify-center mb-6 group-hover:bg-white/20 group-hover:text-white transition">
                    <i class="fas fa-lightbulb text-2xl"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-white">Pekan Kreativitas</h3>
                <p class="text-gray-600 group-hover:text-green-50 group-hover:opacity-90">Ajang kompetisi dan inovasi bagi mahasiswa dalam berbagai bidang keilmuan dan seni.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex justify-between items-end mb-10">
            <div class="text-left">
                <h2 class="text-3xl font-bold text-gray-800">Pengumuman Terbaru</h2>
                <p class="text-gray-500">Info resmi seputar kampus dan organisasi</p>
            </div>
            <a href="<?= base_url('pengumuman') ?>" class="text-green-700 font-bold flex items-center hover:underline">
                Semua Pengumuman <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <?php if (!empty($latest_announcements)): foreach ($latest_announcements as $ann): ?>
            <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300">
                <div class="md:w-1/3 bg-green-600 flex items-center justify-center text-white">
                    <i class="fas fa-bullhorn text-4xl opacity-30"></i>
                </div>
                <div class="p-6 md:w-2/3">
                    <span class="text-xs font-bold text-orange-500 uppercase"><?= date('d M Y', strtotime($ann['tanggal_publikasi'])) ?></span>
                    <h3 class="font-bold text-lg mt-1 mb-2 text-gray-800 line-clamp-1"><?= $ann['title'] ?></h3>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4"><?= strip_tags($ann['content']) ?></p>
                    <a href="<?= base_url('pengumuman/detail/' . $ann['id']) ?>" class="text-green-700 font-bold text-sm">Baca Detail →</a>
                </div>
            </div>
            <?php endforeach; else: ?>
                <p class="col-span-2 text-center text-gray-400 py-10">Belum ada pengumuman aktif.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $this->endSection() ?>