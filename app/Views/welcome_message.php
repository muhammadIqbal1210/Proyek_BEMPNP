<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>
<section class=" h-[90vh] bg-cover bg-center bg-no-repeat"
    style="background-image: url('<?= base_url('home.jpg') ?>');">
    <div
        class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-center items-center text-center text-white px-6">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2 tracking-tight">Badan Eksekutif Mahasiswa</h1>
        <p class="text-2xl md:text-3xl font-bold mb-1 max-w-2xl ">Keluarga Mahasiswa</p>
        <p class="text-lg md:text-xl mb-8 max-w-2xl text-orange-400">Politeknik Negeri Padang</p>

        <div class="flex gap-4">
            <a href="<?= base_url('profil') ?>"
                class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-full shadow-lg transform hover:-translate-y-1 transition duration-300">
                Pelajari Selengkapnya
            </a>
            <a href="<?= base_url('pengumuman') ?>"
                class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 font-bold px-8 py-3 rounded-full transition duration-300">
                Lihat Pengumuman
            </a>
        </div>
    </div>
</section>
<!-- AGENDA TERDEKAT SECTION -->
<section id="update" class="py-16 sm:py-20 md:py-24 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header Section -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">
                AGENDA <span class="text-green-600">TERDEKAT</span>
            </h2>
            <div class="w-16 h-1.5 bg-green-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Calendar Container -->
        <div class="bg-white p-6 sm:p-10 rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 group" data-aos="fade-up" data-aos-delay="200">
            <div class="relative overflow-hidden">
                <!-- Wrapper for Marquee Effect -->
                <div class="flex animate-marquee whitespace-nowrap hover:[animation-play-state:paused] cursor-pointer">
                    
                    <?php if (!empty($upcoming_events)): ?>
                        <!-- Generate Events Twice for Seamless Loop -->
                        <?php for ($i = 0; $i < 3; $i++): ?>
                            <div class="flex items-center space-x-12 px-6">
                                <?php foreach ($upcoming_events as $event): 
                                    $tgl = strtotime($event['waktu']);
                                    
                                ?>
                                    <div class="flex items-center space-x-5 min-w-[300px] py-4 px-6 rounded-2xl hover:bg-green-50 transition-colors duration-300">
                                        <!-- Date Badge -->
                                        <div class="flex-shrink-0 text-center bg-gradient-to-br from-green-600 to-green-400 text-white rounded-xl p-3 w-16 sm:w-20 shadow-lg shadow-green-200">
                                            <p class="text-2xl sm:text-3xl font-black leading-none"><?= date('d', $tgl) ?></p>
                                            <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider mt-1"><?= date('M', $tgl) ?></p>
                                        </div>
                                        
                                        <!-- Event Details -->
                                        <div class="whitespace-normal">
                                            <h4 class="font-bold text-gray-900 text-lg leading-tight hover:text-orange-600 transition-colors line-clamp-1">
                                                <?= esc($event['nama_event']) ?>
                                            </h4>
                                            <div class="flex flex-col mt-1">
                                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest flex items-center">
                                                </span>
                                                <span class="text-xs font-medium text-orange-600/70 mt-0.5">
                                                    <?= esc($event['biaya'] == 'gratis' ? 'Free Admission' : 'Berbayar') ?>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Action Link (Optional hidden icon) -->
                                        <?php if (!empty($event['link_informasi'])): ?>
                                            <a href="<?= esc($event['link_informasi']) ?>" class="flex-shrink-0 text-gray-300 hover:text-orange-500 transition-colors">
                                                <i class="fas fa-external-link-alt text-sm"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endfor; ?>
                    <?php else: ?>
                        <!-- Empty State -->
                        <div class="w-full text-center py-10">
                            <p class="text-gray-400 font-medium italic">Belum ada agenda terdekat saat ini.</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- View All Link -->
        <div class="mt-10 text-center" data-aos="fade-up" data-aos-delay="400">
            <a href="<?= base_url('event') ?>" class="inline-flex items-center space-x-2 text-sm font-bold text-gray-500 hover:text-orange-600 transition-all uppercase tracking-[0.2em]">
                <span>Lihat Kalender Lengkap</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</section>
<!-- SAMBUTAN PIMPINAN SECTION -->
<section class="max-w-10xl mx-auto px-6 mx-auto bg-white pt-24 pb-20">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-extrabold text-gray-800">Sambutan Pimpinan</h2>
        <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-l">
            Sambutan dari Presiden dan Wakil Presiden Mahasiswa BEM KM Politeknik Negeri Padang
            <?= esc($profil_list['periode']) ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto mb-12">
        <div
            class="bg-white p-10 rounded-[2rem] text-center flex flex-col items-center">
            <div class="w-32 h-32 rounded-full overflow-hidden mb-6 shadow-md">
                <img src="<?= base_url('uploads/pengurus/' . ($presma['foto'] ?? 'default.jpg')) ?>"
                    alt="Presiden Mahasiswa" class="w-full h-full object-cover">
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-1">
                <?= esc($presma['nama'] ?? 'Nama Tidak Set') ?>
            </h3>
            <p class="text-green-700 font-bold mb-4 text-sm">
                Presiden Mahasiswa BEM KM PNP <?= esc($profil_list['periode'] ?? '') ?>
            </p>

            <p class="text-gray-600 italic leading-relaxed text-sm max-w-xs">
                "<?= esc($profil_list['s_pres'] ?? 'Mari bersama-sama mewujudkan harmoni...') ?>"
            </p>
        </div>

        <div
            class="bg-white p-10 rounded-[2rem] text-center flex flex-col items-center">
            <div class="w-32 h-32 rounded-full overflow-hidden mb-6 shadow-md">
                <img src="<?= base_url('uploads/pengurus/' . ($wapresma['foto'] ?? 'default.jpg')) ?>"
                    alt="Wakil Presiden Mahasiswa" class="w-full h-full object-cover">
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-1">
                <?= esc($wapresma['nama'] ?? 'Nama Tidak Set') ?>
            </h3>
            <p class="text-orange-700 font-bold mb-4 text-sm">
                Wakil Presiden Mahasiswa BEM KM PNP <?= esc($profil_list['periode'] ?? '') ?>
            </p>

            <p class="text-gray-600 italic leading-relaxed text-sm max-w-xs">
                "<?= esc($profil_list['s_wapres'] ?? 'Sinergi dan integritas adalah kunci utama...') ?>"
            </p>
        </div>
    </div>
</section>
<!-- Video profil-->
 <section class="max-w-4xl mx-auto px-6 mb-20 pt-24 pb-20">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold text-gray-800">Video Profil <?= esc($profil_list['nama_kabinet']) ?></h2>
        <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-l">
            Saksikan video profil resmi BEM KM Politeknik Negeri Padang
            <?= esc($profil_list['periode']) ?>
        </p>
    </div>
    <div class="bg-black rounded-[2.5rem] overflow-hidden shadow-2xl relative group">
        <?php 
                $url = $profil_list['videoprofil'];
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
                <p class="text-gray-400 italic">Video profil <?= esc($profil_list['nama_kabinet']) ?> belum tersedia.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- PENGUMUMAN TERBARU SECTION -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <!-- Judul Section -->
         <div class="text-center mb-6" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">
                PENGUMUMAN <span class="text-green-600">TERBARU</span>
            </h2>
            <div class="w-16 h-1.5 bg-green-600 mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
            <div class="text-left">
                <p class="text-gray-500 mt-4 max-w-md">Informasi resmi, kebijakan kampus, dan agenda kegiatan organisasi
                    terbaru.</p>
            </div>
            <a href="<?= base_url('pengumuman') ?>"
                class="mt-6 md:mt-0 group inline-flex items-center text-green-700 font-bold hover:text-green-800 transition-all">
                Lihat Semua Pengumuman
                <span
                    class="ml-2 flex h-8 w-8 items-center justify-center rounded-full bg-green-100 group-hover:bg-green-600 group-hover:text-white transition-all">
                    <i class="fas fa-arrow-right text-xs"></i>
                </span>
            </a>
        </div>
        <div class="grid md:grid-cols- lg:grid-cols-2 gap-8">
            <?php if (!empty($latest_announcements)): foreach ($latest_announcements as $pengumuman): ?>
            <div
                class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transform hover:scale-[1.01] transition duration-300 flex flex-col h-full">

                <!-- Area Preview File (Gambar / PDF / Doc) -->
                <div class="w-full h-56 bg-gray-100 relative overflow-hidden group">
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
                    <!-- Menggunakan tag <object> untuk render PDF langsung di card -->
                    <object data="<?= $fullPath ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf"
                        class="w-full h-full">
                        <div class="flex flex-col items-center justify-center h-full bg-red-50 text-red-600 p-4">
                            <i class="fas fa-file-pdf text-5xl mb-2"></i>
                            <span class="text-xs font-bold uppercase text-center">Preview PDF Tersedia</span>
                        </div>
                    </object>
                    <!-- Overlay transparan agar card tetap bisa diklik meskipun ada object PDF -->
                    <div class="absolute inset-0 z-10 cursor-pointer"></div>

                    <?php // KATEGORI 3: DOKUMEN LAIN (Word, Excel)
                        else: 
                            $bgBox = (in_array($extension, ['docx', 'doc'])) ? 'bg-blue-600' : ($extension == 'xlsx' ? 'bg-green-600' : 'bg-gray-700');
                        ?>
                    <div class="w-full h-full flex flex-col items-center justify-center <?= $bgBox ?> text-white p-6">
                        <i
                            class="fas <?= ($extension == 'xlsx') ? 'fa-file-excel' : 'fa-file-word' ?> text-6xl mb-3"></i>
                        <span
                            class="bg-white text-black px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                            <?= $extension ?>
                        </span>
                    </div>
                    <?php endif; ?>

                    <!-- Floating Badge Lampiran -->
                    <span
                        class="absolute top-3 right-3 z-20 bg-orange-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md">
                        <i class="fas fa-paperclip mr-1"></i> BERKAS
                    </span>
                    <?php else: ?>
                    <!-- JIKA TIDAK ADA FILE SAMA SEKALI -->
                    <div
                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-500 to-green-600">
                        <i class="fas fa-bullhorn text-7xl text-white opacity-20"></i>
                    </div>
                    <?php endif; ?>

                    <!-- Link Overlay ke Detail -->
                    <a href="<?= base_url('pengumuman/detail/' . $pengumuman['id']) ?>"
                        class="absolute inset-0 z-30"></a>
                </div>

                <!-- Bagian Konten Teks -->
                <div class="p-6 flex-grow flex flex-col">
                    <div class="flex items-center text-[11px] text-gray-500 mb-2 font-semibold">
                        <i class="fas fa-calendar-alt mr-2 text-orange-500"></i>
                        <?= date('d M Y', strtotime($pengumuman['tanggal_publikasi'] ?? $pengumuman['created_at'])) ?>
                    </div>

                    <h3
                        class="font-bold text-lg mb-2 text-gray-900 leading-tight line-clamp-2 hover:text-green-700 transition-colors">
                        <a href="<?= base_url('pengumuman/detail/' . $pengumuman['id']) ?>">
                            <?= htmlspecialchars($pengumuman['title']) ?>
                        </a>
                    </h3>

                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-2">
                        <?php 
                        $snippet = strip_tags($pengumuman['content'] ?? 'Tidak ada deskripsi.');
                        echo (strlen($snippet) > 100) ? substr($snippet, 0, 100) . '...' : $snippet;
                    ?>
                    </p>

                    <div class="pt-4 border-t border-gray-100 mt-auto">
                        <a href="<?= base_url('pengumuman/detail/' . $pengumuman['id']) ?>"
                            class="text-orange-600 hover:text-orange-700 font-bold text-sm inline-flex items-center group">
                            Baca Pengumuman
                            <i
                                class="fas fa-arrow-right ml-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="col-span-full py-10 text-center text-gray-400 border-2 border-dashed rounded-xl">
                Belum ada pengumuman terbaru.
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee {
        display: flex;
        width: max-content;
        animation: marquee 30s linear infinite;
    }
    /* Mencegah teks terpotong saat hover */
    .whitespace-normal {
        white-space: normal;
    }
</style>
<?php $this->endSection() ?>