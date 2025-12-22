<?= $this->extend('layouts/layout_utama') ?>

<?php $this->section('content') ?>
<!-- Hero Section Katalog -->
<section class="bg-gradient-to-r from-green-700 to-green-800 pt-24 pb-20 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
        </svg>
    </div>
    <div class="max-w-6xl mx-auto px-6 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Katalog Layanan & Produk</h1>
        <p class="text-green-100 text-lg max-w-2xl mx-auto">
            Temukan berbagai merchandise resmi BEM KM PNP serta layanan mahasiswa yang kami sediakan untuk menunjang kreativitas Anda.
        </p>
    </div>
</section>

<!-- Konten Utama Katalog -->
<main class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar Filter -->
        <aside class="w-full md:w-1/4">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                <h2 class="font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-filter mr-2 text-orange-500"></i> Cari Produk
                </h2>
                
                <form action="<?= base_url('katalog') ?>" method="GET" class="mb-6">
                    <div class="relative">
                        <input type="text" name="keyword" 
                               value="<?= esc($filters['keyword'] ?? '') ?>"
                               class="w-full pl-4 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-orange-500 focus:border-orange-500 text-sm" 
                               placeholder="Cari nama barang...">
                        <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-orange-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <h3 class="font-bold text-gray-900 text-sm mb-3 uppercase tracking-wider">Bantuan Cepat</h3>
                <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                    <p class="text-sm text-green-700 mb-3 leading-relaxed">Klik pada produk untuk melihat detail spesifikasi lengkap.</p>
                    <a href="https://wa.me/your-number" target="_blank" class="inline-flex items-center justify-center w-full py-2 bg-green-600 text-white rounded-lg text-sm font-bold hover:bg-green-700 transition">
                        <i class="fab fa-whatsapp mr-2"></i> Hubungi Admin
                    </a>
                </div>
            </div>
        </aside>

        <!-- Grid Produk Dinamis -->
        <div class="w-full md:w-3/4">
            <div class="flex justify-between items-center mb-8 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <p class="text-gray-500 text-sm">
                    Menampilkan <span class="font-bold text-gray-900"><?= count($katalog_list) ?></span> Produk
                </p>
                <?php if(!empty($filters['keyword'])): ?>
                    <a href="<?= base_url('katalog') ?>" class="text-sm text-orange-600 hover:underline">Hapus Filter</a>
                <?php endif; ?>
            </div>

            <?php if (!empty($katalog_list)): ?>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($katalog_list as $katalog): ?>
                    <!-- Card Produk dengan Trigger Modal (onclick) -->
                    <div onclick="showProductDetail(<?= htmlspecialchars(json_encode($katalog)) ?>)" 
                         class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col h-full cursor-pointer">
                        
                        <div class="relative overflow-hidden aspect-square bg-gray-50">
                            <?php if (!empty($katalog['foto_produk'])): ?>
                                <img src="<?= esc($produk_base_url . $katalog['foto_produk']) ?>" 
                                     alt="<?= esc($katalog['nama_barang']) ?>"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                    <i class="fas fa-image text-5xl mb-2"></i>
                                    <span class="text-xs">Tidak ada foto</span>
                                </div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors"></div>
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="font-bold text-gray-900 group-hover:text-green-700 transition-colors line-clamp-2 min-h-[2rem]">
                                <?= esc($katalog['nama_barang']) ?>
                            </h3>
                            <p class="text-sm text-gray-500 line-clamp-2 mt-1">
                                <?= esc($katalog['deskripsi']) ?>
                            </p>
                            <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tight">Harga</p>
                                    <span class="text-lg font-extrabold text-orange-600 font-mono">
                                        <?= 'Rp ' . number_format($katalog['harga'] ?? 0, 0, ',', '.') ?>
                                    </span>
                                </div>
                                <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if (isset($pager)): ?>
                <div class="mt-10 flex justify-center">
                    <?= $pager->links('katalog', 'default_full') ?>
                </div>
                <?php endif; ?>
                

            <?php else: ?>
                <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                    <i class="fas fa-box-open text-6xl text-gray-200 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-400">Belum ada produk tersedia</h3>
                    <p class="text-gray-400">Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Modal Detail Produk -->
<div id="detailModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-80 transition-opacity" onclick="closeProductDetail()"></div>

        <!-- Trick to center modal -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-gray-100">
            <!-- Close Button -->
            <button onclick="closeProductDetail()" class="absolute right-4 top-4 z-20 bg-white/90 p-2 rounded-full text-gray-500 hover:text-red-500 shadow-sm transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>

            <div class="flex flex-col md:flex-row">
                <!-- Image Section -->
                <div class="w-full md:w-1/2 bg-gray-50 relative aspect-square md:aspect-auto">
                    <img id="modalImage" src="" alt="" class="w-full h-full object-cover">
                </div>

                <!-- Info Section -->
                <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col">
                    <div class="mb-4">
                        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Informasi Produk</span>
                    </div>
                    
                    <h2 id="modalTitle" class="text-2xl md:text-3xl font-black text-gray-900 mb-4 leading-tight"></h2>
                    
                    <div class="flex items-baseline gap-2 mb-6">
                        <span class="text-sm text-gray-400 font-bold uppercase">Harga:</span>
                        <span id="modalPrice" class="text-3xl font-black text-orange-600 font-mono"></span>
                    </div>

                    <div class="prose prose-sm mb-8 overflow-y-auto max-h-[250px] pr-2 custom-scrollbar">
                        <h4 class="text-gray-900 font-bold mb-2 uppercase text-[10px] tracking-widest">Deskripsi Lengkap</h4>
                        <p id="modalDescription" class="text-gray-600 leading-relaxed whitespace-pre-line"></p>
                    </div>

                    <div class="mt-auto flex flex-col gap-3">
                        <a id="modalBuyLink" href="#" target="_blank" class="flex items-center justify-center gap-3 w-full py-4 bg-green-600 hover:bg-green-700 text-white rounded-2xl font-bold text-lg shadow-lg shadow-green-100 transition-all transform hover:-translate-y-1">
                            <i class="fab fa-whatsapp text-xl"></i> Pesan Melalui WhatsApp
                        </a>
                        <p class="text-center text-[10px] text-gray-400">Pemesanan akan diarahkan langsung ke admin BEM KM PNP.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('detailModal');
    const mImage = document.getElementById('modalImage');
    const mTitle = document.getElementById('modalTitle');
    const mPrice = document.getElementById('modalPrice');
    const mDesc = document.getElementById('modalDescription');
    const mBuyLink = document.getElementById('modalBuyLink');
    const baseStorage = "<?= $produk_base_url ?>";

    function showProductDetail(product) {
        // Set Data
        mTitle.innerText = product.nama_barang;
        mDesc.innerText = product.deskripsi || "Tidak ada deskripsi detail untuk produk ini.";
        
        // Format Currency
        mPrice.innerText = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(product.harga || 0);

        // Set Image
        mImage.src = product.foto_produk ? baseStorage + product.foto_produk : 'https://via.placeholder.com/600x600?text=No+Image';
        mImage.alt = product.nama_barang;

        // Set WhatsApp Link
        if (product.link_jual) {
            mBuyLink.href = product.link_jual;
            mBuyLink.style.display = 'flex';
        } else {
            mBuyLink.style.display = 'none';
        }

        // Show Modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Stop background scroll
    }

    function closeProductDetail() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scroll
    }

    // Close on ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeProductDetail();
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>

<?php $this->endSection() ?>