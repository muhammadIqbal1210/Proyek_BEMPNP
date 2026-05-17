<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Pengajuan Berita</h3>
                </div>
                <div class="card-body">
                    <?php $errors = $errors ?? session()->getFlashdata('errors') ?? []; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
                    <?php endif; ?>
                    <form action="<?= base_url('member/berita/update/' . $berita['id']) ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judulberita">Judul Berita *</label>
                                    <input type="text" class="form-control" id="judulberita" name="judulberita" value="<?= set_value('judulberita', $berita['judulberita']) ?>" required>
                                    <?php if (isset($errors['judulberita'])): ?>
                                        <small class="text-danger"><?= $errors['judulberita'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggalberita">Tanggal Berita *</label>
                                    <input type="date" class="form-control" id="tanggalberita" name="tanggalberita" value="<?= set_value('tanggalberita', $berita['tanggalberita']) ?>" required>
                                    <?php if (isset($errors['tanggalberita'])): ?>
                                        <small class="text-danger"><?= $errors['tanggalberita'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="isiberita">Isi Berita *</label>
                            <textarea class="form-control" id="isiberita" name="isiberita" rows="6" required><?= set_value('isiberita', $berita['isiberita']) ?></textarea>
                            <?php if (isset($errors['isiberita'])): ?>
                                <small class="text-danger"><?= $errors['isiberita'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="gambarberita_file">Gambar Berita (Opsional)</label>
                            <input type="file" class="form-control" id="gambarberita_file" name="gambarberita_file" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, Max: 2MB. Biarkan kosong jika tidak ingin mengubah.</small>
                            <?php if (isset($errors['gambarberita_file'])): ?>
                                <small class="text-danger"><?= $errors['gambarberita_file'] ?></small>
                            <?php endif; ?>
                            <?php if (!empty($berita['gambarberita'])): ?>
                                <div class="mt-2">
                                    <label>Gambar Saat Ini:</label><br>
                                    <img src="<?= base_url('uploads/berita/' . $berita['gambarberita']) ?>" alt="Gambar" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Pengajuan</button>
                            <a href="<?= base_url('member/berita') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
