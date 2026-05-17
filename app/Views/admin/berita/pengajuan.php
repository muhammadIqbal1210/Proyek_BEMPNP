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
                                <td><?= esc($pengajuan['nama_user'] ?? $pengajuan['user_id'] ?? '-') ?></td>
                                <td><span class="badge <?= $badgeClass ?>"><?= esc(ucfirst($status)) ?></span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailBeritaModal<?= $pengajuan['id'] ?>">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                        <?php if ($status == 'pending'): ?>
                                            <a href="<?= base_url('admin/berita/approve/' . $pengajuan['id']) ?>" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')">Setujui</a>
                                            <a href="<?= base_url('admin/berita/reject/' . $pengajuan['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">Tolak</a>
                                        <?php elseif ($status == 'approved'): ?>
                                            <button type="button" class="btn btn-sm btn-warning" data-id="<?= $pengajuan['id'] ?>" data-bs-toggle="modal" data-bs-target="#editBeritaModal">Edit</button>
                                                <a href="<?= base_url('admin/berita/delete/' . $pengajuan['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                        <?php else: ?>
                                            <span class="text-muted">Sudah diproses</span>
                                        <?php endif; ?>
                                    </div>
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
<?php if (!empty($pengajuan_list)): ?>
    <?php foreach ($pengajuan_list as $pengajuan): ?>
        <div class="modal fade" id="detailBeritaModal<?= $pengajuan['id'] ?>" tabindex="-1" aria-labelledby="detailBeritaModalLabel<?= $pengajuan['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="detailBeritaModalLabel<?= $pengajuan['id'] ?>">Detail Pengajuan Berita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <h3 class="fw-bold text-gray-900 mb-1"><?= esc($pengajuan['judulberita']) ?></h3>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-user me-1"></i> Pengusul: <strong><?= esc($pengajuan['nama_user'] ?? $pengajuan['user_id'] ?? '-') ?></strong> | 
                                <i class="fas fa-calendar-alt me-1"></i> Tanggal: <strong><?= !empty($pengajuan['tanggalberita']) ? date('d F Y', strtotime($pengajuan['tanggalberita'])) : '-' ?></strong>
                            </p>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-5">
                                <h6 class="fw-bold text-secondary mb-2">Gambar Utama / Poster:</h6>
                                <?php if (!empty($pengajuan['gambarberita'])): ?>
                                    <div class="border rounded overflow-hidden shadow-sm bg-light text-center p-2">
                                        <img src="<?= base_url('uploads/berita/' . $pengajuan['gambarberita']) ?>" class="img-fluid rounded" alt="Gambar Berita" style="max-height: 280px; object-fit: contain;">
                                    </div>
                                <?php else: ?>
                                    <div class="border rounded d-flex align-items-center justify-content-center bg-light text-muted small" style="height: 200px;">
                                        Tidak ada gambar
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-7">
                                <h6 class="fw-bold text-secondary mb-2">Isi Konten Berita:</h6>
                                <div class="p-3 border rounded bg-white overflow-auto" style="max-height: 300px; font-size: 14px; line-height: 1.6;">
                                    <?= $pengajuan['isiberita'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-light d-flex justify-content-between">
                        <div>
                            <span class="small text-muted">Status saat ini:</span>
                            <?php
                                $status = $pengajuan['status_pengajuan'];
                                $lblClass = match ($status) {
                                    'approved' => 'badge bg-success',
                                    'rejected' => 'badge bg-danger',
                                    default => 'badge bg-warning text-dark',
                                };
                            ?>
                            <span class="<?= $lblClass ?>"><?= ucfirst($status) ?></span>
                        </div>
                        
                        <div class="btn-group">
                            <?php if ($status === 'pending'): ?>
                                <a href="<?= base_url('admin/berita/approve/' . $pengajuan['id']) ?>" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan berita ini?')">
                                    <i class="fas fa-check me-1"></i> Setujui Berita
                                </a>
                                <a href="<?= base_url('admin/berita/reject/' . $pengajuan['id']) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan berita ini?')">
                                    <i class="fas fa-times me-1"></i> Tolak Pengajuan
                                </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?= $this->include('admin/berita/edit') ?>
