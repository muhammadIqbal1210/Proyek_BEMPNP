<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profil Anda</h5>
                </div>
                <div class="card-body">
                    <!-- Alert Error Validation -->
                    <?php if (!empty($validation) && $validation->hasError('nama_lengkap')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Validasi Error:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($validation->getErrors() as $field => $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Success Alert -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('member/profile/update') ?>" method="POST">
                        <?= csrf_field() ?>

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" 
                                   class="form-control <?= (!empty($validation) && $validation->hasError('nama_lengkap')) ? 'is-invalid' : '' ?>" 
                                   id="nama_lengkap" 
                                   name="nama_lengkap"
                                   value="<?= esc($profile['nama_lengkap'] ?? set_value('nama_lengkap')) ?>"
                                   required>
                            <?php if (!empty($validation) && $validation->hasError('nama_lengkap')): ?>
                                <div class="invalid-feedback d-block">
                                    <?= esc($validation->getError('nama_lengkap')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Kementerian -->
                        <div class="mb-3">
                            <label for="kementerian" class="form-label">Kementerian</label>
                            <input type="text" 
                                   class="form-control <?= (!empty($validation) && $validation->hasError('kementerian')) ? 'is-invalid' : '' ?>" 
                                   id="kementerian" 
                                   name="kementerian"
                                   value="<?= esc($profile['kementerian'] ?? set_value('kementerian')) ?>"
                                   required>
                            <?php if (!empty($validation) && $validation->hasError('kementerian')): ?>
                                <div class="invalid-feedback d-block">
                                    <?= esc($validation->getError('kementerian')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Jabatan -->
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" 
                                   class="form-control <?= (!empty($validation) && $validation->hasError('jabatan')) ? 'is-invalid' : '' ?>" 
                                   id="jabatan" 
                                   name="jabatan"
                                   value="<?= esc($profile['jabatan'] ?? set_value('jabatan')) ?>"
                                   required>
                            <?php if (!empty($validation) && $validation->hasError('jabatan')): ?>
                                <div class="invalid-feedback d-block">
                                    <?= esc($validation->getError('jabatan')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control <?= (!empty($validation) && $validation->hasError('alamat')) ? 'is-invalid' : '' ?>" 
                                      id="alamat" 
                                      name="alamat"
                                      rows="3"><?= esc($profile['alamat'] ?? set_value('alamat')) ?></textarea>
                            <?php if (!empty($validation) && $validation->hasError('alamat')): ?>
                                <div class="invalid-feedback d-block">
                                    <?= esc($validation->getError('alamat')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- No Telepon -->
                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">No Telepon</label>
                            <input type="tel" 
                                   class="form-control <?= (!empty($validation) && $validation->hasError('no_telepon')) ? 'is-invalid' : '' ?>" 
                                   id="no_telepon" 
                                   name="no_telepon"
                                   value="<?= esc($profile['no_telepon'] ?? set_value('no_telepon')) ?>"
                                   placeholder="081234567890">
                            <?php if (!empty($validation) && $validation->hasError('no_telepon')): ?>
                                <div class="invalid-feedback d-block">
                                    <?= esc($validation->getError('no_telepon')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="<?= base_url('member/dashboard') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

