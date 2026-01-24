<!-- File: app/Views/public/kontak.php -->
<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>

<!-- Header Section -->
<header class="pt-24 pb-12 bg-white mb-12">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-black mb-4">Kontak Penting</h1>
        <div class="h-1.5 w-24 bg-orange-500 mx-auto rounded-full mb-6"></div>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto">
            Hubungi Kontak Penting BEM KM Politeknik Negeri Padang untuk berbagai keperluan informasi dan layanan mahasiswa.
        </p>
    </div>
</header>

<main class="max-w-6xl mx-auto px-6 pb-24">
    <?php if (!empty($kontak_list)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
            <?php foreach ($kontak_list as $k): ?>
                <div class="bg-white p-10 rounded-[1.5rem] shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition-all duration-300 min-h-full">
                    
                    <!-- Top Icon -->
                    <div class="mb-8 text-green-600">
                        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
                            <i class="fa-solid fa-phone text-xl"></i>
                        </div>
                    </div>

                    <!-- Content (Left Aligned) -->
                    <div class="text-left mb-6">
                        <h3 class="text-xl font-bold text-slate-800 mb-3 leading-tight">
                            <?= esc($k['nama']) ?>
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6">
                            <?= esc($k['deskripsi']) ?>
                        </p>
                    </div>

                    <!-- Action Links (Directly below description) -->
                    <div class="space-y-4">
                        <!-- Instagram -->
                        <?php if (!empty($k['instagram'])): ?>
                        <a href="<?= esc($k['instagram']) ?>" target="_blank" class="flex items-center group">
                            <i class="fa-brands fa-instagram text-slate-700 w-6 group-hover:text-pink-600 transition-colors"></i>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-pink-600 ml-2">
                                <?= esc($k['subjek_ig'] ?: 'Instagram') ?>
                            </span>
                        </a>
                        <?php endif; ?>

                        <!-- WhatsApp -->
                        <?php if (!empty($k['whatsApp'])): ?>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $k['whatsApp']) ?>" target="_blank" class="flex items-center group">
                            <i class="fa-brands fa-whatsapp text-slate-700 w-6 group-hover:text-green-600 transition-colors"></i>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-green-600 ml-2">
                                <?= esc($k['subjek_wa'] ?: 'WhatsApp Admin') ?>
                            </span>
                        </a>
                        <?php endif; ?>

                        <!-- Email -->
                        <?php if (!empty($k['email'])): ?>
                        <a href="mailto:<?= esc($k['email']) ?>" class="flex items-center group">
                            <i class="fa-regular fa-envelope text-slate-700 w-6 group-hover:text-blue-600 transition-colors"></i>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-blue-600 ml-2">
                                <?= esc($k['subjek_email'] ?: esc($k['email'])) ?>
                            </span>
                        </a>
                        <?php endif; ?>

                        <!-- Website / Link -->
                        <?php if (!empty($k['website'])): ?>
                        <a href="<?= esc($k['website']) ?>" target="_blank" class="flex items-center group">
                            <i class="fa-solid fa-arrow-up-right-from-square text-slate-700 w-6 group-hover:text-green-700 transition-colors text-xs"></i>
                            <span class="text-sm font-medium text-slate-700 group-hover:text-green-700 ml-2">
                                <?= esc($k['subjek_website'] ?: 'Kunjungi Laman') ?>
                            </span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-24 bg-white rounded-[2.5rem] border border-dashed border-gray-200">
            <i class="fa-solid fa-comment-slash text-5xl text-gray-200 mb-4"></i>
            <p class="text-gray-500 font-medium">Data layanan belum tersedia.</p>
        </div>
    <?php endif; ?>
</main>

<?php $this->endSection() ?>