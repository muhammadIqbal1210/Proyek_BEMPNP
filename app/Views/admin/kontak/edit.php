<!-- File: app/Views/admin/kontak/edit_modal.php -->
<div class="modal fade" id="editKontakModal<?= $k['id'] ?>" tabindex="-1" aria-labelledby="editKontakModalLabel<?= $k['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editKontakModalLabel<?= $k['id'] ?>"><i class="fas fa-edit me-2"></i>Edit Kontak: <?= esc($k['nama']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/kontak/update/' . $k['id']) ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row mb-3">
                        <!-- Informasi Utama -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Kontak / Departemen</label>
                            <input type="text" name="nama" class="form-control" value="<?= esc($k['nama']) ?>" placeholder="Contoh: Advokasi & Kesejahteraan Mahasiswa" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_kategori" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_kategori" name="kategori" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="bem" <?= set_select('kategori', 'bem') ?>>BEM</option>
                                <option value="universitas" <?= set_select('kategori', 'universitas') ?>>Universitas</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="2" placeholder="Jelaskan fungsi kontak ini..."><?= esc($k['deskripsi']) ?></textarea>
                        </div>
                    </div>
                
                        <h6 class="fw-bold mb-3 text-primary">Detail Media Sosial & Subjek Link</h6>
                        <div class="row mb-3">
                        <!-- WhatsApp Section -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="whatsApp" class="form-control" value="<?= esc($k['whatsApp']) ?>" placeholder="628123456789">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Label WhatsApp (Subjek)</label>
                            <input type="text" name="subjek_wa" class="form-control" value="<?= esc($k['subjek_wa']) ?>" placeholder="Contoh: Hubungi Admin Adkesma">
                        </div>

                        <!-- Instagram Section -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Link Instagram</label>
                            <input type="url" name="instagram" class="form-control" value="<?= esc($k['instagram']) ?>" placeholder="https://instagram.com/user">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Label Instagram (Subjek)</label>
                            <input type="text" name="subjek_ig" class="form-control" value="<?= esc($k['subjek_ig']) ?>" placeholder="Contoh: @adkesma_pnp">
                        </div>

                        <!-- Email Section -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= esc($k['email']) ?>" placeholder="bem@pnp.ac.id">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Label Email (Subjek)</label>
                            <input type="text" name="subjek_email" class="form-control" value="<?= esc($k['subjek_email']) ?>" placeholder="Contoh: Email Resmi Departemen">
                        </div>

                        <!-- Website/Link Section -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website / Link Lainnya</label>
                            <input type="url" name="website" class="form-control" value="<?= esc($k['website']) ?>" placeholder="https://linktree.com/user">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Label Website (Subjek)</label>
                            <input type="text" name="subjek_website" class="form-control" value="<?= esc($k['subjek_website']) ?>" placeholder="Contoh: Form Pengaduan">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>