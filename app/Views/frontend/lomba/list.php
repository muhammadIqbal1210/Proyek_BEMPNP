<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>

<!-- Hero Section Lomba -->
<section class="bg-gradient-to-r from-green-700 to-green-800 pt-24 pb-20 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
        </svg>
    </div>
    <div class="max-w-6xl mx-auto px-6 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Informasi Lomba</h1>
        <p class="text-green-100 text-lg max-w-2xl mx-auto">
            Tunjukkan bakatmu! Temukan berbagai kompetisi bergengsi untuk tingkatkan prestasi dan portofolio mahasiswa.
        </p>
    </div>
</section>

<!-- Konten Utama Lomba -->
<main class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex flex-col md:flex-row gap-8">

        <!-- Sidebar Filter -->
        <aside class="w-full md:w-1/4">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                <h2 class="font-bold text-gray-900 mb-4 flex items-center border-b pb-3">
                    <i class="fas fa-trophy mr-2 text-blue-600"></i> Cari Kompetisi
                </h2>

                <form action="<?= base_url('lomba') ?>" method="GET" class="mb-6">
                    <div class="relative mb-4">
                        <input type="text" name="keyword" value="<?= esc($filters['keyword'] ?? '') ?>"
                            class="w-full pl-4 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"
                            placeholder="Cari lomba...">
                        <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-blue-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Status</label>
                            <select name="status" onchange="this.form.submit()"
                                class="w-full py-2 border border-gray-200 rounded-lg text-sm focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="Buka" <?= ($filters['status'] ?? '') == 'Buka' ? 'selected' : '' ?>>Buka</option>
                                <option value="Tutup" <?= ($filters['status'] ?? '') == 'Tutup' ? 'selected' : '' ?>>Tutup</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100">
                    <h4 class="font-bold text-indigo-900 text-xs uppercase mb-2">Punya Info Lomba?</h4>
                    <p class="text-[11px] text-indigo-700 mb-3 leading-relaxed">Laporkan lomba menarik lainnya untuk kami bagikan di sini.</p>
                    <a href="#" class="inline-flex items-center justify-center w-full py-2 bg-indigo-600 text-white rounded-lg text-xs font-bold hover:bg-indigo-700 transition">
                        <i class="fas fa-plus-circle mr-2"></i> Ajukan Info
                    </a>
                </div>
            </div>
        </aside>

        <!-- Grid Lomba -->
        <div class="w-full md:w-3/4">
            <?php if (!empty($lomba_list)): ?>
            <div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-8">
                <?php foreach ($lomba_list as $lomba): ?>
                <?php 
                    $status_badge = match ($lomba['status_lomba']) {
                        'Buka'   => 'bg-green-100 text-green-700 border-green-200',
                        'Tutup'  => 'bg-red-100 text-red-700 border-red-200',
                        default  => 'bg-gray-100 text-gray-700 border-gray-200'
                    };
                ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col group">
                    <!-- Visual Header (Poster Mendominasi) -->
                    <div class="relative h-64 overflow-hidden">
                        <div class="absolute top-4 left-4 z-20">
                            <span class="<?= $status_badge ?> text-[10px] font-bold px-3 py-1.5 rounded-lg border uppercase shadow-sm">
                                <?= esc($lomba['status_lomba']) ?>
                            </span>
                        </div>
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex items-end p-6">
                             <span class="text-white text-sm font-medium">Klik untuk lihat panduan lengkap</span>
                        </div>

                        <?php if (!empty($lomba['poster'])): ?>
                        <img src="<?= esc($poster_base_url . $lomba['poster']) ?>"
                            alt="<?= esc($lomba['nama_lomba']) ?>"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        <?php else: ?>
                        <div class="w-full h-full flex flex-col items-center justify-center bg-green-50 text-green-200">
                            <i class="fas fa-image text-6xl"></i>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Content -->
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2 py-0.5 bg-green-50 text-green-600 text-[10px] font-bold rounded border border-green-100 uppercase">
                                <?= esc($lomba['kategori']) ?>
                            </span>
                        </div>
                        
                        <h3 class="font-bold text-xl text-gray-900 group-hover:text-green-700 transition-colors mb-3">
                            <?= esc($lomba['nama_lomba']) ?>
                        </h3>
                        
                        <p class="text-sm text-gray-500 line-clamp-2 mb-6 leading-relaxed">
                            <?= esc(strip_tags($lomba['deskripsi'])) ?>
                        </p>

                        <div class="mt-auto">
                            <a href="<?= base_url('lomba/detail/' . $lomba['id']) ?>" 
                               class="inline-flex items-center justify-center w-full py-3 bg-gray-50 text-green-700 group-hover:bg-green-600 group-hover:text-white rounded-xl text-sm font-bold transition-all duration-300">
                                Lihat Detail Lomba <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <div class="bg-white rounded-3xl p-20 text-center border-2 border-dashed border-gray-100">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-trophy text-blue-200 text-3xl"></i>
                    </div>
                    <p class="text-gray-400 font-medium">Maaf, kompetisi belum tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php $this->endSection() ?>