<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengajuan Katalog</h3>
                </div>
                <div class="card-body">
                    <a href="<?= base_url('member/katalog/create') ?>" class="btn btn-primary mb-3">Ajukan Katalog Baru</a>
                    
                    <!-- Filter Form -->
                    <form method="GET" action="<?= base_url('member/katalog') ?>" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari nama barang..." value="<?= esc($filters['keyword'] ?? '') ?>">
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

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Status Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pengajuan_list)): ?>
                                    <?php $no = 1 + (($pager->getCurrentPage() - 1) * $pager->getPerPage()); ?>
                                    <?php foreach ($pengajuan_list as $pengajuan): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($pengajuan['nama_barang']) ?></td>
                                            <td>Rp<?= number_format($pengajuan['harga'], 0, ',', '.') ?></td>
                                            <td>
                                                <?php
                                                $status = $pengajuan['status_pengajuan'];
                                                $badgeClass = '';
                                                switch ($status) {
                                                    case 'pending': $badgeClass = 'badge-warning'; break;
                                                    case 'approved': $badgeClass = 'badge-success'; break;
                                                    case 'rejected': $badgeClass = 'badge-danger'; break;
                                                }
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                            </td>
                                            <td>
                                                <?php if ($status == 'pending'): ?>
                                                    <a href="<?= base_url('member/katalog/edit/' . $pengajuan['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                                    <a href="<?= base_url('member/katalog/delete/' . $pengajuan['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')">Hapus</a>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak dapat diubah</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada pengajuan katalog.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if ($pager->getPageCount() > 1): ?>
                        <div class="d-flex justify-content-center">
                            <?= $pager->links('pengajuan', 'bootstrap_pagination') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
