<div class="container-fluid">
<!-- Flash Messages -->
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

<!-- Filter Card -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="card-title mb-3">Daftar Masuk Advokasi Mahasiswa</h5>
        <form method="GET" action="<?= base_url('admin/advokasi') ?>">
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
                    <a href="<?= base_url('admin/advokasi') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-redo me-1"></i> Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
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
                        <?php $no = 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()); ?>
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
                                    <?php if ($lp['lampiran']): ?>
                                        <a href="<?= $lampiran_url . $lp['lampiran'] ?>" target="_blank" class="btn btn-xs btn-outline-primary py-0 px-2"> Lihat</a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="<?= base_url('admin/advokasi/update_status/' . $lp['id']) ?>" method="POST">
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
                                        <a href="<?= base_url('admin/advokasi/delete/' . $lp['id']) ?>" 
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
    <div class="card-footer">
        <?= $pager->links() ?>
    </div>
</div>


</div>