<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Pengajuan Beasiswa</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('member/beasiswa/update/' . $beasiswa['id']) ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_beasiswa">Nama Beasiswa *</label>
                                    <input type="text" class="form-control" id="nama_beasiswa" name="nama_beasiswa" value="<?= set_value('nama_beasiswa', $beasiswa['nama_beasiswa']) ?>" required>
                                    <?php if (isset($errors['nama_beasiswa'])): ?>
                                        <small class="text-danger"><?= $errors['nama_beasiswa'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="link_informasi">Link Informasi *</label>
                                    <input type="url" class="form-control" id="link_informasi" name="link_informasi" value="<?= set_value('link_informasi', $beasiswa['link_informasi']) ?>" required>
                                    <?php if (isset($errors['link_informasi'])): ?>
                                        <small class="text-danger"><?= $errors['link_informasi'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_buka">Tanggal Buka *</label>
                                    <input type="date" class="form-control" id="tanggal_buka" name="tanggal_buka" value="<?= set_value('tanggal_buka', $beasiswa['tanggal_buka']) ?>" required>
                                    <?php if (isset($errors['tanggal_buka'])): ?>
                                        <small class="text-danger"><?= $errors['tanggal_buka'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_tutup">Tanggal Tutup *</label>
                                    <input type="date" class="form-control" id="tanggal_tutup" name="tanggal_tutup" value="<?= set_value('tanggal_tutup', $beasiswa['tanggal_tutup']) ?>" required>
                                    <?php if (isset($errors['tanggal_tutup'])): ?>
                                        <small class="text-danger"><?= $errors['tanggal_tutup'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi *</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= set_value('deskripsi', $beasiswa['deskripsi']) ?></textarea>
                            <?php if (isset($errors['deskripsi'])): ?>
                                <small class="text-danger"><?= $errors['deskripsi'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="poster_file">Poster (Opsional)</label>
                            <input type="file" class="form-control" id="poster_file" name="poster_file" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, Max: 2MB. Biarkan kosong jika tidak ingin mengubah.</small>
                            <?php if (isset($errors['poster_file'])): ?>
                                <small class="text-danger"><?= $errors['poster_file'] ?></small>
                            <?php endif; ?>
                            <?php if (!empty($beasiswa['poster'])): ?>
                                <div class="mt-2">
                                    <label>Poster Saat Ini:</label><br>
                                    <img src="<?= base_url('uploads/beasiswa/' . $beasiswa['poster']) ?>" alt="Poster" style="max-width: 200px;">
                                    <br>
                                    <input type="checkbox" id="remove_poster" name="remove_poster" value="1">
                                    <label for="remove_poster">Hapus poster</label>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Pengajuan</button>
                            <a href="<?= base_url('member/beasiswa') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
