<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Pengajuan Event</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('member/event/update/' . $event['id']) ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_event">Nama Event *</label>
                                    <input type="text" class="form-control" id="nama_event" name="nama_event" value="<?= set_value('nama_event', $event['nama_event']) ?>" required>
                                    <?php if (isset($errors['nama_event'])): ?>
                                        <small class="text-danger"><?= $errors['nama_event'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="waktu">Waktu Event *</label>
                                    <input type="date" class="form-control" id="waktu" name="waktu" value="<?= set_value('waktu', $event['waktu']) ?>" required>
                                    <?php if (isset($errors['waktu'])): ?>
                                        <small class="text-danger"><?= $errors['waktu'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="biaya">Tipe Biaya</label>
                                    <select class="form-control" id="biaya" name="biaya">
                                        <option value="gratis" <?= ($event['biaya'] ?? '') == 'gratis' ? 'selected' : '' ?>>Gratis</option>
                                        <option value="berbayar" <?= ($event['biaya'] ?? '') == 'berbayar' ? 'selected' : '' ?>>Berbayar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="link_informasi">Link Informasi *</label>
                                    <input type="url" class="form-control" id="link_informasi" name="link_informasi" value="<?= set_value('link_informasi', $event['link_informasi']) ?>" required>
                                    <?php if (isset($errors['link_informasi'])): ?>
                                        <small class="text-danger"><?= $errors['link_informasi'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi *</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= set_value('deskripsi', $event['deskripsi']) ?></textarea>
                            <?php if (isset($errors['deskripsi'])): ?>
                                <small class="text-danger"><?= $errors['deskripsi'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="file_upload">File (Opsional)</label>
                            <input type="file" class="form-control" id="file_upload" name="file_upload">
                            <small class="form-text text-muted">Max: 5MB. Biarkan kosong jika tidak ingin mengubah.</small>
                            <?php if (isset($errors['file_upload'])): ?>
                                <small class="text-danger"><?= $errors['file_upload'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Pengajuan</button>
                            <a href="<?= base_url('member/event') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
