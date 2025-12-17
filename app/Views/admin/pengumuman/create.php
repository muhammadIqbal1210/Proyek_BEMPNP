<!-- Modal Buat Pengumuman Baru -->
<div class="modal fade" id="createPengumumanModal" tabindex="-1" aria-labelledby="createPengumumanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createPengumumanModalLabel"><i class="fa-solid fa-bullhorn me-2"></i>Formulir Pengumuman Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Tambahkan form_open_multipart karena ada file upload -->
            <?= form_open_multipart(base_url('admin/pengumuman/store')) ?>
            <div class="modal-body">
                
                <!-- Tampilkan error validasi (jika ada, setelah redirect) -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" required 
                        value="<?= set_value('title') ?>" placeholder="Judul Minimal 5 Huruf" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_publikasi" name="tanggal_publikasi" required value="<?= old('tanggal_publikasi') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="non-aktif" <?= old('status') == 'non-aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="file_pendukung" class="form-label">File Pendukung (Max 5MB: PDF, DOCX, PNG, JPEG, JPG)</label>
                    <input class="form-control" type="file" id="file_pendukung" name="file_pendukung">
                    <div class="form-text">File ini bersifat opsional.</div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">Simpan Pengumuman</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>