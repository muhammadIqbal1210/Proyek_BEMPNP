<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>
<?php
    $profil_list = is_array($profil_list ?? null) ? $profil_list : [];
    $profil_list += [
        'periode'      => '',
        'nama_kabinet' => 'BEM KM PNP',
        's_pres'       => 'Mari bersama-sama mewujudkan harmoni...',
        's_wapres'     => 'Sinergi dan integritas adalah kunci utama...',
        'videoprofil'  => '',
    ];
?>
<section class="-mt-24 min-h-[calc(100vh-4rem)] sm:min-h-[calc(100vh-4rem)] w-screen overflow-hidden bg-cover bg-center bg-no-repeat pt-24 pb-20"
    style="background-image: url('<?= base_url('home.png') ?>');">
    <div
        class=" flex flex-col justify-center items-center text-center text-white px-6 py-16 sm:py-24">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-2 tracking-tight" data-aos="fade-down">Badan Eksekutif Mahasiswa</h1>
        <p class="text-xl sm:text-2xl md:text-3xl font-bold mb-1 max-w-xl" data-aos="fade-down" data-aos-delay="200">Keluarga Mahasiswa</p>
        <p class="text-base sm:text-lg md:text-xl mb-8 max-w-xl text-orange-400" data-aos="fade-down" data-aos-delay="400">Politeknik Negeri Padang</p>

        <div class="flex flex-col md:flex-row gap-4 w-full max-w-sm md:max-w-md justify-center mx-auto px-6" data-aos="fade-up" data-aos-delay="600">
            <a href="<?= base_url('profil') ?>"
                class="w-full md:w-auto text-center bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-full shadow-lg transform hover:-translate-y-1 transition duration-300 whitespace-nowrap text-sm sm:text-base">
                Pelajari Selengkapnya
            </a>
            <?php if (session()->get('isLoggedIn')): ?>
                <a href="<?= base_url(session()->get('role') === 'admin' ? 'admin/dashboard' : 'member/dashboard') ?>"
                    class="w-full md:w-auto text-center bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 font-bold px-8 py-3 rounded-full transition duration-300 whitespace-nowrap text-sm sm:text-base">
                    Dashboard Saya
                </a>
            <?php else: ?>
                <a href="<?= base_url('pengumuman') ?>"
                    class="w-full md:w-auto text-center bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 font-bold px-8 py-3 rounded-full transition duration-300 whitespace-nowrap text-sm sm:text-base">
                    Lihat Pengumuman
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- AGENDA TERDEKAT SECTION -->
<section id="agenda" class="scroll-mt-24 py-10 sm:py-20 md:py-24 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-7xl mx-auto">

        <!-- Header Section -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight" data-aos="fade-down">
                Agenda <span class="text-green-600">Terdekat</span>
            </h2>
            <div class="w-16 h-1.5 bg-green-600 mx-auto mt-4 rounded-full" data-aos="fade-up" data-aos-delay="200"></div>
        </div>

        <!-- Calendar Container -->
        <?php
        $calendarEvents = [];
        if (!empty($calendar_events)) {
            foreach ($calendar_events as $event) {
                $dateKey = date('Y-m-d', strtotime($event['waktu']));
                $calendarEvents[$dateKey][] = $event;
            }
        }
        $monthName = date('F Y');
        $daysInMonth = date('t');
        $firstDayOfWeek = date('N', strtotime(date('Y-m-01')));
        $blankDays = $firstDayOfWeek - 1;
    ?>
    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8 mb-10">
        <div class="flex flex-col md:flex-row justify-between gap-4 items-start md:items-center">
            <div>
                <p class="text-sm font-semibold text-green-600 uppercase mb-2">Kalender Event</p>
                <h2 class="text-2xl md:text-3xl font-black text-gray-900">Agenda Bulan <?= esc($monthName) ?></h2>
                <p class="text-sm text-gray-500 mt-2 max-w-2xl">Tampilkan event terjadwal di kalender. Klik tanggal yang memiliki event untuk melihat detailnya.</p>
            </div>
            <div class="text-sm text-gray-500">
                <p class="font-semibold">Total event bulan ini:</p>
                <p class="text-2xl font-bold text-green-700"><?= number_format(array_sum(array_map('count', $calendarEvents))) ?></p>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-2 mt-8 text-center text-xs font-semibold text-gray-500">
            <?php foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $shortDay): ?>
                <div class="py-2 bg-gray-50 rounded-3xl"><?= esc($shortDay) ?></div>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-7 gap-2 mt-2 text-sm">
            <?php for ($i = 0; $i < $blankDays; $i++): ?>
                <div class="min-h-[5rem] rounded-3xl bg-gray-50"></div>
            <?php endfor; ?>

            <?php for ($day = 1; $day <= $daysInMonth; $day++): ?>
                <?php $dateKey = date('Y-m-') . sprintf('%02d', $day); ?>
                <?php $hasEvent = !empty($calendarEvents[$dateKey]); ?>
                <div class="min-h-[5rem] rounded-3xl border p-3 <?= $dateKey === date('Y-m-d') ? 'bg-green-50 border-green-200' : 'bg-gray-50' ?>">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-gray-800"><?= $day ?></span>
                        <?php if ($hasEvent): ?>
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-500 text-white text-[10px]"><?= count($calendarEvents[$dateKey]) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($hasEvent): ?>
                        <ul class="space-y-1 text-left text-[11px]">
                            <?php foreach (array_slice($calendarEvents[$dateKey], 0, 2) as $event): ?>
                                <li class="truncate"><a href="<?= base_url('event/detail/' . $event['id']) ?>" class="text-green-700 hover:text-green-900"><?= esc($event['nama_event']) ?></a></li>
                            <?php endforeach; ?>
                            <?php if (count($calendarEvents[$dateKey]) > 2): ?>
                                <li class="text-xs text-gray-500">+<?= count($calendarEvents[$dateKey]) - 2 ?> lainnya</li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>


        <!-- View All Link -->
        <div class="mt-10 text-center" data-aos="fade-up" data-aos-delay="600">
            <a href="<?= base_url('event') ?>"
                class="inline-flex items-center space-x-2 text-sm font-bold text-gray-500 hover:text-orange-600 transition-all uppercase tracking-[0.2em]">
                <span>Lihat Kalender Lengkap</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</section>
<!-- SAMBUTAN PIMPINAN SECTION -->
<section class="max-w-10xl mx-auto px-4 mx-auto bg-white pt-12 pb-12">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-extrabold text-gray-800">Sambutan Pimpinan</h2>
        <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-l">
            Sambutan dari Presiden dan Wakil Presiden Mahasiswa BEM KM Politeknik Negeri Padang
            <?= esc($profil_list['periode']) ?>
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto mb-12">
        <div class="bg-white p-10 rounded-[2rem] text-center flex flex-col items-center" data-aos="fade-right">
            <div class="w-32 h-32 rounded-full overflow-hidden mb-6 shadow-md" data-aos="zoom-in" data-aos-delay="200">
                <img src="<?= base_url('uploads/pengurus/' . ($presma['foto'] ?? 'default.jpg')) ?>"
                    alt="Presiden Mahasiswa" class="w-full h-full object-cover">
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-1" data-aos="fade-up" data-aos-delay="300">
                <?= esc($presma['nama'] ?? 'Nama Tidak Set') ?>
            </h3>
            <p class="text-green-700 font-bold mb-4 text-sm" data-aos="fade-up" data-aos-delay="400">
                Presiden Mahasiswa BEM KM PNP <?= esc($profil_list['periode'] ?? '') ?>
            </p>

            <p class="text-gray-600 italic leading-relaxed text-sm max-w-xs" data-aos="fade-up" data-aos-delay="500">
                "<?= esc($profil_list['s_pres'] ?? 'Mari bersama-sama mewujudkan harmoni...') ?>"
            </p>
        </div>

        <div class="bg-white p-10 rounded-[2rem] text-center flex flex-col items-center" data-aos="fade-left">
            <div class="w-32 h-32 rounded-full overflow-hidden mb-6 shadow-md" data-aos="zoom-in" data-aos-delay="200">
                <img src="<?= base_url('uploads/pengurus/' . ($wapresma['foto'] ?? 'default.jpg')) ?>"
                    alt="Wakil Presiden Mahasiswa" class="w-full h-full object-cover">
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-1" data-aos="fade-up" data-aos-delay="300">
                <?= esc($wapresma['nama'] ?? 'Nama Tidak Set') ?>
            </h3>
            <p class="text-orange-700 font-bold mb-4 text-sm" data-aos="fade-up" data-aos-delay="400">
                Wakil Presiden Mahasiswa BEM KM PNP <?= esc($profil_list['periode'] ?? '') ?>
            </p>

            <p class="text-gray-600 italic leading-relaxed text-sm max-w-xs" data-aos="fade-up" data-aos-delay="500">
                "<?= esc($profil_list['s_wapres'] ?? 'Sinergi dan integritas adalah kunci utama...') ?>"
            </p>
        </div>
    </div>
</section>
<!-- Video profil-->
<section class="max-w-4xl mx-auto px-6 mb-20 pt-16 pb-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold text-gray-800">Video Profil <?= esc($profil_list['nama_kabinet']) ?></h2>
        <p class="text-gray-600 mt-4 max-w-2xl mx-auto text-l">
            Saksikan video profil resmi BEM KM Politeknik Negeri Padang
            <?= esc($profil_list['periode']) ?>
        </p>
    </div>
    <div class="bg-black rounded-[2.5rem] overflow-hidden shadow-2xl relative group">
        <?php 
                $url = $profil_list['videoprofil'] ?? '';
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
                <p class="text-gray-400 italic">Video profil <?= esc($profil_list['nama_kabinet']) ?> belum tersedia.
                </p>
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
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight" data-aos="fade-down">
                Pengumuman <span class="text-green-600">Terbaru</span>
            </h2>
            <div class="w-16 h-1.5 bg-green-600 mx-auto mt-4 rounded-full" data-aos="fade-up" data-aos-delay="200"></div>
        </div>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12" data-aos="fade-up" data-aos-delay="400">
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
            <?php if (!empty($latest_announcements)): $index = 0; foreach ($latest_announcements as $pengumuman): ?>
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
            <?php $index++; endforeach; else: ?>
            <div class="col-span-full py-10 text-center text-gray-400 border-2 border-dashed rounded-xl">
                Belum ada pengumuman terbaru.
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- PUSAT LAYANAN SECTION -->

<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">
                Pusat Layanan Mahasiswa
            </h2>
            <div class="w-16 h-1.5 bg-green-600 mx-auto mt-4 rounded-full"></div>
            <p class="text-gray-500 mt-6 max-w-2xl mx-auto">Akses cepat berbagai layanan administrasi dan advokasi
                mahasiswa dalam satu pintu.</p>
        </div>

        <!-- Grid Container -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Layanan 1: Advokasi -->
            <a href="<?= base_url('layanan/advokasi') ?>"
                class="group p-8 bg-gray-50 rounded-[2rem] border border-gray-100 hover:bg-orange-600 transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                <div
                    class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white/20 transition-colors">
                    <i class="fas fa-hands-helping text-2xl text-orange-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-white mb-2">Advokasi</h3>
                <p class="text-sm text-gray-500 group-hover:text-white/80 leading-relaxed">Sampaikan aspirasi dan
                    kendala akademik Anda kepada kami.</p>
            </a>

            <!-- Layanan 2: Surat Menyurat -->
            <a href="<?= base_url('layanan/') ?>"
                class="group p-8 bg-gray-50 rounded-[2rem] border border-gray-100 hover:bg-green-600 transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
                <div
                    class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white/20 transition-colors">
                    <i class="fas fa-envelope-open-text text-2xl text-green-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-white mb-2">Administrasi</h3>
                <p class="text-sm text-gray-500 group-hover:text-white/80 leading-relaxed">Pengurusan surat rekomendasi
                    dan legalisir organisasi.</p>
            </a>

            <!-- Layanan 3: Beasiswa -->
            <a href="<?= base_url('beasiswa/') ?>"
                class="group p-8 bg-gray-50 rounded-[2rem] border border-gray-100 hover:bg-blue-600 transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="600">
                <div
                    class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white/20 transition-colors">
                    <i class="fas fa-graduation-cap text-2xl text-blue-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-white mb-2">Info Beasiswa</h3>
                <p class="text-sm text-gray-500 group-hover:text-white/80 leading-relaxed">Informasi bantuan biaya
                    pendidikan dan prestasi terbaru.</p>
            </a>
            <!-- Layanan 4: Peminjaman Ruangan -->
            <a href="<?= base_url('kontak/') ?>"
                class="group p-8 bg-gray-50 rounded-[2rem] border border-gray-100 hover:bg-purple-600 transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="800">
                <div
                    class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-white/20 transition-colors">
                    <i class="fas fa-building text-2xl text-purple-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-white mb-2">Fasilitas</h3>
                <p class="text-sm text-gray-500 group-hover:text-white/80 leading-relaxed">Prosedur peminjaman alat dan
                    fasilitas sekretariat BEM.</p>
            </a>
        </div> <!-- Penutup Grid -->
        <!-- Link Selengkapnya -->
        <div class="flex justify-center mt-12">
            <a href="<?= base_url('layanan') ?>"
                class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-4 rounded-full shadow-lg transform hover:-translate-y-1 transition duration-300 flex items-center justify-center w-max text-sm">
                Lihat Semua Layanan
            </a>
        </div>
    </div>
</section>
<!-- BERITA TERBARU SECTION -->
<section class="py-24 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">
                    Berita Terkini
                </h2>
                <div class="w-16 h-1.5 bg-green-600 mx-auto mt-4 rounded-full"></div>
                <p class="text-gray-500 mt-4">Dapatkan informasi terbaru seputar kegiatan, program, dan inisiatif BEM KM
                    Politeknik Negeri Padang.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php if (!empty($latest_news)): $newsIndex = 0; foreach ($latest_news as $news): ?>
            <article
                class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 group" data-aos="fade-up" data-aos-delay="<?= $newsIndex * 200 + 200 ?>">
                <div class="relative h-64 overflow-hidden">
                    <img src="<?= base_url('uploads/berita/' . ($news['gambarberita'] ?? 'default.jpg')) ?>"
                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4">
                        <span
                            class="bg-green-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest">
                            <?= esc($news['kategori'] ?? 'Update') ?>
                        </span>
                    </div>
                </div>
                <div class="p-8">
                    <div class="flex items-center text-xs text-gray-400 mb-4 font-medium">
                        <i class="far fa-calendar-alt mr-2"></i> <?= date('d M Y', strtotime($news['created_at'])) ?>
                    </div>
                    <h3
                        class="text-xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors line-clamp-2 leading-snug">
                        <?= esc($news['judulberita']) ?>
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2 mb-6">
                        <?= strip_tags($news['isiberita']) ?>
                    </p>
                    <a href="<?= base_url('berita/detail/' . $news['id']) ?>"
                        class="text-sm font-black text-gray-900 group-hover:text-orange-600 flex items-center transition-colors">
                        BACA SELENGKAPNYA <div
                            class="w-8 h-[2px] bg-gray-200 ml-3 group-hover:bg-orange-600 transition-colors"></div>
                    </a>
                </div>
            </article>
            <?php $newsIndex++; endforeach; else: ?>
            <p class="col-span-3 text-center text-gray-400 italic">Belum ada berita terbaru.</p>
            <?php endif; ?>
        </div>
        <div class="flex justify-center mt-12">
            <a href="<?= base_url('berita') ?>"
                class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-4 rounded-full shadow-lg transform hover:-translate-y-1 transition duration-300 flex items-center justify-center w-max text-sm">
                Baca Berita Lainnya
            </a>
        </div>
    </div>
</section>
<!-- KATALOG / MERCHANDISE SECTION -->
<section class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-[3rem] p-8 md:p-16 relative shadow-2xl">
            <!-- Dekorasi Background -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-green-600/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
                <div data-aos="fade-right">
                    <span class="text-orange-500 font-black tracking-[0.3em] text-xs uppercase">BEM KM PNP Store</span>
                    <h2 class="text-4xl md:text-5xl font-black text-white mt-4 leading-tight">
                        Katalog <span class="text-green-500">Mahasiswa</span> Resmi
                    </h2>
                    <p class="text-gray-400 mt-6 text-lg leading-relaxed">
                        Dari Mahasiswa untuk mahasiswa. Produk dari mahasiswa yang bisa di beli dan dijual disini, silahkan dukung dengan beli produk produk yang tersedia.
                    </p>
                    <div class="mt-10 flex flex-wrap gap-4">
                        <a href="<?= base_url('katalog') ?>"
                            class="bg-white text-gray-900 font-black px-10 py-4 rounded-full hover:bg-orange-500 hover:text-white transition-all duration-300 shadow-lg shadow-white/5">
                            Buka Katalog Lengkap
                        </a>
                    </div>
                </div>
                <!-- Preview Produk dari Database -->
                <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                    <?php if (!empty($katalog_list)): ?>
                    <?php
                        foreach ($katalog_list as $index => $item):
                        $rotateClass = ($index % 2 == 0) ? 'hover:-rotate-2' : 'hover:rotate-2';
                        $translateClass = ($index == 1 || $index == 3) ? 'translate-y-6' : '';
                        $delay = $index * 100 + 200;
                        ?>
                    <div
                        class="bg-white/5 backdrop-blur-md p-4 rounded-3xl border border-white/10 transition-all duration-500 <?= $rotateClass ?> <?= $translateClass ?> group relative" data-aos="zoom-in" data-aos-delay="<?= $delay ?>">
                        <div class="relative h-40 w-full overflow-hidden rounded-2xl mb-4">

                            <img src="<?= $url_katalog . ($item['foto_produk'] ?? 'default_merch.jpg') ?>"
                                alt="<?= esc($item['nama_barang']) ?>"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <h4 class="text-white font-bold text-sm truncate"><?= esc($item['nama_barang']) ?></h4>
                        <p class="text-orange-500 text-xs font-black mt-1">
                            Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                        </p>
                        <!-- Link detail -->
                        <a href="<?= base_url('katalog') ?>" class="absolute inset-0 z-10"></a>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <!-- Tampilan jika database kosong -->
                    <div class="col-span-2 py-10 text-center border border-white/10 rounded-3xl">
                        <i class="fas fa-shopping-bag text-white/20 text-4xl mb-3"></i>
                        <p class="text-gray-500 text-xs">Produk belum tersedia di database.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PENGADUAN & ADVOKASI SECTION -->
<section id="advokasi" class="py-12 sm:py-20 md:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-red-600 via-orange-500 to-yellow-500 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0,50 Q25,25 50,50 T100,50" fill="none" stroke="white" stroke-width="2"/>
        </svg>
    </div>

    <div class="max-w-5xl mx-auto relative z-10">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="grid md:grid-cols-2 gap-0">
                <!-- Left: Visual -->
                <div class="bg-gradient-to-br from-red-600 to-orange-600 p-8 sm:p-12 flex flex-col justify-center text-white" data-aos="fade-right">
                    <div class="mb-6">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 backdrop-blur-md">
                            <i class="fas fa-megaphone text-4xl text-white"></i>
                        </div>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black mb-4 leading-tight">Layanan Pengaduan & Advokasi</h2>
                    <p class="text-lg text-white/90 mb-8 leading-relaxed">
                        Kami siap membantu Anda! Jika mengalami kendala administratif, akademik, atau memiliki saran untuk kami, silakan laporkan melalui saluran advokasi kami.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-white/80 text-sm">
                            <i class="fas fa-check-circle mr-3 text-yellow-300"></i>
                            Respons cepat dari tim advokasi
                        </li>
                        <li class="flex items-center text-white/80 text-sm">
                            <i class="fas fa-check-circle mr-3 text-yellow-300"></i>
                            Proses penanganan transparan
                        </li>
                        <li class="flex items-center text-white/80 text-sm">
                            <i class="fas fa-check-circle mr-3 text-yellow-300"></i>
                            Solusi yang adil dan berkelanjutan
                        </li>
                    </ul>
                </div>

                <!-- Right: Contact Options -->
                <div class="p-8 sm:p-12 flex flex-col justify-center" data-aos="fade-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-8">Hubungi Kami Via</h3>
                    
                    <div class="space-y-4">
                        <!-- WhatsApp -->
                        <a href="https://wa.me/6282184556644?text=Assalamu%27alaikum%20BEM%20KM%20PNP.%20Saya%20ingin%20mengadukan%20tentang..." target="_blank" 
                           class="flex items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl hover:shadow-lg hover:border-green-400 transition-all duration-300 group">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white text-xl mr-4 group-hover:scale-110 transition-transform">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">WhatsApp Advokasi</p>
                                <p class="text-sm text-gray-600">+62 821-8455-6644</p>
                            </div>
                            <i class="fas fa-arrow-right text-green-500 ml-auto group-hover:translate-x-2 transition-transform"></i>
                        </a>

                        <!-- Email -->
                        <a href="mailto:advokasi@bem-km-pnp.org?subject=Pengaduan%20dan%20Advokasi&body=Assalamu%27alaikum%20BEM%20KM%20PNP%0A%0ASaya%20ingin%20mengadukan%20tentang..." 
                           class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-2xl hover:shadow-lg hover:border-blue-400 transition-all duration-300 group">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl mr-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Email Advokasi</p>
                                <p class="text-sm text-gray-600">advokasi@bem-km-pnp.org</p>
                            </div>
                            <i class="fas fa-arrow-right text-blue-500 ml-auto group-hover:translate-x-2 transition-transform"></i>
                        </a>

                        <!-- Form Pengaduan -->
                        <a href="<?= base_url('layanan/advokasi') ?>" 
                           class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-2xl hover:shadow-lg hover:border-purple-400 transition-all duration-300 group">
                            <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white text-xl mr-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Form Pengaduan Online</p>
                                <p class="text-sm text-gray-600">Isi formulir pengaduan Anda</p>
                            </div>
                            <i class="fas fa-arrow-right text-purple-500 ml-auto group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>

                    <div class="mt-8 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                        <p class="text-sm text-gray-700"><strong>💡 Tip:</strong> Sertakan detail lengkap tentang masalah Anda agar kami dapat memberikan solusi yang tepat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;

    overflow: hidden;
}

@keyframes marquee {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-50%);
    }
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
