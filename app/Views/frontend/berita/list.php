<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>

<!-- Header Berita -->
<section class="bg-gray-100 border-b border-gray-200 pt-32 pb-12">
    <div class="max-w-7xl mx-auto px-6">
        <nav class="flex mb-4 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="<?= base_url('/') ?>" class="hover:text-green-700">Beranda</a></li>
                <li class="flex items-center space-x-2">
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-900 font-medium">Berita</span>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
            Berita <span class="text-green-700">Terkini</span>
        </h1>
        <div class="w-20 h-1.5 bg-yellow-400 mt-4"></div>
    </div>
</section>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col lg:flex-row gap-12">
        
        <!-- Kolom Berita Utama -->
        <div class="w-full lg:w-2/3">
            <?php if (!empty($semua_berita)): ?>
                <div class="flex flex-col gap-10">
                    <?php foreach ($semua_berita as $b): ?>
                        <article class="flex flex-col md:flex-row gap-6 group">
                            <!-- Thumbnail -->
                            <div class="w-full md:w-2/5 shrink-0 overflow-hidden rounded-xl shadow-sm">
                                <a href="<?= base_url('berita/detail/' . $b['id']) ?>">
                                    <?php if (!empty($b['gambarberita'])): ?>
                                        <img src="<?= base_url('uploads/berita/' . $b['gambarberita']) ?>" 
                                             alt="<?= esc($b['judulberita']) ?>"
                                             class="w-full h-64 md:h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                                    <?php else: ?>
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                            <i class="fas fa-image text-4xl"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>

                            <!-- Content Meta -->
                            <div class="flex flex-col flex-grow">
                                <div class="flex items-center text-[11px] font-bold uppercase tracking-wider text-green-700 mb-2">
                                    <span class="bg-green-100 px-2 py-0.5 rounded">Berita Utama</span>
                                    <span class="mx-2 text-gray-300">|</span>
                                    <span class="text-gray-500"><i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y', strtotime($b['tanggalberita'])) ?></span>
                                </div>

                                <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-700 transition-colors leading-tight">
                                    <a href="<?= base_url('berita/detail/' . $b['id']) ?>">
                                        <?= esc($b['judulberita']) ?>
                                    </a>
                                </h2>

                                <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 mb-4">
                                    <?= strip_tags($b['isiberita']) ?>
                                </p>

                                <div class="mt-auto">
                                    <a href="<?= base_url('berita/detail/' . $b['id']) ?>" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-gray-900 hover:text-green-700 transition">
                                        Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <!-- Separator -->
                        <div class="h-px bg-gray-100 w-full"></div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    <?php if(isset($pager)): ?>
                        <?= $pager->links('berita', 'default_full') ?>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="text-center py-20">
                    <p class="text-gray-500">Belum ada berita yang diterbitkan.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="w-full lg:w-1/3 space-y-12">
            <!-- Pencarian -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-yellow-400 ps-3">Cari Berita</h3>
                <form action="<?= base_url('berita') ?>" method="GET">
                    <div class="relative">
                        <input type="text" name="keyword" value="<?= esc($filters['keyword'] ?? '') ?>"
                               class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition-all text-sm"
                               placeholder="Ketik kata kunci...">
                        <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-green-700">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Berita Populer (Mockup) -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-6 border-l-4 border-yellow-400 ps-3">Terpopuler</h3>
                <div class="space-y-6">
                    <?php 
                    // Contoh simulasi berita populer jika tidak ada data dari controller
                    $populer = array_slice($semua_berita, 0, 3); 
                    foreach ($populer as $p): 
                    ?>
                    <div class="flex gap-4 group">
                        <div class="w-16 h-16 shrink-0 rounded-lg overflow-hidden bg-gray-100">
                            <img src="<?= base_url('uploads/berita/' . $p['gambarberita']) ?>" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="text-sm font-bold leading-snug group-hover:text-green-700 transition">
                                <a href="<?= base_url('berita/detail/' . $p['id']) ?>"><?= esc($p['judulberita']) ?></a>
                            </h4>
                            <span class="text-[10px] text-gray-400 uppercase font-bold"><?= date('d M Y', strtotime($p['tanggalberita'])) ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Social Media Box -->
            <div class="bg-green-900 p-8 rounded-3xl text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-xl font-bold mb-2">Ikuti Kami</h3>
                    <p class="text-green-200 text-sm mb-6">Dapatkan update langsung melalui media sosial resmi kami.</p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-yellow-400 hover:text-green-900 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-yellow-400 hover:text-green-900 transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-yellow-400 hover:text-green-900 transition"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <i class="fas fa-share-alt absolute -bottom-4 -right-4 text-8xl text-white/5"></i>
            </div>
        </aside>

    </div>
</main>

<style>
    .pagination { @apply flex space-x-2; }
    .pagination li a, .pagination li span { @apply px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium transition-all; }
    .pagination li.active span { @apply bg-green-700 border-green-700 text-white; }
    .pagination li a:hover { @apply bg-gray-50 border-green-700 text-green-700; }
</style>

<?php $this->endSection() ?>