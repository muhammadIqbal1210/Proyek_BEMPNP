<!-- File: app/Views/admin/kontak/index.php -->
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Daftar Kontak</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active">Kontak</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createKontakModal">
            <i class="fas fa-plus me-1"></i> Tambah Kontak
        </button>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if (!empty($kontak_list)): ?>
            <?php foreach ($kontak_list as $k): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="fw-bold text-success"><?= esc($k['nama']) ?></h5>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editKontakModal<?= $k['id'] ?>"><i class="fas fa-edit me-2 text-warning"></i> Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="<?= base_url('admin/kontak/delete/' . $k['id']) ?>" onclick="return confirm('Hapus kontak ini?')"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="text-muted small"><?= esc($k['deskripsi']) ?></p>
                            <hr class="my-2 opacity-25">
                            
                            <!-- Menampilkan Link Kustom -->
                            <div class="small">
                                <?php if($k['whatsApp']): ?>
                                    <div class="mb-1"><i class="fab fa-whatsapp text-success me-2"></i><a href="https://wa.me/<?= $k['whatsApp'] ?>" target="_blank"><?= esc($k['subjek_wa'] ?: $k['whatsApp']) ?></a></div>
                                <?php endif; ?>
                                <?php if($k['instagram']): ?>
                                    <div class="mb-1"><i class="fab fa-instagram text-danger me-2"></i><a href="<?= $k['instagram'] ?>" target="_blank"><?= esc($k['subjek_ig'] ?: 'Instagram') ?></a></div>
                                <?php endif; ?>
                                <?php if($k['email']): ?>
                                    <div class="mb-1"><i class="far fa-envelope text-primary me-2"></i><a href="mailto:<?= $k['email'] ?>"><?= esc($k['subjek_email'] ?: $k['email']) ?></a></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Include Modal Edit per ID -->
                <?= view('admin/kontak/edit', ['k' => $k]) ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-address-book fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada data kontak.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Include Modal Create -->
<?= view('admin/kontak/create') ?>