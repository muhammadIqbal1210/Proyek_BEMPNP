<!-- app/Views/admin/kontak/create_modal.php -->
<div class="modal fade" id="createKontakModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i> Tambah Kontak Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/kontak/store') ?>" method="post">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Kontak</label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh: Admin Akademik"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="bem" <?= set_select('kategori', 'bem') ?>>BEM</option>
                                <option value="universitas" <?= set_select('kategori', 'universitas') ?>>Universitas</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Deskripsi Singkat</label>
                            <input type="text" name="deskripsi" class="form-control"
                                placeholder="Contoh: Bagian Pelayanan Mahasiswa">
                        </div>
                    </div>

                    <h6 class="fw-bold border-bottom pb-2 mb-3">Sosial Media & Link Kustom</h6>

                    <!-- WhatsApp -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="small text-muted">Nomor WhatsApp (Angka saja)</label>
                            <input type="text" name="whatsApp" class="form-control" placeholder="62812345678">
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Label Tampilan WA</label>
                            <input type="text" name="subjek_wa" class="form-control" placeholder="Contoh: Chat Admin">
                        </div>
                    </div>
                    <!-- WhatsApp -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="small text-muted">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="iqbal@gmail.com">
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Label Tampilan Email</label>
                            <input type="text" name="subjek_email" class="form-control"
                                placeholder="Contoh: Email Admin">
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="small text-muted">Link Instagram</label>
                            <input type="url" name="instagram" class="form-control"
                                placeholder="https://instagram.com/pnp">
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Label Tampilan Instagram</label>
                            <input type="text" name="subjek_ig" class="form-control"
                                placeholder="Contoh: Instagram Admin">
                        </div>
                    </div>

                    <!-- Website -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="small text-muted">URL Website</label>
                            <input type="url" name="website" class="form-control" placeholder="https://pnp.ac.id">
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">Label Tampilan Website</label>
                            <input type="text" name="subjek_website" class="form-control"
                                placeholder="Contoh: Website Resmi">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>