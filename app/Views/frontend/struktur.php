<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>
<header class="pt-24 pb-12 bg-white">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <span class="inline-block px-4 py-1.5 bg-orange-50 text-orange-600 text-xs font-bold rounded-full mb-4 tracking-widest uppercase">Eksplorasi</span>
        <h1 class="text-4xl md:text-5xl font-extrabold text-black mb-4">Struktur Kabinet</h1>
        <div class="h-1.5 w-24 bg-orange-500 mx-auto rounded-full mb-6"></div>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Mengenal lebih dekat struktur pimpinan <span class="text-orange-600 font-bold"><?= esc($profil['nama_kabinet'] ?? 'BEM KM PNP') ?></span><br>
            Periode <?= esc($profil['periode'] ?? '') ?>
        </p>
    </div>
</header>

<section class="py-12 max-w-7xl mx-auto px-6">
    
    <!-- Filter & Search Bar -->
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 mb-12">
        <form action="<?= base_url('struktur') ?>" method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Input Pencarian Nama -->
            <div class="flex-grow relative">
                <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="<?= esc($filters['search'] ?? '') ?>" 
                       placeholder="Cari nama pengurus..." 
                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 transition-all">
            </div>

            <!-- Filter Kategori/Kementerian -->
            <div class="w-full md:w-64">
                <select name="kementerian" onchange="this.form.submit()" 
                        class="w-full py-3 px-4 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 transition-all">
                    <option value="">Semua Kementerian</option>
                    <?php 
                    $list_kemen = ['kepresidenan', 'audit_internal', 'kesekretariatan', 'keuangan', 'psdm', 'adkesma', 'sosmas', 'dagri', 'mitbis', 'lugri', 'kastrat', 'komris', 'pp'];
                    foreach($list_kemen as $k): ?>
                        <option value="<?= $k ?>" <?= (isset($filters['kementerian']) && $filters['kementerian'] == $k) ? 'selected' : '' ?>>
                            <?= ucwords(str_replace('_', ' ', $k)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tombol Reset/Cari -->
            <button type="submit" class="bg-orange-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-orange-700 transition-all shadow-lg shadow-orange-200">
                Cari
            </button>
            <?php if(!empty($filters['search']) || !empty($filters['kementerian'])): ?>
                <a href="<?= base_url('struktur') ?>" class="bg-gray-100 text-gray-500 px-4 py-3 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-all">
                    Reset
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Judul Hasil -->
    <div class="mb-12 border-l-8 border-orange-500 pl-6">
        <h2 class="text-3xl font-bold text-slate-800 uppercase tracking-wider">
            <?= !empty($filters['kementerian']) ? str_replace('_', ' ', $filters['kementerian']) : 'Daftar Pengurus' ?>
        </h2>
        <?php if(!empty($filters['search'])): ?>
            <p class="text-orange-600 font-medium">Hasil pencarian untuk: "<?= esc($filters['search']) ?>"</p>
        <?php endif; ?>
    </div>

    <?php if (!empty($pengurus)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php foreach ($pengurus as $p): ?>
        <div class="group bg-white rounded-[2rem] shadow-md border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
            <div class="aspect-[3/4] overflow-hidden relative">
                <img src="<?= base_url('uploads/pengurus/' . ($p['foto'] ?? 'default.jpg')) ?>"
                    alt="<?= esc($p['nama']) ?>"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-orange-600/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6 text-white text-sm italic">
                    "Berkarya nyata untuk almamater!"
                </div>
            </div>

            <div class="p-6 text-center">
                <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-orange-600 transition-colors">
                    <?= esc($p['nama']) ?>
                </h3>
                <p class="text-orange-600 font-bold text-xs uppercase tracking-widest mb-2">
                    <?= esc($p['jabatan']) ?>
                </p>
                <div class="h-1 w-10 bg-slate-100 mx-auto rounded-full group-hover:w-20 group-hover:bg-orange-200 transition-all duration-500"></div>
                <p class="mt-3 text-slate-400 text-[10px] font-bold uppercase tracking-tighter">
                    <?= str_replace('_', ' ', $p['kementerian']) ?>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-20 bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
        <p class="text-slate-500 font-medium">Data pengurus tidak ditemukan.</p>
    </div>
    <?php endif; ?>
</section>
<?php $this->endSection() ?>