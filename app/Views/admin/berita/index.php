<div class="container-fluid">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading small fw-bold">Gagal Menyimpan!</h4>
            <ul class="mb-0 small">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <ol class="breadcrumb mb-4" style="background: none; padding: 0;">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manajemen Berita</li>
    </ol>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-sm btn-success" 
                        data-bs-toggle="modal" data-bs-target="#createBeritaModal">
                    <i class="fas fa-plus me-1"></i> Tambah Berita Baru
                </button>
                
                <form method="GET" action="<?= base_url('admin/berita') ?>" class="d-flex">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="keyword" 
                               placeholder="Cari judul..." 
                               value="<?= esc($filters['keyword'] ?? '') ?>">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        <?php if(!empty($filters['keyword'])): ?>
                            <a href="<?= base_url('admin/berita') ?>" class="btn btn-secondary"><i class="fas fa-redo"></i></a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Judul Berita</th>
                            <th>Slug Berita</th>
                            <th>Tanggal</th>
                            <th>Gambar</th>
                            <th>Author</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($berita_list)): ?>
                            <?php 
                            $perPage = 10; 
                            $currentPage = (int)($pager->getCurrentPage() ?? 1);
                            $no = 1 + (($currentPage - 1) * $perPage); 
                            ?>
                            <?php foreach ($berita_list as $berita): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="fw-bold"><?= esc($berita['judulberita']) ?></td>
                                    <td><small class="text-muted"><?= esc($berita['slugberita']) ?></small></td>
                                    <td><?= date('d/m/Y', strtotime($berita['tanggalberita'])) ?></td>
                                    <td>
                                        <?php if (!empty($berita['gambarberita'])): ?>
                                            <img 
                                                src="<?= base_url('uploads/berita/' . $berita['gambarberita']) ?>" 
                                                alt="Gambar Berita" 
                                                style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;"
                                                onerror="this.onerror=null; this.src='https://placehold.co/60x40?text=No+Img'"
                                            />
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="badge bg-info text-dark"><?= esc($berita['author']) ?></span></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-warning btn-edit" 
                                                title="Edit Berita" 
                                                data-id="<?= $berita['id'] ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editBeritaModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="<?= base_url('admin/berita/delete/' . $berita['id']) ?>" 
                                                onclick="return confirm('Hapus berita ini?');" 
                                                class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-folder-open d-block mb-2 fa-2x"></i>
                                    Belum ada data berita.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <p class="mb-0 small text-muted">
                Menampilkan <strong><?= count($berita_list) ?></strong> data berita.
            </p>
            <div>
                <?= $pager->links('default', 'default_full') ?>
            </div>
        </div>
    </div>
    
    <!-- Modal Section -->
    <?= view('admin/berita/create') ?>
    <?= $this->include('admin/berita/edit') ?>
</div>