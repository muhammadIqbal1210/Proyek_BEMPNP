<div class="container-fluid">
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <ol class="breadcrumb" style="background: none; padding: 0;">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laporan Advokasi</li>
    </ol>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Daftar Masuk Advokasi Mahasiswa</h5>
            <form method="GET" action="<?= base_url('admin/laporan') ?>">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="keyword" 
                                placeholder="Cari Nama/NIM..." value="<?= esc($filters['keyword'] ?? '') ?>">
                            <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-select-sm" name="status" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="Masuk" <?= ($filters['status'] ?? '') == 'Masuk' ? 'selected' : '' ?>>Masuk</option>
                            <option value="Proses" <?= ($filters['status'] ?? '') == 'Proses' ? 'selected' : '' ?>>Proses</option>
                            <option value="Selesai" <?= ($filters['status'] ?? '') == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-5 text-end">                        
                        <a href="<?= base_url('admin/laporan') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-redo me-1"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pengadu</th>
                            <th>Kategori</th>
                            <th>Aduan</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($laporan_list)): ?>
                            <?php $no = 1 + (($pager->getCurrentPage('laporan') - 1) * $pager->getPerPage('laporan')); ?>
                            <?php foreach ($laporan_list as $lp): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><small><?= date('d/m/Y H:i', strtotime($lp['created_at'])) ?></small></td>
                                    <td>
                                        <strong><?= esc($lp['nama']) ?></strong><br>
                                        <small class="text-muted"><?= esc($lp['nim']) ?> | WA: <?= esc($lp['kontak']) ?></small>
                                    </td>
                                    <td><span class="badge bg-info text-dark"><?= esc($lp['kategori']) ?></span></td>
                                    <td>
                                        <div style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <?= esc($lp['isi']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php $lampiranItems = array_filter(array_map('trim', explode(',', $lp['lampiran'] ?? ''))); ?>
                                        <?php if (!empty($lampiranItems)): ?>
                                            <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#detailModal<?= $lp['id'] ?>">
                                                Lihat <?= count($lampiranItems) > 1 ? '(' . count($lampiranItems) . ')' : '' ?>
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="<?= base_url('admin/laporan/update_status/' . $lp['id']) ?>" method="POST">
                                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm 
                                                <?= $lp['status'] == 'Masuk' ? 'bg-light' : ($lp['status'] == 'Proses' ? 'bg-warning text-dark' : 'bg-success text-white') ?>" style="width: 100px; font-size: 11px;">
                                                <option value="Masuk" <?= $lp['status'] == 'Masuk' ? 'selected' : '' ?>>Masuk</option>
                                                <option value="Proses" <?= $lp['status'] == 'Proses' ? 'selected' : '' ?>>Proses</option>
                                                <option value="Selesai" <?= $lp['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-info" title="Detail" data-bs-toggle="modal" data-bs-target="#detailModal<?= $lp['id'] ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="<?= base_url('admin/laporan/delete/' . $lp['id']) ?>" 
                                               onclick="return confirm('Hapus laporan ini?');" 
                                               class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada laporan advokasi masuk.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            <span class="text-muted small">Menampilkan <?= count($laporan_list ?? []) ?> laporan</span>
            <?= isset($pager) ? $pager->links('laporan', 'bootstrap_pagination') : '' ?>
        </div>
    </div>

    <?php if (!empty($laporan_list)): ?>
        <?php foreach ($laporan_list as $lp): ?>
            <?php $lampiranItems = array_filter(array_map('trim', explode(',', $lp['lampiran'] ?? ''))); ?>
            <div class="modal fade" id="detailModal<?= $lp['id'] ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $lp['id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel<?= $lp['id'] ?>">Detail Laporan Advokasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <h6 class="mb-3">Informasi Pengadu</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Nama:</strong> <?= esc($lp['nama']) ?></li>
                                        <li class="list-group-item"><strong>NIM:</strong> <?= esc($lp['nim']) ?></li>
                                        <li class="list-group-item"><strong>Kontak:</strong> <?= esc($lp['kontak']) ?></li>
                                        <li class="list-group-item"><strong>Kategori:</strong> <?= esc($lp['kategori']) ?></li>
                                        <li class="list-group-item"><strong>Status:</strong> <?= esc($lp['status']) ?></li>
                                        <li class="list-group-item"><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($lp['created_at'])) ?></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-3">Lampiran</h6>
                                    <?php if (!empty($lampiranItems)): ?>
                                        <div class="mb-3">
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php foreach ($lampiranItems as $index => $file): ?>
                                                    <a href="<?= esc($lampiran_url . $file) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        Foto <?= $index + 1 ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <?php foreach ($lampiranItems as $file): ?>
                                                <div class="col-6">
                                                    <div class="border rounded overflow-hidden">
                                                        <img src="<?= esc($lampiran_url . $file) ?>" class="img-fluid" alt="Lampiran <?= esc($file) ?>">
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted">Tidak ada lampiran.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6>Isi Aduan</h6>
                                <p class="mb-0" style="white-space: pre-line;"><?= esc($lp['isi']) ?></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-modal="dismiss" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>