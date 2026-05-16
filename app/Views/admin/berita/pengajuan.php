<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">Daftar Pengajuan Berita</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="<?= base_url('admin/berita/pengajuan') ?>" class="mb-4">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari judul berita..." value="<?= esc($filters['keyword'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="status_pengajuan" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="pending" <?= ($filters['status_pengajuan'] ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= ($filters['status_pengajuan'] ?? '') == 'approved' ? 'selected' : '' ?>>Disetujui</option>
                            <option value="rejected" <?= ($filters['status_pengajuan'] ?? '') == 'rejected' ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Berita</th>
                            <th>Tanggal</th>
                            <th>Pengusul</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pengajuan_list)): ?>
                            <?php $no = 1 + (($pager->getCurrentPage('pengajuan') - 1) * $pager->getPerPage('pengajuan')); ?>
                            <?php foreach ($pengajuan_list as $pengajuan): ?>
                                <?php
                                    $status = $pengajuan['status_pengajuan'];
                                    $badgeClass = match ($status) {
                                        'approved' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                        default => 'bg-warning text-dark',
                                    };
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($pengajuan['judulberita']) ?></td>
                                    <td><?= !empty($pengajuan['tanggalberita']) ? date('d M Y', strtotime($pengajuan['tanggalberita'])) : '-' ?></td>
                                    <td><?= esc($pengajuan['user_id'] ?? '-') ?></td>
                                    <td><span class="badge <?= $badgeClass ?>"><?= esc(ucfirst($status)) ?></span></td>
                                    <td>
                                        <?php if ($status === 'pending'): ?>
                                            <a href="<?= base_url('admin/berita/approve/' . $pengajuan['id']) ?>" class="btn btn-sm btn-success">Setujui</a>
                                            <a href="<?= base_url('admin/berita/reject/' . $pengajuan['id']) ?>" class="btn btn-sm btn-danger">Tolak</a>
                                        <?php elseif ($status === 'approved'): ?>
                                            <span class="badge bg-success">Sudah Disetujui</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Sudah Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada pengajuan berita.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($pager->getPageCount('pengajuan') > 1): ?>
                <div class="d-flex justify-content-center">
                    <?= $pager->links('pengajuan', 'bootstrap_pagination') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
