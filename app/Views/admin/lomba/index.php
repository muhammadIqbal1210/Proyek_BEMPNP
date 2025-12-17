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
        <li class="breadcrumb-item active" aria-current="page">Lomba</li>
    </ol>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <button type="button" class="btn btn-sm btn-success" 
                    data-bs-toggle="modal" data-bs-target="#createLombaModal">
                <i class="fas fa-plus me-1"></i> Tambah Lomba
            </button>
            <hr>
            
            <form method="GET" action="<?= base_url('admin/lomba') ?>">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" 
                                placeholder="Cari Lomba..." aria-label="Search"
                                value="<?= esc(isset($filters['keyword']) ? $filters['keyword'] : '') ?>">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status_lomba" onchange="this.form.submit()">
                            <option value="" <?= (!isset($filters['status_lomba']) || $filters['status_lomba'] == '') ? 'selected' : '' ?>>Filter Status</option>
                            <option value="buka" <?= (isset($filters['status_lomba']) && $filters['status_lomba'] == 'buka') ? 'selected' : '' ?>>Buka</option>
                            <option value="tutup" <?= (isset($filters['status_lomba']) && $filters['status_lomba'] == 'tutup') ? 'selected' : '' ?>>Tutup</option>
                            <option value="segera" <?= (isset($filters['status_lomba']) && $filters['status_lomba'] == 'segera') ? 'selected' : '' ?>>Akan Datang</option>
                        </select>
                    </div>
                    <div class="col-md-5 text-end">                        
                        <a href="<?= base_url('admin/lomba') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-redo me-1"></i> Reset Filter</a>
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
                            <th>Nama Lomba</th>
                            <th>Kategori Lomba</th>
                            <th>Deskripsi</th>
                            <th>Link Informasi</th>
                            <th>Poster</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($lomba_list)): ?>
                            <?php 
                            // Hitung nomor awal untuk pagination
                            $perPage = @$pager->getPerPage() ?: 10;
                            $currentPage = @$pager->getCurrentPage() ?: 1;
                            $no = 1 + (($currentPage - 1) * $perPage); 
                            ?>
                            <?php foreach ($lomba_list as $lomba): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($lomba['nama_lomba']) ?></td>
                                    <td><?= esc($lomba['kategori']) ?></td>
                                    <td><?= esc($lomba['deskripsi']) ?></td>
                                    <td>
                                        <?php if (!empty($lomba['link_informasi'])): ?>
                                            <a href="<?= esc($lomba['link_informasi']) ?>" target="_blank" class="text-primary" title="Kunjungi Link"><i class="fas fa-external-link-alt"></i></a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($lomba['poster'])): ?>
                                            <img 
                                                src="<?= esc($poster_base_url . $lomba['poster']) ?>" 
                                                alt="Poster <?= esc($lomba['nama_lomba']) ?>" 
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"
                                                onerror="this.onerror=null; this.src='https://placehold.co/50x50/E5E7EB/4B5563?text=N%2FA'"
                                            />
                                        <?php else: ?>
                                            <span class="text-muted">Tidak Ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            $statusClass = match ($lomba['status_lomba']) {
                                                'Buka'   => 'success',
                                                'Tutup'  => 'danger',
                                                'Segera' => 'secondary',
                                            };
                                        ?>
                                        <span class="badge bg-<?= $statusClass ?>">
                                            <?= esc($lomba['status_lomba']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Aksi: Edit (Mengarah ke halaman edit) -->
                                        <button class="btn btn-sm btn-outline-warning btn-edit" 
                                            title="Edit" 
                                            data-id="<?= $lomba['id'] ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editLombaModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Aksi: Hapus -->
                                        <a href="<?= base_url('admin/lomba/delete/' . $lomba['id']) ?>" 
                                            onclick="return confirm('Anda yakin ingin menghapus lomba ini? Tindakan ini tidak dapat dibatalkan.');" 
                                            class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada data lomba yang tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <!-- Paging dan informasi jumlah data -->
            <span class="text-muted small">
                <?php if (!empty($lomba_list)): ?>
                    Menampilkan <?= count($lomba_list) ?> Lomba
                <?php else: ?>
                    Data kosong
                <?php endif; ?>
            </span>
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
    <?php echo view('admin/lomba/create'); ?>

    <?= $this->include('admin/lomba/edit') ?>
    <?= $this->include('admin/pengumuman/detail') ?> 

</div>