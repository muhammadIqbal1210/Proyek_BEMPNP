<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>

<main class="pt-28 pb-20 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-gray-400">
                <li><a href="<?= base_url('/') ?>" class="hover:text-green-600">Home</a></li>
                <li><i class="fas fa-chevron-right text-[10px] mx-2"></i></li>
                <li><a href="<?= base_url('lomba') ?>" class="hover:text-green-600">Lomba</a></li>
                <li><i class="fas fa-chevron-right text-[10px] mx-2"></i></li>
                <li class="text-gray-600 font-medium"><?= esc($lomba['nama_lomba']) ?></li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Kolom Kiri: Poster (Sticky) -->
            <div class="w-full lg:w-5/12">
                <div class="sticky top-28">
                    <div class="bg-white p-3 rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                        <?php if (!empty($lomba['poster'])): ?>
                        <img src="<?= esc($poster_base_url . $lomba['poster']) ?>" 
                             alt="Poster Lomba" 
                             class="w-full h-auto rounded-2xl shadow-inner cursor-zoom-in hover:opacity-95 transition"
                             onclick="window.open(this.src)">
                        <?php else: ?>
                        <div class="aspect-[3/4] bg-green-50 rounded-2xl flex items-center justify-center text-green-200">
                            <i class="fas fa-image text-8xl"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mt-6 flex justify-center gap-4">
                        <span class="text-xs text-gray-400 flex items-center italic">
                            <i class="fas fa-info-circle mr-1"></i> Klik gambar untuk memperbesar
                        </span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Detail -->
            <div class="w-full lg:w-7/12">
                <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-gray-100">
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <span class="px-4 py-1.5 bg-green-600 text-white text-xs font-bold rounded-full uppercase tracking-wider">
                            <?= esc($lomba['kategori']) ?>
                        </span>
                        <?php if($lomba['status_lomba'] == 'Buka'): ?>
                            <span class="flex items-center text-green-600 text-sm font-bold">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                Pendaftaran Dibuka
                            </span>
                        <?php else: ?>
                             <span class="flex items-center text-red-600 text-sm font-bold">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                Pendaftaran Ditutup
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                        <?= esc($lomba['nama_lomba']) ?>
                    </h1>

                    <div class="prose prose-green max-w-none text-gray-600 leading-relaxed mb-10">
                        <h4 class="text-gray-900 font-bold mb-3 flex items-center">
                            <i class="fas fa-align-left mr-2 text-green-600"></i> Detail Kompetisi
                        </h4>
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <?= $lomba['deskripsi'] ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-10">
                        <div class="p-4 bg-green-50 rounded-2xl border border-green-100">
                            <p class="text-[10px] font-bold text-green-400 uppercase mb-1">Kategori</p>
                            <p class="text-green-900 font-bold"><?= esc($lomba['kategori']) ?></p>
                        </div>
                        <div class="p-4 bg-indigo-50 rounded-2xl border border-indigo-100">
                            <p class="text-[10px] font-bold text-indigo-400 uppercase mb-1">Status</p>
                            <p class="text-indigo-900 font-bold"><?= esc($lomba['status_lomba']) ?></p>
                        </div>
                    </div>

                    <!-- CTA Section -->
                    <div class="bg-green-600 rounded-3xl p-8 text-center text-white shadow-lg">
                        <h3 class="text-xl font-bold mb-2">Siap untuk Berkompetisi?</h3>
                        <p class="text-green-100 text-sm mb-6 opacity-90">Pelajari syarat dan ketentuan lebih lanjut melalui tautan informasi resmi di bawah ini.</p>
                        
                        <?php if (!empty($lomba['link_informasi'])): ?>
                        <a href="<?= esc($lomba['link_informasi']) ?>" target="_blank" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-white text-green-700 rounded-2xl font-bold hover:bg-green-50 transition-all transform hover:scale-105">
                            <i class="fas fa-external-link-alt mr-2"></i> Kunjungi Link Informasi
                        </a>
                        <?php else: ?>
                        <button disabled class="px-8 py-4 bg-green-500/50 text-white/50 rounded-2xl font-bold cursor-not-allowed">
                            Link Tidak Tersedia
                        </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Card Tambahan -->
                <div class="mt-8 bg-gray-900 text-white rounded-3xl p-6 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-yellow-400">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Tips Sukses</p>
                            <p class="text-sm font-medium">Konsultasi dengan pembimbing sebelum mendaftar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->endSection() ?>