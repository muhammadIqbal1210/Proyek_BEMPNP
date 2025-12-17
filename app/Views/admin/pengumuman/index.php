<div class="container-fluid">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Gagal Menyimpan!</h4>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <ol class="breadcrumb" style="background: none; padding: 0;">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengumuman</li>
    </ol>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <button type="button" class="btn btn-sm btn-success" 
                    data-bs-toggle="modal" data-bs-target="#createPengumumanModal">
                <i class="fas fa-plus me-1"></i> Buat Pengumuman Baru
            </button>
            <hr>
            
            <form method="GET" action="<?= base_url('admin/pengumuman') ?>">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" 
                                placeholder="Cari Pengumuman..." aria-label="Search"
                                value="<?= esc(isset($filters['keyword']) ? $filters['keyword'] : '') ?>">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="" <?= (!isset($filters['status']) || $filters['status'] == '') ? 'selected' : '' ?>>Filter Status</option>
                            <option value="aktif" <?= (isset($filters['status']) && $filters['status'] == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                            <option value="non-aktif" <?= (isset($filters['status']) && $filters['status'] == 'non-aktif') ? 'selected' : '' ?>>Non-Aktif</option>
                            <option value="draf" <?= (isset($filters['status']) && $filters['status'] == 'draf') ? 'selected' : '' ?>>Draf</option>
                        </select>
                    </div>
                    <div class="col-md-5 text-end">                        
                        <a href="<?= base_url('admin/pengumuman') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-redo me-1"></i> Reset Filter</a>
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
                            <th>Judul Pengumuman</th>
                            <th>Tanggal Publikasi</th>
                            <th>File Pendukung</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pengumuman_list)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($pengumuman_list as $pengumuman): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($pengumuman['title']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($pengumuman['tanggal_publikasi'])) ?></td>
                                    <td>
                                        <?php if (!empty($pengumuman['file_path'])): ?>
                                            <a href="<?= base_url('uploads/pengumuman/' . $pengumuman['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada file</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            $statusClass = 'secondary';
                                            if ($pengumuman['status'] == 'aktif') $statusClass = 'success';
                                            if ($pengumuman['status'] == 'draf') $statusClass = 'warning';
                                        ?>
                                        <span class="badge bg-<?= $statusClass ?>">
                                            <?= ucfirst($pengumuman['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Lihat Detail -->
                                        <button class="btn btn-sm btn-outline-info btn-detail me-1" 
                                            title="Lihat Detail" 
                                            data-id="<?= $pengumuman['id'] ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewPengumumanModal">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning btn-edit" 
                                            title="Edit" 
                                            data-id="<?= $pengumuman['id'] ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editPengumumanModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                            <a href="<?= base_url('admin/pengumuman/delete/' . $pengumuman['id']) ?>" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini? Tindakan ini tidak dapat dibatalkan.');" 
                                                class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada pengumuman yang dibuat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <!-- Paging dan informasi jumlah data (asumsi data tidak terlalu banyak) -->
            <span class="text-muted small">Menampilkan <?= count($pengumuman_list) ?> Pengumuman</span>
            <nav aria-label="Page navigation">
                <!-- Placeholder untuk pagination -->
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
    
    <!-- Memanggil View Modal Create (Wajib ada) -->
    <?php echo view('admin/pengumuman/create'); ?>

    <?= $this->include('admin/pengumuman/edit') ?>
    <?= $this->include('admin/pengumuman/detail') ?>

</div>