<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengajuan Event</h3>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="<?= base_url('admin/event/pengajuan') ?>" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari nama event..." value="<?= esc($filters['keyword'] ?? '') ?>">
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
                                    <th>Nama Event</th>
                                    <th>Waktu</th>
                                    <th>Pengusul</th>
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
                                            <td><?= esc($pengajuan['nama_event']) ?></td>
                                            <td><?= date('d M Y', strtotime($pengajuan['waktu'])) ?></td>
                                            <td><?= esc($pengajuan['user_id']) ?></td>
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
                                                    <a href="<?= base_url('admin/event/approve/' . $pengajuan['id']) ?>" class="btn btn-sm btn-success">Setujui</a>
                                                    <a href="<?= base_url('admin/event/reject/' . $pengajuan['id']) ?>" class="btn btn-sm btn-danger">Tolak</a>
                                                <?php elseif ($status == 'approved'): ?>
                                                    <span class="badge badge-success">Sudah Disetujui</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Sudah Ditolak</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada pengajuan event.</td>
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
