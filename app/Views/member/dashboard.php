<style>
    .member-hero {
        background: linear-gradient(135deg, #0f8f5f, #12a06a);
        border-radius: 10px;
        color: #fff;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }
    .member-card {
        border: 1px solid #e8eef3;
        border-radius: 8px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
        height: 100%;
    }
    .member-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef8f3;
        color: #0f8f5f;
    }
</style>

<?php
    $summary = $summary ?? [];
    $recent = $recent ?? [];
    $totalPending = array_sum(array_column($summary, 'pending'));
    $totalApproved = array_sum(array_column($summary, 'approved'));
    $totalRejected = array_sum(array_column($summary, 'rejected'));

    $icons = [
        'beasiswa' => 'fa-graduation-cap',
        'lomba' => 'fa-trophy',
        'event' => 'fa-calendar-days',
        'berita' => 'fa-newspaper',
        'katalog' => 'fa-cart-shopping',
    ];

    $badgeClass = [
        'pending' => 'bg-warning text-dark',
        'approved' => 'bg-success',
        'rejected' => 'bg-danger',
    ];
?>

<div class="container-fluid">
    <div class="member-hero">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
            <div>
                <h2 class="h4 fw-bold mb-1">Halo, <?= esc(session()->get('username') ?? 'Member') ?></h2>
                <p class="mb-0 opacity-75">Ajukan publikasi dan pantau status approval dari panel ini.</p>
            </div>
            <div class="text-lg-end">
                <div class="small opacity-75">Status pengajuan</div>
                <div class="fw-semibold"><?= (int) $totalPending ?> menunggu review</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card member-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Menunggu ACC</div>
                        <div class="h3 fw-bold mb-0"><?= (int) $totalPending ?></div>
                    </div>
                    <span class="member-icon"><i class="fas fa-clock"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card member-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Disetujui</div>
                        <div class="h3 fw-bold mb-0"><?= (int) $totalApproved ?></div>
                    </div>
                    <span class="member-icon"><i class="fas fa-check"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card member-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Ditolak</div>
                        <div class="h3 fw-bold mb-0"><?= (int) $totalRejected ?></div>
                    </div>
                    <span class="member-icon"><i class="fas fa-xmark"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <?php foreach ($summary as $key => $item): ?>
            <div class="col-md-6 col-xl-4">
                <div class="card member-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <span class="member-icon"><i class="fas <?= esc($icons[$key] ?? 'fa-file') ?>"></i></span>
                                <div>
                                    <h5 class="mb-0"><?= esc($item['label']) ?></h5>
                                    <div class="small text-muted">Pengajuan saya</div>
                                </div>
                            </div>
                            <a href="<?= base_url($item['create_url']) ?>" class="btn btn-sm btn-success">Ajukan</a>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="<?= base_url($item['index_url'] . '?status_pengajuan=pending') ?>" class="badge bg-warning text-dark text-decoration-none">Pending <?= (int) $item['pending'] ?></a>
                            <a href="<?= base_url($item['index_url'] . '?status_pengajuan=approved') ?>" class="badge bg-success text-decoration-none">Disetujui <?= (int) $item['approved'] ?></a>
                            <a href="<?= base_url($item['index_url'] . '?status_pengajuan=rejected') ?>" class="badge bg-danger text-decoration-none">Ditolak <?= (int) $item['rejected'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row g-3">
        <div class="col-xl-7">
            <div class="card member-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Aktivitas Terbaru</h5>
                </div>
                <div class="list-group list-group-flush">
                    <?php if (!empty($recent)): ?>
                        <?php foreach ($recent as $item): ?>
                            <a href="<?= base_url($item['url']) ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between gap-3">
                                    <div class="min-w-0">
                                        <div class="fw-semibold text-truncate"><?= esc($item['title']) ?></div>
                                        <div class="small text-muted"><?= esc($item['type']) ?> • <?= !empty($item['created_at']) ? date('d M Y', strtotime($item['created_at'])) : '-' ?></div>
                                    </div>
                                    <span class="badge <?= esc($badgeClass[$item['status']] ?? 'bg-secondary') ?> align-self-center"><?= esc(ucfirst($item['status'])) ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="list-group-item text-muted small">Belum ada pengajuan. Mulai dari tombol Ajukan di atas.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card member-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Alur Pengajuan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3 mb-3">
                        <span class="member-icon flex-shrink-0"><i class="fas fa-pen"></i></span>
                        <div>
                            <div class="fw-semibold">Isi formulir</div>
                            <div class="small text-muted">Lengkapi data dan lampiran yang diminta.</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <span class="member-icon flex-shrink-0"><i class="fas fa-clock"></i></span>
                        <div>
                            <div class="fw-semibold">Menunggu review admin</div>
                            <div class="small text-muted">Pengajuan masih bisa diedit selama status pending.</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <span class="member-icon flex-shrink-0"><i class="fas fa-check"></i></span>
                        <div>
                            <div class="fw-semibold">Disetujui dan tayang</div>
                            <div class="small text-muted">Konten tampil di halaman publik setelah disetujui.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
