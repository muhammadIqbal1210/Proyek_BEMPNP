<div>
    <?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
            <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php endif ?>
    <ol class="breadcrumb" style="background: none; padding: 0;">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profil Organisasi</li>
    </ol>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                data-bs-target="#createProfilModal">
                <i class="fas fa-plus me-1"></i> Tambah Profil Organisasi
            </button>
            <hr>

            <form method="GET" action="<?= base_url('admin/profil') ?>">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword"
                                placeholder="Cari Profil Organisasi..." aria-label="Search"
                                value="<?= esc(isset($filters['keyword']) ? $filters['keyword'] : '') ?>">
                            <button class="btn btn-outline-secondary" type="submit"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-8 text-end">
                        <a href="<?= base_url('admin/profil') ?>" class="btn btn-sm btn-secondary"><i
                                class="fas fa-redo me-1"></i> Reset Filter</a>
                    </div>
                </div>
        </div>
    </div>

    <div class="row mb-4">
        <?php if (!empty($profil_list)): ?>
        <?php foreach ($profil_list as $profil): ?>
        <div class="col-12">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="row g-0">
                    <!-- Bagian Kiri: Video / Visual -->
                    <div class="col-md-4 bg-dark d-flex align-items-center justify-content-center"
                        style="min-height: 250px;">
                        <?php 
                                // Logika sederhana mengubah link youtube biasa ke embed
                                $video_url = $profil['videoprofil'];
                                if (strpos($video_url, 'watch?v=') !== false) {
                                    $video_url = str_replace('watch?v=', 'embed/', $video_url);
                                }
                            ?>
                        <div class="ratio ratio-16x9">
                            <iframe src="<?= esc($video_url) ?>" title="Video Profil" allowfullscreen></iframe>
                        </div>
                    </div>

                    <!-- Bagian Kanan: Informasi -->
                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h3 class="card-title fw-bold text-success mb-0">
                                        <?= esc($profil['nama_kabinet']) ?>
                                    </h3>
                                    <span class="badge bg-soft-success text-success mt-2"
                                        style="background-color: #e7f1ff; color: #0d6efd;">
                                        <i class="far fa-calendar-alt me-1"></i> Periode <?= esc($profil['periode']) ?>
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <!-- Menggunakan data-bs-target untuk memicu modal dan data-id untuk identitas data -->
                                            <a class="dropdown-item btn-edit-profil" href="javascript:void(0)"
                                                data-bs-toggle="modal" data-bs-target="#editProfilModal"
                                                data-id="<?= $profil['id'] ?>">
                                                <i class="fas fa-edit me-2 text-warning"></i> Edit Profil
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger"
                                                href="<?= base_url('admin/profil/delete/' . $profil['id']) ?>"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus profil kabinet ini?')">
                                                <i class="fas fa-trash me-2"></i> Hapus
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class="text-muted small fw-bold text-uppercase">Visi</label>
                                    <p class="text-secondary italic">"<?= esc($profil['visi']) ?>"</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small fw-bold text-uppercase">Misi</label>
                                    <ul class="list-unstyled mb-0">
                                        <?php 
                                            $misi = json_decode($profil['misi'], true);
                                            if (is_array($misi)):
                                                foreach (array_slice($misi, 0, 3) as $m): ?>
                                        <li class="small text-secondary mb-1">
                                            <i class="fas fa-check-circle text-success me-2"></i><?= esc($m) ?>
                                        </li>
                                        <?php endforeach;
                                                if (count($misi) > 3): ?>
                                        <li class="small text-success mt-1">+ <?= count($misi) - 3 ?> Misi lainnya</li>
                                        <?php endif;
                                            endif; ?>
                                    </ul>
                                </div>
                            </div>

                            <hr class="my-3 opacity-25">

                            <div class="d-flex align-items-center">
                                <div class="me-4">
                                    <span class="text-muted small d-block">Presiden Mahasiswa</span>
                                    <span class="fw-bold text-dark"><?= esc($profil['s_pres']) ?></span>
                                </div>
                                <div class="border-start ps-4">
                                    <span class="text-muted small d-block">Wakil Presiden Mahasiswa</span>
                                    <span class="fw-bold text-dark"><?= esc($profil['s_wapres']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="col-12 text-center py-4 bg-light rounded-3 border-dashed">
            <i class="fas fa-id-card fa-3x text-muted mb-3"></i>
            <p class="text-muted">Data profil kabinet belum tersedia.</p>
        </div>
        <?php endif; ?>
        <?php echo view('admin/profil/create'); ?>

        <?= $this->include('admin/profil/edit') ?>
    </div>
</div>