<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>

<!-- Hero Section Event -->
<section class="bg-gradient-to-br from-indigo-900 via-green-800 to-green-700 pt-32 pb-24 text-white relative overflow-hidden">
    <!-- Dekorasi Background -->
    <div class="absolute inset-0 opacity-20">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <circle cx="10" cy="10" r="30" fill="white" />
            <circle cx="90" cy="80" r="40" fill="white" />
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <div class="inline-block px-4 py-1.5 bg-green-500/30 backdrop-blur-md rounded-full text-green-200 text-xs font-bold uppercase tracking-widest mb-6 border border-green-400/30">
            Pusat Kompetisi & Kegiatan
        </div>
        <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight">
            Temukan <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-400">Potensimu</span> di Sini
        </h1>
        <p class="text-green-100 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed">
            Ikuti berbagai event, lomba, dan workshop bergengsi untuk mengasah skill serta menambah relasi di luar jam perkuliahan.
        </p>
    </div>
</section>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-6 py-16">
    <div class="flex flex-col lg:flex-row gap-10">
        
        <!-- Sidebar Filter (Sticky) -->
        <aside class="w-full lg:w-1/4">
            <div class="bg-white p-8 rounded-3xl shadow-xl shadow-green-900/5 border border-gray-100 sticky top-28">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-sliders-h mr-3 text-green-600"></i> Filter Event
                </h3>
                
                <form action="<?= base_url('event') ?>" method="GET" class="space-y-6">
                    <!-- Cari Keyword -->
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase mb-3 block">Pencarian</label>
                        <div class="relative">
                            <input type="text" name="keyword" value="<?= esc($filters['keyword'] ?? '') ?>"
                                class="w-full pl-4 pr-10 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-green-500 text-sm transition-all"
                                placeholder="Cari nama event...">
                            <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-green-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <hr class="my-8 border-gray-100">

                <!-- Help Box -->
                <div class="bg-green-600 p-6 rounded-2xl text-white">
                    <p class="text-xs font-medium opacity-80 mb-2">Ingin mempromosikan event?</p>
                    <p class="text-sm font-bold mb-4">Ajukan publikasi event organisasimu di sini!</p>
                    <a href="#" class="block w-full py-2.5 bg-white text-green-700 text-center rounded-xl text-xs font-bold hover:bg-green-50 transition">
                        Hubungi Admin
                    </a>
                </div>
            </div>
        </aside>

        <!-- Event Grid -->
        <div class="w-full lg:w-3/4">
            <?php if (!empty($event_list)): ?>
                <div class="grid md:grid-cols-2 gap-8">
                    <?php foreach ($event_list as $event): ?>
                        <?php 
                            $waktu = isset($event['waktu']) ? strtotime($event['waktu']) : null;
                            $is_active = $waktu ? ($waktu >= time()) : true;
                        ?>
                        <div class="group bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-green-900/10 transition-all duration-500 overflow-hidden flex flex-col">
                            
                            <!-- Poster Container -->
                            <div class="relative h-64 overflow-hidden">
                                <!-- Status Badge -->
                                <div class="absolute top-5 left-5 z-20">
                                    <?php if ($is_active): ?>
                                        <span class="px-4 py-1.5 bg-green-500 text-white text-[10px] font-black uppercase rounded-full shadow-lg shadow-green-500/40">
                                            Open Registration
                                        </span>
                                    <?php else: ?>
                                        <span class="px-4 py-1.5 bg-gray-500 text-white text-[10px] font-black uppercase rounded-full">
                                            Closed
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Poster Image -->
                                <?php if (!empty($event['file'])): ?>
                                    <img src="<?= esc($file_base_url . $event['file']) ?>" 
                                         alt="<?= esc($event['nama_event']) ?>"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <?php else: ?>
                                    <div class="w-full h-full bg-green-50 flex flex-col items-center justify-center text-green-200">
                                        <i class="fas fa-calendar-alt text-6xl"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Overlay on Hover -->
                                <div class="absolute inset-0 bg-indigo-900/60 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-10">
                                    <a href="<?= base_url('event/detail/' . $event['id']) ?>" class="px-6 py-3 bg-white text-indigo-900 rounded-2xl font-bold transform -translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                        Lihat Detail Event
                                    </a>
                                </div>
                            </div>

                            <!-- Detail Content -->
                            <div class="p-8 flex flex-col flex-grow">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-lg border border-green-100 uppercase">
                                        <?= esc($event['kategori'] ?? 'General Event') ?>
                                    </span>
                                    <span class="text-[11px] text-gray-400 font-medium">
                                        <i class="far fa-eye mr-1"></i> <?= rand(100, 500) ?> views
                                    </span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-green-700 transition-colors line-clamp-2">
                                    <?= esc($event['nama_event']) ?>
                                </h3>

                                <p class="text-sm text-gray-500 mb-6 line-clamp-2 leading-relaxed">
                                    <?= esc(strip_tags($event['deskripsi'])) ?>
                                </p>

                                <!-- Info Row -->
                                <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3">
                                            <i class="far fa-calendar-check text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase leading-none mb-1 text-red-500">Tanggal Kegiatan</p>
                                            <p class="text-xs font-bold text-gray-700"><?= isset($event['waktu']) ? date('d M Y', strtotime($event['waktu'])) : 'TBA' ?></p>
                                        </div>
                                    </div>
                                    
                                    <a href="<?= base_url('event/detail/' . $event['id']) ?>" class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-green-600 hover:bg-green-600 hover:text-white transition-colors border border-gray-100">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="mt-16 flex justify-center">
                    <?= $pager->links('event', 'default_full') ?>
                </div>

            <?php else: ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php $this->endSection() ?>