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
        <li class="breadcrumb-item active" aria-current="page">Berita</li>
    </ol>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <button type="button" class="btn btn-sm btn-success" 
                    data-bs-toggle="modal" data-bs-target="#createBeritaModal">
                <i class="fas fa-plus me-1"></i> Tambah Berita
            </button>
            <hr>
            
            <form method="GET" action="<?= base_url('admin/berita') ?>">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" 
                                placeholder="Cari Berita..." aria-label="Search"
                                value="<?= esc(isset($filters['keyword']) ? $filters['keyword'] : '') ?>">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-5 text-end">                        
                        <a href="<?= base_url('admin/berita') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-redo me-1"></i> Reset Filter</a>
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
                            <th>Nama Berita</th>
                            <th>Deskripsi</th>
                            <th>Link Informasi</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($berita_list)): ?>
                            <?php 
                            // Hitung nomor awal untuk pagination
                            $perPage = @$pager->getPerPage() ?: 10;
                            $currentPage = @$pager->getCurrentPage() ?: 1;
                            $no = 1 + (($currentPage - 1) * $perPage); 
                            ?>
                            <?php foreach ($berita_list as $berita): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($berita['nama_berita']) ?></td>
                                    <td><?= esc($berita['deskripsi']) ?></td>
                                    <td>
                                        <?php if (!empty($berita['link_informasi'])): ?>
                                            <a href="<?= esc($berita['link_informasi']) ?>" target="_blank" class="text-primary" title="Kunjungi Link"><i class="fas fa-external-link-alt"></i></a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($berita['file'])): ?>
                                            <img 
                                                src="<?= esc($file_base_url . $berita['file']) ?>" 
                                                alt="File <?= esc($berita['nama_berita']) ?>" 
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
                                            data-id="<?= $berita['id'] ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editBeritaModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Aksi: Hapus -->
                                        <a href="<?= base_url('admin/berita/delete/' . $berita['id']) ?>" 
                                            onclick="return confirm('Anda yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.');" 
                                            class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada data berita yang tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <!-- Paging dan informasi jumlah data -->
            <span class="text-muted small">
                <?php if (!empty($berita_list)): ?>
                    Menampilkan <?= count($berita_list) ?> Berita
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
    <?php echo view('admin/berita/create'); ?>

    <?= $this->include('admin/berita/edit') ?>
    <?= $this->include('admin/pengumuman/detail') ?> 

</div>