<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>

<!-- Header Section -->

<header class="pt-24 pb-12 bg-white">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <span
            class="inline-block px-4 py-1.5 bg-orange-50 text-orange-600 text-xs font-bold rounded-full mb-4 tracking-widest uppercase">Eksplorasi</span>
        <h1 class="text-4xl md:text-5xl font-extrabold text-black mb-4">Profil Organisasi</h1>
        <div class="h-1.5 w-24 bg-orange-500 mx-auto rounded-full mb-6"></div>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Mengenal lebih dekat struktur pimpinan dan arah gerak BEM KM Politeknik Negeri Padang

            <?= esc($profil_list[0]['nama_kabinet'] ?? 'Nama Kabinet Tidak ada') ?>
            Periode <?= esc($profil_list[0]['periode'] ?? '') ?>

        </p>
    </div>
</header>

<?php if (!empty($profil_list)): ?>

<?php foreach ($profil_list as $profil): ?>

<!-- SECTION 1: Video Profil (Full Width Style) -->
<section class="max-w-6xl mx-auto px-6 mb-20">
    <div class="bg-black rounded-[2.5rem] overflow-hidden shadow-2xl relative group">
        <?php 
                $url = $profil['videoprofil'];
                $video_id = '';
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                    $video_id = $match[1];
                }
            ?>
        <div class="aspect-video w-full">
            <?php if (!empty($video_id)) : ?>
            <iframe class="w-full h-full" src="https://www.youtube.com/embed/<?= esc($video_id) ?>" frameborder="0"
                allowfullscreen></iframe>
            <?php else : ?>
            <div class="flex flex-col items-center justify-center h-full text-white p-10">
                <i class="fab fa-youtube text-6xl text-red-600 mb-4"></i>
                <p class="text-gray-400 italic">Video profil <?= esc($profil['nama_kabinet']) ?> belum tersedia.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- SECTION 2: Kata Sambutan Pimpinan -->
<section class="max-w-7xl mx-auto px-6 mx-auto">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-extrabold text-gray-800">Sambutan Pimpinan</h2>
        <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-l">
            Sambutan dari Presiden dan Wakil Presiden Mahasiswa BEM KM Politeknik Negeri Padang
            <?= esc($profil['periode']) ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto mb-12">
        <div
            class="bg-white p-10 rounded-[2rem] shadow-lg border border-gray-100 text-center flex flex-col items-center">
            <div class="w-32 h-32 rounded-full overflow-hidden mb-6 shadow-md">
                <img src="<?= base_url('uploads/pengurus/' . ($presma['foto'] ?? 'default.jpg')) ?>"
                    alt="Presiden Mahasiswa" class="w-full h-full object-cover">
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-1">
                <?= esc($presma['nama'] ?? 'Nama Tidak Set') ?>
            </h3>
            <p class="text-green-700 font-bold mb-4 text-sm">
                Presiden Mahasiswa BEM KM PNP <?= esc($profil['periode'] ?? '') ?>
            </p>

            <p class="text-gray-600 italic leading-relaxed text-sm max-w-xs">
                "<?= esc($profil['s_pres'] ?? 'Mari bersama-sama mewujudkan harmoni...') ?>"
            </p>
        </div>

        <div
            class="bg-white p-10 rounded-[2rem] shadow-lg border border-gray-100 text-center flex flex-col items-center">
            <div class="w-32 h-32 rounded-full overflow-hidden mb-6 shadow-md">
                <img src="<?= base_url('uploads/pengurus/' . ($wapresma['foto'] ?? 'default.jpg')) ?>"
                    alt="Wakil Presiden Mahasiswa" class="w-full h-full object-cover">
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-1">
                <?= esc($wapresma['nama'] ?? 'Nama Tidak Set') ?>
            </h3>
            <p class="text-orange-700 font-bold mb-4 text-sm">
                Wakil Presiden Mahasiswa BEM KM PNP <?= esc($profil['periode'] ?? '') ?>
            </p>

            <p class="text-gray-600 italic leading-relaxed text-sm max-w-xs">
                "<?= esc($profil['s_wapres'] ?? 'Sinergi dan integritas adalah kunci utama...') ?>"
            </p>
        </div>
    </div>
    <!-- Untuk struktur lain -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-3xl mx-auto ">
        <div
            class="bg-white p-8 rounded-[2rem] shadow-lg border border-gray-100 text-center flex flex-col items-center">
            <div class="w-32 h-32 rounded-full overflow-hidden mb-6 shadow-md">
                <img src="<?= base_url('uploads/pengurus/' . ($sesneg['foto'] ?? 'default.jpg')) ?>"
                    alt="Sekretaris Negara" class="w-full h-full object-cover">
            </div>

            <h3 class="text-l font-bold text-gray-800">
                <?= esc($sesneg['nama'] ?? 'Nama Tidak Set') ?>
            </h3>
            <p class="text-gray-500 font-medium mb-4 text-sm">
                Sekretaris Negara BEM KM PNP <?= esc($profil['periode'] ?? '') ?>
            </p>
        </div>

        <div
            class="bg-white p-8 rounded-[2rem] shadow-lg border border-gray-100 text-center flex flex-col items-center">
            <div class="w-32 h-32 rounded-full overflow-hidden mb-6 shadow-md">
                <img src="<?= base_url('uploads/pengurus/' . ($menkoper['foto'] ?? 'default.jpg')) ?>"
                    alt="Menteri Koordinator Pergerakan" class="w-full h-full object-cover">
            </div>

            <h3 class="text-l font-bold text-gray-800">
                <?= esc($menkoper['nama'] ?? 'Nama Tidak Set') ?>
            </h3>
            <p class="text-gray-500 font-medium mb-4 text-sm">
                Menteri Koordinator Pergerakan BEM KM PNP <?= esc($profil['periode'] ?? '') ?>
            </p>
        </div>
        <div
            class="bg-white p-8 rounded-[2rem] shadow-lg border border-gray-100 text-center flex flex-col items-center">
            <div class="w-32 h-32 rounded-full overflow-hidden mb-6 shadow-md">
                <img src="<?= base_url('uploads/pengurus/' . ($menkopp['foto'] ?? 'default.jpg')) ?>"
                    alt="Menteri Koordinator Pelayanan dan Pengabdian" class="w-full h-full object-cover">
            </div>

            <h3 class="text-l font-bold text-gray-800">
                <?= esc($menkopp['nama'] ?? 'Nama Tidak Set') ?>
            </h3>
            <p class="text-gray-500 font-medium text-sm">
                Menteri Koordinator Pelayanan dan Pengabdian BEM KM PNP <?= esc($profil['periode'] ?? '') ?>
            </p>
        </div>
    </div>
</section>

<!-- SECTION 3: Visi & Misi -->
<section data-aos="fade-up" class="max-w-6xl mx-auto px-6 py-20">
    <h2 class="text-2xl md:text-4xl font-extrabold text-gray-900 mb-12 text-center uppercase tracking-tight">
        Visi & Misi BEM KM PNP PERIODE <?= esc($profil['periode']) ?>
    </h2>

    <div class="grid lg:grid-cols-2 gap-12 items-stretch ">
        <div class="bg-green-700 text-white p-10 rounded-[2.5rem] shadow-xl flex flex-col justify-center text-center transform transition-hover hover:scale-[1.02]"
            data-aos="zoom-in">
            <div class="mb-6">
                <span class="bg-white/20 px-4 py-1 rounded-full text-xs font-bold tracking-widest uppercase">Visi
                    Kabinet</span>
            </div>
            <h3 class="text-2xl font-black mb-6 uppercase tracking-wider text-green-100">
                <?= esc($profil['nama_kabinet']) ?>
            </h3>
            <blockquote class="text-xl md:text-2xl font-medium leading-relaxed italic">
                “<?= esc($profil['visi']) ?>”
            </blockquote>
        </div>

        <div class="space-y-6" data-aos="fade-left" data-aos-delay="200">
            <div class="text-center lg:text-left mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Misi Strategis</h3>
                <div class="h-1 w-20 bg-green-500 mt-2 mx-auto lg:mx-0 rounded-full"></div>
            </div>

            <div class="space-y-4">
                <?php 
                    $misi = json_decode($profil['misi'], true);
                    if (is_array($misi)):
                        foreach ($misi as $idx => $m): 
                ?>
                <div
                    class="bg-white p-5 rounded-2xl shadow-md border border-gray-100 flex items-start space-x-4 group hover:border-green-500 transition-colors">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center font-bold text-lg group-hover:bg-green-600 group-hover:text-white transition-all">
                        <?= $idx + 1 ?>
                    </div>
                    <div class="flex-grow">
                        <p class="text-gray-700 leading-relaxed font-medium">
                            <?= esc($m) ?>
                        </p>
                    </div>
                </div>
                <?php 
                        endforeach;
                    endif; 
                ?>
            </div>
        </div>
    </div>
</section>

<?php endforeach; ?>


<?php else: ?>

<div class="text-center py-20">
    <p class="text-gray-500">Data profil belum tersedia.</p>
</div>


<?php endif; ?>

<?php $this->endSection() ?>