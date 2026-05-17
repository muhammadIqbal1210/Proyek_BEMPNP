<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengajuan Katalog</h3>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="<?= base_url('admin/katalog/pengajuan') ?>" class="mb-4">
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
                                    <th>Pengusul</th>
                                    <th>Status Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pengajuan_list)): ?>
                                    <?php $no = 1 + (($pager->getCurrentPage('pengajuan') - 1) * $pager->getPerPage('pengajuan')); ?>
                                    <?php foreach ($pengajuan_list as $pengajuan): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($pengajuan['nama_barang']) ?></td>
                                            <td>Rp<?= number_format($pengajuan['harga'], 0, ',', '.') ?></td>
                                            <td><?= esc($pengajuan['nama_user'] ?? $pengajuan['user_id']) ?></td>
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
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailKatalogModal<?= $pengajuan['id'] ?>">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </button>
                                                    <?php if ($status == 'pending'): ?>
                                                        <a href="<?= base_url('admin/katalog/approve/' . $pengajuan['id']) ?>" class="btn btn-sm btn-success">Setujui</a>
                                                        <a href="<?= base_url('admin/katalog/reject/' . $pengajuan['id']) ?>" class="btn btn-sm btn-danger">Tolak</a>
                                                    <?php elseif ($status == 'approved'): ?>
                                                        <button type="button" class="btn btn-sm btn-warning" data-id="<?= $pengajuan['id'] ?>" data-bs-toggle="modal" data-bs-target="#editKatalogModal">Edit</button>
                                                        <a href="<?= base_url('admin/katalog/delete/' . $pengajuan['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Sudah Ditolak</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada pengajuan katalog.</td>
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
    <?php if (!empty($pengajuan_list)): ?>
        <?php foreach ($pengajuan_list as $pengajuan): ?>
            <div class="modal fade" id="detailKatalogModal<?= $pengajuan['id'] ?>" tabindex="-1" aria-labelledby="detailKatalogModalLabel<?= $pengajuan['id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title" id="detailKatalogModalLabel<?= $pengajuan['id'] ?>">Detail Pengajuan Katalog</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <h4 class="fw-bold mb-1"><?= esc($pengajuan['nama_barang']) ?></h4>
                                <p class="text-muted small mb-0">
                                    <strong>Pengusul:</strong> <?= esc($pengajuan['nama_user'] ?? $pengajuan['user_id']) ?>
                                    &nbsp;|&nbsp;
                                    <strong>Harga:</strong> Rp<?= number_format($pengajuan['harga'], 0, ',', '.') ?>
                                    &nbsp;|&nbsp;
                                    <strong>Status Pengajuan:</strong> <?= ucfirst(esc($pengajuan['status_pengajuan'])) ?>
                                </p>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <h6 class="fw-bold text-secondary">Foto Produk</h6>
                                    <?php if (!empty($pengajuan['foto_produk'])): ?>
                                        <img src="<?= $produk_base_url . esc($pengajuan['foto_produk']) ?>" class="img-fluid rounded border" alt="Foto Produk" style="max-height: 260px; object-fit: contain;">
                                    <?php else: ?>
                                        <div class="border rounded p-4 text-center text-muted">Tidak ada foto produk</div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-7">
                                    <h6 class="fw-bold text-secondary">Deskripsi</h6>
                                    <div class="p-3 border rounded bg-white" style="min-height: 180px;">
                                        <?= $pengajuan['deskripsi'] ?>
                                    </div>
                                    <div class="mt-3">
                                        <p class="mb-0"><strong>Link Jual:</strong> <a href="<?= esc($pengajuan['link_jual']) ?>" target="_blank"><?= esc($pengajuan['link_jual']) ?></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?= $this->include('admin/katalog/edit') ?>
</div>
