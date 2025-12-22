<?= $this->extend('layouts/layout_utama') ?> 

<?php $this->section('content') ?>
<header class="pt-16 pb-12 mb-5 ">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-extrabold text-black mb-2 pb-2 border-b-4 border-orange-400 inline-block ">Pusat Layanan</h1>
        <p class="text-black-200 text-lg">Semua layanan dari Badan Eksekutif Mahasiswa KM
            Politeknik Negeri Padang.</p>
    </div>
</header>

<section class="max-w-7xl mx-auto px-6 py-2">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <a href="<?= base_url('layanan/advokasi') ?>" class="block group">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300 cursor-pointer h-full">
                <!-- Icon dengan efek warna saat kartu di-hover -->
                <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-6 text-2xl shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-shield-alt"></i>
                </div>
                
                <h3 class="font-bold text-xl text-gray-800 mb-3">Advokasi Mahasiswa</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Bantuan dan pendampingan terkait masalah akademik maupun non-akademik.
                </p>
                
                <!-- Tambahan indikator visual kecil di bawah (opsional) -->
                <div class="mt-6 text-blue-600 font-bold text-xs uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                    Buka Layanan <i class="fas fa-arrow-right ml-1"></i>
                </div>
            </div>
        </a>

        <a href="<?= base_url('/beasiswa') ?>" class="block group">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300 cursor-pointer h-full">
                <!-- Icon dengan efek warna saat kartu di-hover -->
                <div class="w-16 h-16 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center mb-6 text-2xl shadow-sm group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                
                <h3 class="font-bold text-xl text-gray-800 mb-3">Informasi Beasiswa</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Update terbaru mengenai peluang beasiswa internal maupun eksternal.
                </p>
                
                <!-- Tambahan indikator visual kecil di bawah (opsional) -->
                <div class="mt-6 text-green-600 font-bold text-xs uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                    Buka Layanan <i class="fas fa-arrow-right ml-1"></i>
                </div>
            </div>
        </a>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300">
            <div class="w-16 h-16 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center mb-6 text-2xl shadow-sm">
                <i class="fas fa-briefcase"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-3">Informasi Magang</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Informasi seputar lowongan magang dan persiapan karir mahasiswa.</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300">
            <div class="w-16 h-16 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center mb-6 text-2xl shadow-sm">
                <i class="fas fa-trophy"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-3">Informasi Lomba</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Kumpulan info kompetisi akademik dan non-akademik tingkat nasional.</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-6 text-2xl shadow-sm">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-3">Agenda Kegiatan</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Jadwal lengkap semua acara dan kegiatan dari BEM KM PNP.</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center mb-6 text-2xl shadow-sm">
                <i class="fas fa-folder-open"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-3">Pusat Unduhan</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Temukan dokumen penting, template surat, dan berkas lainnya.</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300">
            <div class="w-16 h-16 bg-gray-100 text-gray-600 rounded-2xl flex items-center justify-center mb-6 text-2xl shadow-sm">
                <i class="fas fa-id-card"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-3">Kontak Penting</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Hubungi kami melalui narahubung kementerian terkait.</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300">
            <div class="w-16 h-16 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center mb-6 text-2xl shadow-sm">
                <i class="fas fa-handshake"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-3">Mitra Internal</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Ruang kolaborasi bagi ormawa di lingkungan Politeknik Negeri Padang.</p>
        </div>

    </div>
</section>
<?php $this->endSection() ?>