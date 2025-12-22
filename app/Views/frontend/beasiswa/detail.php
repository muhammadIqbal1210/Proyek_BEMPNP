<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>

<section class="pt-28 pb-12 bg-gray-50">
<div class="max-w-5xl mx-auto px-6">
<!-- Breadcrumb -->
<nav class="flex mb-8 text-sm text-gray-500 items-center">
<a href="<?= base_url('beasiswa') ?>" class="hover:text-green-700">Beasiswa</a>
<i class="fas fa-chevron-right mx-3 text-[10px]"></i>
<span class="text-gray-900 font-medium line-clamp-1"><?= esc($beasiswa['nama_beasiswa']) ?></span>
</nav>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row">
            
            <!-- Sisi Kiri: Poster -->
            <div class="w-full md:w-2/5 bg-gray-100 relative">
                <?php if (!empty($beasiswa['poster'])): ?>
                    <img src="<?= esc($beasiswa_base_url . $beasiswa['poster']) ?>" 
                         alt="<?= esc($beasiswa['nama_beasiswa']) ?>"
                         class="w-full h-full object-contain">
                <?php else: ?>
                    <div class="w-full h-64 md:h-full flex flex-col items-center justify-center text-gray-300">
                        <i class="fas fa-graduation-cap text-7xl mb-4"></i>
                        <span class="text-sm italic">Poster tidak tersedia</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sisi Kanan: Detail -->
            <div class="w-full md:w-3/5 p-8 md:p-12">
                <div class="mb-6">
                    <?php 
                        $is_open = ($beasiswa['tanggal_tutup'] && strtotime($beasiswa['tanggal_tutup']) >= time());
                    ?>
                    <span class="<?= $is_open ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?> text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest">
                        <?= $is_open ? 'Pendaftaran Dibuka' : 'Pendaftaran Ditutup' ?>
                    </span>
                </div>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-4 leading-tight">
                    <?= esc($beasiswa['nama_beasiswa']) ?>
                </h1>

                <div class="flex flex-wrap gap-6 mb-8">
                    <div class="flex items-center text-sm text-gray-600">
                        <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600 mr-3">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-400 leading-none mb-1">Periode</p>
                            <p class="font-semibold italic">
                                <?= date('d M', strtotime($beasiswa['tanggal_buka'])) ?> - 
                                <?= date('d M Y', strtotime($beasiswa['tanggal_tutup'])) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="prose prose-green max-w-none text-gray-600 mb-10 leading-relaxed">
                    <h4 class="text-gray-900 font-bold mb-2">Deskripsi Beasiswa:</h4>
                    <?= nl2br(esc($beasiswa['deskripsi'])) ?>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row gap-4 border-t pt-8">
                    <?php if ($is_open && !empty($beasiswa['link_informasi'])): ?>
                        <a href="<?= esc($beasiswa['link_informasi']) ?>" target="_blank"
                           class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-green-600 text-white rounded-2xl font-bold hover:bg-green-700 shadow-lg shadow-green-200 transition-all active:scale-95">
                            <i class="fas fa-external-link-alt mr-2"></i> Daftar Sekarang
                        </a>
                    <?php else: ?>
                        <button disabled class="flex-1 px-8 py-4 bg-gray-100 text-gray-400 rounded-2xl font-bold cursor-not-allowed">
                            <?= $is_open ? 'Link Belum Tersedia' : 'Pendaftaran Sudah Tutup' ?>
                        </button>
                    <?php endif; ?>
                    
                    <a href="https://wa.me/nomor-advokasi?text=Halo, saya ingin bertanya tentang beasiswa <?= urlencode($beasiswa['nama_beasiswa']) ?>" 
                       target="_blank"
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-50 transition-all">
                        <i class="fab fa-whatsapp mr-2 text-green-500 text-lg"></i> Tanya Bantuan
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>


</section>

<?php $this->endSection() ?>