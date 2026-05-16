<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Pengajuan Lomba</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('member/lomba/update/' . $lomba['id']) ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_lomba">Nama Lomba *</label>
                                    <input type="text" class="form-control" id="nama_lomba" name="nama_lomba" value="<?= set_value('nama_lomba', $lomba['nama_lomba']) ?>" required>
                                    <?php if (isset($errors['nama_lomba'])): ?>
                                        <small class="text-danger"><?= $errors['nama_lomba'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kategori">Kategori *</label>
                                    <input type="text" class="form-control" id="kategori" name="kategori" value="<?= set_value('kategori', $lomba['kategori']) ?>" required>
                                    <?php if (isset($errors['kategori'])): ?>
                                        <small class="text-danger"><?= $errors['kategori'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi *</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= set_value('deskripsi', $lomba['deskripsi']) ?></textarea>
                            <?php if (isset($errors['deskripsi'])): ?>
                                <small class="text-danger"><?= $errors['deskripsi'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="link_informasi">Link Informasi *</label>
                            <input type="url" class="form-control" id="link_informasi" name="link_informasi" value="<?= set_value('link_informasi', $lomba['link_informasi']) ?>" required>
                            <?php if (isset($errors['link_informasi'])): ?>
                                <small class="text-danger"><?= $errors['link_informasi'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="poster_file">Poster (Opsional)</label>
                            <input type="file" class="form-control" id="poster_file" name="poster_file" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, Max: 2MB. Biarkan kosong jika tidak ingin mengubah.</small>
                            <?php if (isset($errors['poster_file'])): ?>
                                <small class="text-danger"><?= $errors['poster_file'] ?></small>
                            <?php endif; ?>
                            <?php if (!empty($lomba['poster'])): ?>
                                <div class="mt-2">
                                    <label>Poster Saat Ini:</label><br>
                                    <img src="<?= base_url('uploads/lomba/' . $lomba['poster']) ?>" alt="Poster" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Pengajuan</button>
                            <a href="<?= base_url('member/lomba') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
