<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>

<!-- Header Halaman -->
<header class="pt-16 pb-12 mb-10">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-extrabold text-black mb-2 pb-2 border-b-4 border-orange-400 inline-block">Layanan
            Advokasi Mahasiswa</h1>
        <p class="text-black-200 text-lg">Sampaikan aspirasi, keluhan, atau kendala akademik Anda kepada BEM KM
            Politeknik Negeri Padang secara aman dan rahasia.</p>
    </div>
</header>

<main class="max-w-6xl mx-auto px-6 py-8 mb-20">
    <div class="grid lg:grid-cols-3 gap-12">

        <!-- KOLOM KIRI: EDUKASI ALUR (33%) -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-graduation-cap mr-3 text-orange-500"></i> Alur Advokasi
                </h3>

                <div class="space-y-8 relative">
                    <div class="absolute left-4 top-2 bottom-2 w-0.5 bg-orange-200"></div>

                    <div class="relative flex items-start pl-10">
                        <div
                            class="absolute left-0 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm z-10">
                            1</div>
                        <div>
                            <h4 class="font-bold text-gray-900">Pengisian Form</h4>
                            <p class="text-sm text-gray-600 mt-1">Mahasiswa mengisi detail kendala melalui formulir yang
                                tersedia.</p>
                        </div>
                    </div>

                    <div class="relative flex items-start pl-10">
                        <div
                            class="absolute left-0 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm z-10">
                            2</div>
                        <div>
                            <h4 class="font-bold text-gray-900">Verifikasi Data</h4>
                            <p class="text-sm text-gray-600 mt-1">Departemen Advokasi BEM akan memvalidasi laporan Anda.
                            </p>
                        </div>
                    </div>

                    <div class="relative flex items-start pl-10">
                        <div
                            class="absolute left-0 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm z-10">
                            3</div>
                        <div>
                            <h4 class="font-bold text-gray-900">Tindakan & Negosiasi</h4>
                            <p class="text-sm text-gray-600 mt-1">Tim akan membawa masalah ini ke pihak birokrasi
                                kampus.</p>
                        </div>
                    </div>

                    <div class="relative flex items-start pl-10">
                        <div
                            class="absolute left-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm z-10">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-green-700">Penyelesaian</h4>
                            <p class="text-sm text-gray-600 mt-1">Mahasiswa menerima hasil penyelesaian advokasi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-orange-50 p-6 rounded-2xl border border-orange-100">
                <h4 class="font-bold text-orange-800 mb-2">Kenapa harus melapor?</h4>
                <p class="text-sm text-orange-700 leading-relaxed">
                    Setiap suara mahasiswa sangat berarti untuk perbaikan kampus. BEM KM PNP siap menjadi jembatan
                    antara mahasiswa dan institusi.
                </p>
            </div>
        </div>

        <!-- KOLOM KANAN: FORMULIR (66%) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="w-full h-32 bg-green-600 flex items-center justify-center relative">
                    <i class="fas fa-file-alt text-6xl text-white opacity-20"></i>
                    <div class="absolute bottom-4 left-6 text-white text-left">
                        <h2 class="text-xl font-bold uppercase tracking-wider">Form Pengaduan Mahasiswa</h2>
                    </div>
                </div>

                <div class="p-8">
                    <?php if (session()->getFlashdata('success')) : ?>
                    <div
                        class="mb-6 flex items-center bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm animate-bounce-short">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-green-800">Berhasil!</p>
                            <p class="text-xs text-green-700"><?= session()->getFlashdata('success') ?></p>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()"
                            class="ml-auto text-green-500 hover:text-green-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <?php endif; ?>

                    <!-- TAMPILKAN PESAN ERROR (Jika ada) -->
                    <?php if (session()->getFlashdata('error')) : ?>
                    <div class="mb-6 flex items-center bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-red-800">Terjadi Kesalahan</p>
                            <p class="text-xs text-red-700"><?= session()->getFlashdata('error') ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <form action="<?= base_url('layanan/kirim_lapor') ?>" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        <?= csrf_field() ?>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap
                                    (Opsional)</label>
                                <input type="text" name="nama" placeholder="Masukkan nama"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-400 transition outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NIM</label>
                                <input type="text" name="nim" required placeholder="Masukkan NIM"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-400 transition outline-none">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Advokasi</label>
                                <select name="kategori" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-400 transition outline-none bg-white font-medium">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Akademik">Akademik (Dosen, Nilai, dll)</option>
                                    <option value="Fasilitas">Fasilitas (Ruang Kelas, WC, Parkir)</option>
                                    <option value="Finansial">Finansial (UKT, Beasiswa)</option>
                                    <option value="Pelecehan">Kekerasan & Pelecehan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                                <input type="text" name="kontak" required placeholder="08xxxxxxxxxx"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-400 transition outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Masalah</label>
                            <textarea name="isi" rows="5" required
                                placeholder="Ceritakan detail masalah yang Anda hadapi..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-400 transition outline-none"></textarea>
                        </div>

                        <!-- BAGIAN UPLOAD MULTIPLE -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Unggah Bukti (Bisa lebih dari
                                1)</label>
                            <div class="space-y-3">
                                <div onclick="document.getElementById('file-input').click()" id="drop-area"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 hover:border-orange-400 hover:bg-orange-50 transition rounded-xl cursor-pointer bg-gray-50/50">

                                    <div id="upload-ui" class="flex flex-col items-center justify-center">
                                        <i class="fas fa-images text-3xl text-gray-400 mb-2"></i>
                                        <p class="text-xs text-gray-500 font-medium text-center">Klik untuk pilih
                                            beberapa file (Foto/PDF)<br><span class="text-orange-500">Maksimal total 5
                                                file</span></p>
                                    </div>
                                </div>

                                <!-- Container Daftar Preview -->
                                <div id="files-preview-container" class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <!-- Preview items akan muncul di sini -->
                                </div>

                                <input type="file" name="lampiran[]" id="file-input" class="hidden"
                                    accept="image/*,application/pdf" multiple onchange="handleMultipleFiles(this)">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-xl shadow-lg transition duration-300 flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Laporan Advokasi
                            </button>
                            <p class="text-center text-[10px] text-gray-400 mt-4 uppercase tracking-widest font-bold">
                                <i class="fas fa-user-secret mr-1"></i> Anonimitas Anda Terjamin Jika Diminta
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
/**
 * Logika Unggah Multiple File dengan Preview Card
 */
function handleMultipleFiles(input) {
    const container = document.getElementById('files-preview-container');
    const files = Array.from(input.files);

    // Batasan maksimal file (opsional)
    if (files.length > 5) {
        alert("Maksimal unggah 5 file sekaligus.");
        input.value = "";
        container.innerHTML = "";
        return;
    }

    // Bersihkan container sebelum render ulang
    container.innerHTML = "";

    files.forEach((file, index) => {
        // Validasi ukuran per file (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert(`File ${file.name} terlalu besar (>2MB)`);
            return;
        }

        // Create Preview Card Element
        const card = document.createElement('div');
        card.className =
            "relative p-3 bg-orange-50 border border-orange-200 rounded-xl flex flex-col items-center animate-in fade-in zoom-in duration-200";

        // Inner Content
        let mediaHtml = "";
        if (file.type.startsWith('image/')) {
            mediaHtml =
                `<img src="${URL.createObjectURL(file)}" class="h-12 w-12 object-cover rounded-lg shadow-sm mb-2 border-2 border-white">`;
        } else {
            mediaHtml = `<i class="fas fa-file-pdf text-3xl text-red-500 mb-2"></i>`;
        }

        card.innerHTML = `
            ${mediaHtml}
            <p class="text-[10px] font-bold text-orange-800 truncate w-full text-center">${file.name}</p>
            <button type="button" onclick="removeSingleFile(${index})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px] hover:bg-red-600 shadow-md">
                <i class="fas fa-times"></i>
            </button>
        `;

        container.appendChild(card);
    });
}

/**
 * Fungsi menghapus file tertentu (Bekerja dengan memicu input reset sederhana)
 * Untuk sistem yang lebih kompleks, biasanya menggunakan DataTransfer object
 */
function removeSingleFile(index) {
    // Untuk kemudahan, jika user menghapus satu, kita reset input untuk keamanan data
    // Karena memanipulasi FileList di JS murni butuh DataTransfer API
    const input = document.getElementById('file-input');
    const container = document.getElementById('files-preview-container');

    // Skenario sederhana: Hapus semua jika klik silang (reset)
    input.value = "";
    container.innerHTML = "";
    alert("Daftar file direset. Silakan pilih kembali file yang diinginkan.");
}
</script>

<?php $this->endSection() ?>