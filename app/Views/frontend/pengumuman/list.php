<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>
<!-- Header Halaman -->
<header class="pt-16 pb-12 mb-10">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-extrabold text-black mb-2 pb-2 border-b-4 border-orange-400 inline-block">Pusat Informasi Pengumuman</h1>
        <p class="text-black-200 text-lg">Semua pengumuman resmi dan terkini dari Badan Eksekutif Mahasiswa KM Politeknik Negeri Padang.</p>
    </div>
</header>

<main class="max-w-6xl mx-auto px-6 py-8">
    <?php if (isset($pengumuman_list) && is_array($pengumuman_list) && count($pengumuman_list) > 0): ?>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php foreach ($pengumuman_list as $pengumuman): ?>
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-[1.01] transition duration-300 flex flex-col">
            
            <!-- Area Preview -->
            <div class="w-full h-56 bg-gray-100 relative overflow-hidden">
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
                            <!-- Menggunakan tag <object> lebih stabil daripada iframe google untuk file lokal -->
                            <object data="<?= $fullPath ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" class="w-full h-full">
                                <div class="flex flex-col items-center justify-center h-full bg-red-50 text-red-600 p-4">
                                    <i class="fas fa-file-pdf text-5xl mb-2"></i>
                                    <span class="text-xs font-bold uppercase text-center">Preview PDF Tersedia</span>
                                    <span class="text-[10px] text-gray-500 mt-1">Klik untuk detail</span>
                                </div>
                            </object>
                            <!-- Overlay transparan agar card bisa diklik -->
                            <div class="absolute inset-0 z-10 cursor-pointer"></div>
                        
                        <?php // KATEGORI 3: DOKUMEN LAIN (Word, Excel, dll)
                        else: 
                            $bgBox = ($extension == 'docx' || $extension == 'doc') ? 'bg-blue-600' : ($extension == 'xlsx' ? 'bg-green-600' : 'bg-gray-700');
                        ?>
                            <div class="w-full h-full flex flex-col items-center justify-center <?= $bgBox ?> text-white p-6">
                                <i class="fas <?= ($extension == 'xlsx') ? 'fa-file-excel' : 'fa-file-word' ?> text-6xl mb-3 shadow-sm"></i>
                                <span class="bg-white text-black px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                                    <?= $extension ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <!-- Tag Lampiran -->
                        <span class="absolute top-3 right-3 z-20 bg-orange-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md">
                            <i class="fas fa-paperclip mr-1"></i> BERKAS
                        </span>
                    <?php else: ?>
                        <!-- JIKA TIDAK ADA FILE -->
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-500 to-green-600">
                            <i class="fas fa-bullhorn text-7xl text-white opacity-20"></i>
                        </div>
                    <?php endif; ?>
                
                <a href="<?= base_url('pengumuman/detail/' . $pengumuman['id']) ?>" class="absolute inset-0 z-30"></a>
            </div>

            <!-- Konten -->
            <div class="p-6 flex-grow flex flex-col">
                <div class="flex items-center text-[11px] text-gray-500 mb-2 font-semibold">
                    <i class="fas fa-calendar-alt mr-2 text-orange-500"></i>
                    <?= date('d M Y', strtotime($pengumuman['tanggal_publikasi'] ?? $pengumuman['created_at'] ?? 'now')) ?>
                </div>

                <h3 class="font-bold text-lg mb-2 text-gray-900 leading-tight line-clamp-2">
                    <?= htmlspecialchars($pengumuman['title']) ?>
                </h3>

                <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-2 flex-grow">
                    <?= substr(strip_tags($pengumuman['content'] ?? 'Tidak ada deskripsi.'), 0, 100) ?>...
                </p>

                <div class="pt-4 border-t border-gray-100 mt-auto">
                    <a href="<?= base_url('pengumuman/detail/' . $pengumuman['id']) ?>"
                        class="text-orange-600 hover:text-orange-700 font-bold text-sm inline-flex items-center group">
                        Baca Pengumuman
                        <i class="fas fa-arrow-right ml-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center">
        <?= $pager->links('pengumuman', 'default_full') ?>
    </div>
    <?php endif; ?>
</main>
<?php $this->endSection() ?>