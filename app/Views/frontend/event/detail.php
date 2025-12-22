<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>

<main class="max-w-7xl mx-auto px-6 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-gray-400">
            <li><a href="<?= base_url('/') ?>" class="hover:text-green-600 transition">Home</a></li>
            <li><i class="fas fa-chevron-right text-[10px]"></i></li>
            <li><a href="<?= base_url('event') ?>" class="hover:text-green-600 transition">Event</a></li>
            <li><i class="fas fa-chevron-right text-[10px]"></i></li>
            <li class="text-gray-900 font-medium"><?= esc($event['nama_event']) ?></li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-12">

        <!-- Kolon Kiri: Konten Utama -->
        <div class="w-full lg:w-2/3">
            <!-- Image Card -->
            <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-gray-200/50 mb-10">
                <?php if (!empty($event['file'])): ?>
                <img src="<?= esc($file_base_url . $event['file']) ?>" alt="<?= esc($event['nama_event']) ?>"
                    class="w-full h-auto object-cover">
                <?php else: ?>
                <div class="w-full h-80 bg-green-50 flex items-center justify-center text-green-200">
                    <i class="fas fa-image text-8xl"></i>
                </div>
                <?php endif; ?>
            </div>

            <!-- Title & Meta -->
            <div class="mb-10">
                <div class="flex flex-wrap gap-3 mb-6">
                    <span
                        class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider">
                        <?= esc($event['kategori'] ?? 'Informasi lengkap') ?>
                    </span>
                    <span
                        class="px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full uppercase tracking-wider">
                        <i class="fas fa-users mr-2"></i>
                    </span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-gray-900 mb-6 leading-tight">
                    <?= esc($event['nama_event']) ?>
                </h1>
                <div class="flex items-center text-gray-500 gap-6 py-4 border-y border-gray-100">
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt mr-2"></i>
                        <span class="text-sm">Diposting: <?= date('d M Y') ?></span>
                    </div>
                </div>
            </div>

            <!-- Deskripsi / Body -->
            <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Tentang Event</h3>
                <div class="mb-8 text-justify">
                    <?= $event['deskripsi'] ?>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 mb-4">Syarat & Ketentuan</h3>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1.5 mr-3"></i>
                        <span>Peserta merupakan mahasiswa aktif atau umum sesuai kategori.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1.5 mr-3"></i>
                        <span>Membayar biaya pendaftaran (jika ada) sesuai instruksi.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1.5 mr-3"></i>
                        <span>Wajib mengikuti alur pendaftaran dan mematuhi aturan main.</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Kolom Kanan: Sidebar Aksi (Sticky) -->
        <div class="w-full lg:w-1/3">
            <div class="sticky top-28 space-y-6">

                <!-- Card Aksi Utama -->
                <div class="bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
                    <div class="mb-8">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Waktu Kegiatan</p>
                        <div class="flex items-center gap-4 text-red-600">
                            <i class="fas fa-clock text-2xl"></i>
                            <span class="text-2xl font-black">
                                <?= isset($event['waktu']) ? date('d M Y', strtotime($event['waktu'])) : 'TBA' ?>
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <?php if (!empty($event['link_informasi'])): ?>
                        <a href="<?= esc($event['link_informasi']) ?>" target="_blank"
                            class="flex items-center justify-center w-full py-4 bg-green-600 hover:bg-green-700 text-white rounded-2xl font-bold shadow-lg shadow-green-600/30 transition-all transform hover:-translate-y-1">
                            <i class="fas fa-paper-plane mr-3"></i> Daftar Sekarang
                        </a>
                        <?php else: ?>
                        <button disabled
                            class="w-full py-4 bg-gray-100 text-gray-400 rounded-2xl font-bold cursor-not-allowed">
                            Link Belum Tersedia
                        </button>
                        <?php endif; ?>
                    </div>

                    <hr class="my-8 border-gray-50">

                    <!-- Ringkasan Info -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">Penyelenggara</span>
                            <span
                                class="font-bold text-gray-700 text-right"><?= esc($event['penyelenggara'] ?? 'Panitia Event') ?></span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">Biaya Daftar</span>
                            <?php 
                                $biaya = strtolower($event['biaya'] ?? '');
                                $colorClass = ($biaya == 'gratis') ? 'text-amber-500' : 'text-green-600';
                            ?>
                            <span class="font-bold <?= $colorClass ?> uppercase">
                                <?= !empty($biaya) ? esc($biaya) : 'TBA' ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card Share -->
                <div class="bg-indigo-50 rounded-[2rem] p-8">
                    <h4 class="font-bold text-indigo-900 mb-4">Bagikan Event</h4>
                    <div class="flex gap-3">
                        <button onclick="window.open('https://wa.me/?text=Cek event seru ini: <?= current_url() ?>')"
                            class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-green-500 hover:bg-green-500 hover:text-white transition shadow-sm border border-indigo-100">
                            <i class="fab fa-whatsapp"></i>
                        </button>
                        <button onclick="navigator.clipboard.writeText('<?= current_url() ?>')"
                            class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-indigo-600 hover:bg-indigo-600 hover:text-white transition shadow-sm border border-indigo-100">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</main>

<?php $this->endSection() ?>