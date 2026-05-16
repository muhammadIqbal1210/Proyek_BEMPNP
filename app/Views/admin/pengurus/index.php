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
        <li class="breadcrumb-item active" aria-current="page">Pengurus</li>
    </ol>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <button type="button" class="btn btn-sm btn-success" 
                    data-bs-toggle="modal" data-bs-target="#createPengurusModal">
                <i class="fas fa-plus me-1"></i> Tambah Pengurus
            </button>
            <hr>
            
            <form method="GET" action="<?= base_url('admin/pengurus') ?>">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" 
                                placeholder="Cari Pengurus..." aria-label="Search"
                                value="<?= esc(isset($filters['keyword']) ? $filters['keyword'] : '') ?>">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="kementerian" onchange="this.form.submit()">
                            <option value="" <?= (!isset($filters['kementerian']) || $filters['kementerian'] == '') ? 'selected' : '' ?>>Filter Kementerian</option>
                            <option value="kepresidenan" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'kepresidenan') ? 'selected' : '' ?>>Kepresidenan</option>
                            <option value="audit_internal" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'audit_internal') ? 'selected' : '' ?>>Audit Internal</option>
                            <option value="kesekretariatan" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'kesekretariatan') ? 'selected' : '' ?>>Kesekretariatan</option>
                            <option value="keuangan" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'keuangan') ? 'selected' : '' ?>>Keuangan</option>
                            <option value="psdm" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'psdm') ? 'selected' : '' ?>>PSDM</option>
                            <option value="adkesma" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'adkesma') ? 'selected' : '' ?>>Adkesma</option>
                            <option value="sosmas" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'sosmas') ? 'selected' : '' ?>>Sosmas</option>
                            <option value="dagri" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'dagri') ? 'selected' : '' ?>>Dagri</option>
                            <option value="mitbis" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'mitbis') ? 'selected' : '' ?>>Mitbis</option>
                            <option value="lugri" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'lugri') ? 'selected' : '' ?>>Lugri</option>
                            <option value="kastrat" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'kastrat') ? 'selected' : '' ?>>Kastrat</option>
                            <option value="komris" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'komris') ? 'selected' : '' ?>>Komris</option>
                            <option value="pp" <?= (isset($filters['kementerian']) && $filters['kementerian'] == 'pp') ? 'selected' : '' ?>>PP</option>
                        </select>
                    </div>
                    <div class="col-md-5 text-end">                        
                        <a href="<?= base_url('admin/pengurus') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-redo me-1"></i> Reset Filter</a>
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
                            <th>Nama Pengurus</th>
                            <th>Jabatan</th>
                            <th>Kategori</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pengurus_list)): ?>
                            <?php 
                            // Hitung nomor awal untuk pagination
                            $perPage = @$pager->getPerPage('default') ?: 10;
                            $currentPage = @$pager->getCurrentPage('default') ?: 1;
                            $no = 1 + (($currentPage - 1) * $perPage); 
                            ?>
                            <?php foreach ($pengurus_list as $pengurus): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($pengurus['nama']) ?></td>
                                    <td><?= esc($pengurus['jabatan']) ?></td>
                                    <td><?= esc($pengurus['kementerian']) ?></td>
                                    <td>
                                        <?php if (!empty($pengurus['foto'])): ?>
                                            <img 
                                                src="<?= esc($foto_base_url . $pengurus['foto']) ?>" 
                                                alt="Foto <?= esc($pengurus['nama']) ?>" 
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"
                                                onerror="this.onerror=null; this.src='https://placehold.co/50x50/E5E7EB/4B5563?text=N%2FA'"
                                            />
                                        <?php else: ?>
                                            <span class="text-muted">Tidak Ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <!-- Aksi: Edit (Mengarah ke halaman edit) -->
                                        <button class="btn btn-sm btn-outline-warning btn-edit" 
                                            title="Edit" 
                                            data-id="<?= $pengurus['id'] ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editPengurusModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Aksi: Hapus -->
                                        <a href="<?= base_url('admin/pengurus/delete/' . $pengurus['id']) ?>" 
                                            onclick="return confirm('Anda yakin ingin menghapus pengurus ini? Tindakan ini tidak dapat dibatalkan.');" 
                                            class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada data pengurus yang tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <!-- Paging dan informasi jumlah data -->
            <span class="text-muted small">
                <?php if (!empty($pengurus_list)): ?>
                    Menampilkan <?= count($pengurus_list) ?> Pengurus
                <?php else: ?>
                    Data kosong
                <?php endif; ?>
            </span>
            <?= isset($pager) ? $pager->links('default', 'bootstrap_pagination') : '' ?>
        </div>
    </div>
    
    <!-- Memanggil View Modal Create (Wajib ada) -->
    <?php echo view('admin/pengurus/create'); ?>

    <?= $this->include('admin/pengurus/edit') ?>
    <?= $this->include('admin/pengumuman/detail') ?> 

</div>
