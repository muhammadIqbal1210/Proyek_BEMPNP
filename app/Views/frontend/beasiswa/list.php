<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>

<!-- Hero Section Beasiswa -->

<section class="bg-gradient-to-r from-green-700 to-green-800 pt-24 pb-20 text-white relative overflow-hidden">
<div class="absolute inset-0 opacity-10">
<svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
<path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
</svg>
</div>
<div class="max-w-6xl mx-auto px-6 relative z-10 text-center">
<h1 class="text-4xl md:text-5xl font-extrabold mb-6 text-white">Informasi Beasiswa</h1>
<p class="text-green-100 text-lg max-w-2xl mx-auto">
Temukan peluang pendanaan pendidikan dan pengembangan diri untuk mahasiswa Politeknik Negeri Padang.
</p>
</div>
</section>

<!-- Konten Utama Beasiswa -->

<main class="max-w-6xl mx-auto px-6 py-12">
<div class="flex flex-col md:flex-row gap-8">

    <!-- Sidebar Filter -->
    <aside class="w-full md:w-1/4">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
            <h2 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-filter mr-2 text-green-600"></i> Cari Beasiswa
            </h2>

            <form action="<?= base_url('beasiswa') ?>" method="GET" class="mb-6">
                <div class="relative mb-4">
                    <input type="text" name="keyword" value="<?= esc($filters['keyword'] ?? '') ?>"
                        class="w-full pl-4 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-green-500 focus:border-green-500 text-sm"
                        placeholder="Nama beasiswa...">
                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-green-600">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Status</label>
                    <select name="status" onchange="this.form.submit()"
                        class="w-full py-2 border border-gray-200 rounded-lg text-sm focus:ring-green-500">
                        <option value="">Semua Status</option>
                        <option value="buka" <?= ($filters['status'] ?? '') == 'buka' ? 'selected' : '' ?>>
                            Pendaftaran Buka</option>
                        <option value="tutup" <?= ($filters['status'] ?? '') == 'tutup' ? 'selected' : '' ?>>Sudah
                            Tutup</option>
                    </select>
                </div>
            </form>

            <h3 class="font-bold text-gray-900 text-sm mb-3 uppercase tracking-wider">Layanan Advokasi</h3>
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 text-center">
                <p class="text-xs text-blue-700 mb-3 leading-relaxed">Butuh bantuan terkait kendala administrasi
                    beasiswa?</p>
                <a href="https://wa.me/nomor-advokasi" target="_blank"
                    class="inline-flex items-center justify-center w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                    <i class="fas fa-comments mr-2"></i> Tanya Advokasi
                </a>
            </div>
        </div>
    </aside>

    <!-- Grid Beasiswa -->
    <div class="w-full md:w-3/4">
        <?php if (!empty($beasiswa_list)): ?>
        <div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-6">
            <?php foreach ($beasiswa_list as $beasiswa): ?>
            <?php 
                $tgl_buka = $beasiswa['tanggal_buka'] ?? null;
                $tgl_tutup = $beasiswa['tanggal_tutup'] ?? null;
                $is_open = $tgl_tutup ? (strtotime($tgl_tutup) >= time()) : false;
                $status_badge_class = $is_open ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                $status_text = $is_open ? 'Buka' : 'Tutup';
            ?>
            <a href="<?= base_url('beasiswa/detail/' . $beasiswa['id']) ?>"
                class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col">

                <div class="relative h-48 bg-gray-50 overflow-hidden">
                    <div class="absolute top-3 left-3 z-10">
                        <span class="<?= $status_badge_class ?> text-[10px] font-bold px-3 py-1 rounded-full uppercase">
                            <?= $status_text ?>
                        </span>
                    </div>

                    <?php if (!empty($beasiswa['poster'])): ?>
                    <img src="<?= esc($beasiswa_base_url . $beasiswa['poster']) ?>"
                        alt="<?= esc($beasiswa['nama_beasiswa']) ?>"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <?php else: ?>
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                        <i class="fas fa-graduation-cap text-5xl mb-2"></i>
                        <span class="text-xs italic text-gray-400">Poster tidak tersedia</span>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900 group-hover:text-green-700 transition-colors line-clamp-2 mb-2">
                        <?= esc($beasiswa['nama_beasiswa']) ?>
                    </h3>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-4">
                        <?= esc($beasiswa['deskripsi']) ?>
                    </p>

                    <div class="mt-auto pt-4 border-t border-gray-50 flex flex-col gap-1">
                        <div class="flex items-center justify-between text-[10px] font-medium text-gray-400">
                            <span>
                                <i class="far fa-calendar-alt mr-1"></i>
                                <?= $tgl_buka ? date('d M', strtotime($tgl_buka)) : '?' ?> -
                                <?= $tgl_tutup ? date('d M Y', strtotime($tgl_tutup)) : '?' ?>
                            </span>
                            <span class="text-green-600 font-bold uppercase tracking-wider">
                                Detail <i class="fas fa-arrow-right ml-1"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-20 text-center">
                <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500">Beasiswa tidak ditemukan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


</main>
<?php $this->endSection() ?>