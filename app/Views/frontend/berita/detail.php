<?= $this->extend('layouts/layout_utama') ?>

<?= $this->section('content') ?>

<!-- Progress Bar untuk Membaca -->
<div id="reading-progress" class="fixed top-0 left-0 h-1 bg-green-600 z-50 transition-all duration-150" style="width: 0%"></div>

<main class="bg-white min-h-screen pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Category -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="<?= base_url('/') ?>" class="hover:text-green-600 transition">Beranda</a>
            <span class="text-gray-300">/</span>
            <a href="<?= base_url('berita') ?>" class="hover:text-green-600 transition">Berita</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-900 font-medium truncate"><?= esc($detail['judulberita']) ?></span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- LEFT COLUMN: CONTENT -->
            <article class="lg:col-span-8">
                <!-- Header Berita -->
                <header class="mb-10">
                    <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-[1.15] mb-6 tracking-tight">
                        <?= esc($detail['judulberita']) ?>
                    </h1>
                    
                    <div class="flex flex-wrap items-center justify-between gap-4 py-6 border-y border-gray-100">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-green-600 to-green-400 flex items-center justify-center text-white font-bold text-lg shadow-inner">
                                    <?= strtoupper(substr(esc($detail['author'] ?? 'A'), 0, 1)) ?>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-900 font-bold leading-tight"><?= esc($detail['author'] ?? 'Redaksi PNP') ?></p>
                                <div class="flex items-center text-xs text-gray-500 space-x-2 mt-1">
                                    <time datetime="<?= $detail['tanggalberita'] ?>"><?= date('d M Y', strtotime($detail['tanggalberita'])) ?></time>
                                    <span>•</span>
                                    <span>5 menit baca</span>
                                </div>
                            </div>
                        </div>

                        <!-- Social Share -->
                        <div class="flex items-center space-x-2">
                            <button onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + window.location.href)" class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-green-600 hover:text-white transition">
                                <i class="fab fa-facebook-f text-sm"></i>
                            </button>
                            <button onclick="window.open('https://twitter.com/intent/tweet?url=' + window.location.href)" class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-sky-500 hover:text-white transition">
                                <i class="fab fa-twitter text-sm"></i>
                            </button>
                            <button onclick="navigator.clipboard.writeText(window.location.href)" class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-gray-900 hover:text-white transition" title="Salin Link">
                                <i class="fas fa-link text-sm"></i>
                            </button>
                        </div>
                    </div>
                </header>

                <!-- Featured Image -->
                <?php if(!empty($detail['gambarberita'])): ?>
                <figure class="mb-12 relative">
                    <div class="aspect-video overflow-hidden shadow-2xl">
                        <img src="<?= base_url('uploads/berita/' . $detail['gambarberita']) ?>" 
                             alt="<?= esc($detail['judulberita']) ?>"
                             class="w-full h-full object-cover">
                    </div>
                    <?php if(!empty($detail['caption'])): ?>
                    <figcaption class="mt-4 text-center text-sm text-gray-500 italic">
                        <?= esc($detail['caption']) ?>
                    </figcaption>
                    <?php endif; ?>
                </figure>
                <?php endif; ?>

                <!-- Article Body -->
                <div class="prose prose-green prose-lg max-w-none article-body">
                    <?= $detail['isiberita'] ?>
                </div>

                <!-- Footer Article -->
                <div class="mt-16 pt-8 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Tag:</span>
                            <div class="flex flex-wrap gap-2">
                                <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-xs text-gray-600 transition">Kampus</a>
                                <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full text-xs text-gray-600 transition">Pendidikan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- RIGHT COLUMN: SIDEBAR -->
            <aside class="lg:col-span-4">
                <div class="sticky top-28 space-y-10">
                    
                    <!-- Search Widget -->
                    <div class="p-6 bg-gray-50 rounded-2xl">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">Cari Berita</h3>
                        <form action="<?= base_url('berita/search') ?>" method="GET" class="relative">
                            <input type="text" name="keyword" placeholder="Ketik kata kunci..." 
                                   class="w-full pl-4 pr-12 py-3 bg-white border-transparent focus:border-green-500 focus:ring-0 rounded-xl shadow-sm transition">
                            <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Recent Posts Widget -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest">Berita Terkait</h3>
                            <div class="h-px flex-grow bg-gray-100 ml-4"></div>
                        </div>
                        
                        <div class="space-y-6">
                            <?php if(!empty($berita_lainnya)): ?>
                                <?php foreach($berita_lainnya as $row): ?>
                                <article class="group flex items-start space-x-4">
                                    <div class="relative flex-shrink-0 w-24 h-20 rounded-xl overflow-hidden bg-gray-100 shadow-sm">
                                        <img src="<?= base_url('uploads/berita/' . $row['gambarberita']) ?>" 
                                             alt="<?= esc($row['judulberita']) ?>"
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="text-[15px] font-bold text-gray-900 leading-snug group-hover:text-green-600 transition line-clamp-2">
                                            <a href="<?= base_url('berita/detail/' . $row['id']) ?>">
                                                <?= esc($row['judulberita']) ?>
                                            </a>
                                        </h4>
                                        <time class="text-[11px] text-gray-400 mt-2 block font-medium">
                                            <?= date('d M Y', strtotime($row['tanggalberita'])) ?>
                                        </time>
                                    </div>
                                </article>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-gray-400 text-sm italic text-center py-4">Belum ada berita lain.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Newsletter/Call to Action -->
                    <div class="relative bg-green-600 rounded-3xl p-8 overflow-hidden shadow-xl shadow-green-100">
                        <div class="relative z-10">
                            <h4 class="text-xl font-bold text-white mb-2">Punya Pertanyaan?</h4>
                            <p class="text-green-100 text-sm mb-6 leading-relaxed">Hubungi pusat informasi kami untuk bantuan seputar kampus.</p>
                            <a href="https://wa.me/628xxxxxxxxxx" target="_blank" class="flex items-center justify-center w-full py-3 bg-white text-green-600 rounded-xl font-bold shadow-lg hover:bg-gray-50 transition">
                                <i class="fab fa-whatsapp mr-2"></i> Chat Sekarang
                            </a>
                        </div>
                        <!-- Dekorasi background -->
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-green-500 rounded-full opacity-50"></div>
                        <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-green-700 rounded-full opacity-50"></div>
                    </div>

                </div>
            </aside>
        </div>
    </div>
</main>

<style>
    /* Custom Typography for Content */
    .article-body {
        line-height: 1.85;
        color: #374151;
        letter-spacing: -0.011em;
    }
    .article-body p {
        margin-bottom: 1.75rem;
    }
    .article-body h2 {
        font-size: 1.875rem;
        font-weight: 800;
        color: #111827;
        margin-top: 2.5rem;
        margin-bottom: 1.25rem;
        letter-spacing: -0.025em;
    }
    .article-body h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .article-body blockquote {
        border-left: 4px solid #2563eb;
        background: #f8fafc;
        padding: 1.5rem 2rem;
        font-style: italic;
        border-radius: 0 1rem 1rem 0;
        margin: 2rem 0;
        color: #1e40af;
    }
    .article-body ul, .article-body ol {
        margin-bottom: 1.75rem;
        padding-left: 1.5rem;
    }
    .article-body li {
        margin-bottom: 0.5rem;
    }
    .article-body img {
        border-radius: 1.25rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    /* Line clamp for long titles in sidebar */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>

<script>
    // Reading Progress Indicator
    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        document.getElementById('reading-progress').style.width = scrolled + '%';
    });
</script>

<?= $this->endSection() ?>