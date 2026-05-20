<style>
    .dash-hero {
        background: linear-gradient(135deg, #0f8f5f, #13a36c);
        border-radius: 10px;
        color: #fff;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }
    .dash-card {
        border: 1px solid #e8eef3;
        border-radius: 8px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
        height: 100%;
    }
    .dash-icon {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef8f3;
        color: #0f8f5f;
    }
    .status-dot {
        width: .55rem;
        height: .55rem;
        border-radius: 999px;
        display: inline-block;
    }
    .chart-bar {
        height: 10px;
        border-radius: 999px;
        background: #edf2f7;
        overflow: hidden;
    }
    .chart-bar span {
        display: block;
        height: 100%;
        border-radius: inherit;
        transition: width .45s ease;
    }
    .mini-donut {
        position: relative;
        width: 144px;
        height: 144px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        margin: 0 auto;
        background: conic-gradient(#f59e0b 0 <?= (int) (($approval_chart['pending'] ?? 0) * 3.6) ?>deg, #16a34a 0 360deg);
    }
    .mini-donut::after {
        content: "";
        width: 94px;
        height: 94px;
        border-radius: 50%;
        background: #fff;
        position: absolute;
    }
    .mini-donut-value {
        position: relative;
        z-index: 1;
        text-align: center;
    }
</style>

<?php
    $totals = $totals ?? [];
    $pending = $pending ?? [];
    $active = $active ?? [];
    $recent = $recent ?? [];
    $pendingTotal = $pending_total ?? 0;
    $contentChart = $content_chart ?? [];
    $approvalChart = $approval_chart ?? ['pending' => 0, 'approved' => 100];

    $statCards = [
        ['label' => 'Total User', 'value' => $totals['users'] ?? 0, 'icon' => 'fa-users'],
        ['label' => 'Konten Tayang', 'value' => ($totals['beasiswa'] ?? 0) + ($totals['lomba'] ?? 0) + ($totals['event'] ?? 0) + ($totals['berita'] ?? 0) + ($totals['katalog'] ?? 0), 'icon' => 'fa-layer-group'],
        ['label' => 'Menunggu ACC', 'value' => $pendingTotal, 'icon' => 'fa-clock'],
        ['label' => 'Laporan Masuk', 'value' => $totals['laporan'] ?? 0, 'icon' => 'fa-file-lines'],
    ];

    $approvalLinks = [
        'beasiswa' => ['label' => 'Beasiswa', 'url' => 'admin/beasiswa/pengajuan', 'icon' => 'fa-graduation-cap'],
        'lomba' => ['label' => 'Lomba', 'url' => 'admin/lomba/pengajuan', 'icon' => 'fa-trophy'],
        'event' => ['label' => 'Event', 'url' => 'admin/event/pengajuan', 'icon' => 'fa-calendar-days'],
        'berita' => ['label' => 'Berita', 'url' => 'admin/berita/pengajuan', 'icon' => 'fa-newspaper'],
        'katalog' => ['label' => 'Katalog', 'url' => 'admin/katalog/pengajuan', 'icon' => 'fa-cart-shopping'],
    ];
?>

<div class="container-fluid">
    <div class="dash-hero">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
            <div>
                <h2 class="h4 fw-bold mb-1">Selamat datang, <?= esc(session()->get('username') ?? 'Admin') ?></h2>
                <p class="mb-0 opacity-75">Pantau konten, pengajuan member, dan laporan dari satu panel ringan.</p>
            </div>
            <div class="text-lg-end">
                <div class="small opacity-75">Hari ini</div>
                <div class="fw-semibold"><?= date('d M Y') ?></div>
                <a href="<?= base_url('/') ?>" class="btn btn-sm btn-light mt-2">Lihat Halaman Depan</a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <?php foreach ($statCards as $card): ?>
            <div class="col-sm-6 col-xl-3">
                <div class="card dash-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small"><?= esc($card['label']) ?></div>
                            <div class="h3 fw-bold mb-0"><?= number_format((int) $card['value']) ?></div>
                        </div>
                        <span class="dash-icon"><i class="fas <?= esc($card['icon']) ?>"></i></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-xl-8">
            <div class="card dash-card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Statistik Konten Tayang</h5>
                    <span class="small text-muted">Proporsi data approved</span>
                </div>
                <div class="card-body">
                    <?php foreach ($contentChart as $row): ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold"><?= esc($row['label']) ?></span>
                                <span class="text-muted small"><?= (int) $row['value'] ?> data • <?= (int) $row['percent'] ?>%</span>
                            </div>
                            <div class="chart-bar">
                                <span style="width: <?= (int) $row['percent'] ?>%; background: <?= esc($row['color']) ?>;"></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card dash-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Rasio Approval</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mini-donut mb-3">
                        <div class="mini-donut-value">
                            <div class="h4 fw-bold mb-0"><?= (int) ($approvalChart['approved'] ?? 100) ?>%</div>
                            <div class="small text-muted">approved</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center gap-3 small">
                        <span><span class="status-dot bg-success me-1"></span>Approved</span>
                        <span><span class="status-dot bg-warning me-1"></span>Pending</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-xl-7">
            <div class="card dash-card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Antrian Persetujuan</h5>
                    <span class="badge bg-success-subtle text-success"><?= (int) $pendingTotal ?> pending</span>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <?php foreach ($approvalLinks as $key => $item): ?>
                            <div class="col-md-6">
                                <a href="<?= base_url($item['url']) ?>" class="text-decoration-none text-dark">
                                    <div class="border rounded p-3 d-flex justify-content-between align-items-center h-100">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="dash-icon"><i class="fas <?= esc($item['icon']) ?>"></i></span>
                                            <div>
                                                <div class="fw-semibold"><?= esc($item['label']) ?></div>
                                                <div class="small text-muted">Butuh review admin</div>
                                            </div>
                                        </div>
                                        <span class="badge bg-warning text-dark"><?= (int) ($pending[$key] ?? 0) ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card dash-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ringkasan Publik</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span><span class="status-dot bg-success me-2"></span>Beasiswa aktif</span>
                        <strong><?= (int) ($active['beasiswa'] ?? 0) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span><span class="status-dot bg-primary me-2"></span>Pengumuman aktif</span>
                        <strong><?= (int) ($active['pengumuman'] ?? 0) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span><span class="status-dot bg-info me-2"></span>Event tayang</span>
                        <strong><?= (int) ($totals['event'] ?? 0) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span><span class="status-dot bg-warning me-2"></span>Berita tayang</span>
                        <strong><?= (int) ($totals['berita'] ?? 0) ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <?php
            $recentBlocks = [
                'beasiswa' => ['title' => 'Beasiswa Terbaru', 'field' => 'nama_beasiswa', 'icon' => 'fa-graduation-cap'],
                'lomba' => ['title' => 'Lomba Terbaru', 'field' => 'nama_lomba', 'icon' => 'fa-trophy'],
                'event' => ['title' => 'Event Terbaru', 'field' => 'nama_event', 'icon' => 'fa-calendar-days'],
                'berita' => ['title' => 'Berita Terbaru', 'field' => 'judulberita', 'icon' => 'fa-newspaper'],
                'laporan' => ['title' => 'Laporan Terbaru', 'field' => 'isi', 'icon' => 'fa-file-lines'],
            ];
        ?>
        <?php foreach ($recentBlocks as $key => $block): ?>
            <div class="col-lg-6 col-xl-4">
                <div class="card dash-card">
                    <div class="card-header bg-white">
                        <h6 class="mb-0"><i class="fas <?= esc($block['icon']) ?> text-success me-2"></i><?= esc($block['title']) ?></h6>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php if (!empty($recent[$key])): ?>
                            <?php foreach ($recent[$key] as $item): ?>
                                <div class="list-group-item">
                                    <div class="fw-semibold text-truncate"><?= esc($item[$block['field']] ?? 'Tanpa judul') ?></div>
                                    <div class="small text-muted"><?= !empty($item['created_at']) ? date('d M Y', strtotime($item['created_at'])) : '-' ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="list-group-item text-muted small">Belum ada data.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
