<?php 
// File: app/Views/admin/pengurus/create_modal.php
// Modal untuk menambah data Pengurus baru
?>

<!-- Modal Tambah Pengurus -->
<div class="modal fade" id="createPengurusModal" tabindex="-1" aria-labelledby="createPengurusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createPengurusModalLabel"><i class="fa-solid fa-trophy"></i> Tambah Pengurus Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form untuk menyimpan data. Action mengarah ke Controller/save -->
            <form action="<?= base_url('admin/pengurus/store') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <!-- Nama Pengurus -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pengurus <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                            value="<?= set_value('nama') ?>" placeholder="Contoh: Muhammad Iqbal" required>
                    </div>
                    <!-- Kategori -->
                     <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" 
                            value="<?= set_value('jabatan') ?>" placeholder="Contoh: Presiden Mahasiswa" required>
                    </div>
                    <div class="row">
                        <!-- Kementerian -->
                        <div class="col-md-6 mb-3">
                            <label for="kementerian" class="form-label">Kementerian <span class="text-danger">*</span></label>
                            <select class="form-select" id="kementerian" name="kementerian" required>
                                <option value="" disabled selected>Pilih Kementerian</option>
                                <option value="kepresidenan" <?= set_select('kementerian', 'kepresidenan') ?>>Kepresidenan</option>
                                <option value="audit_internal" <?= set_select('kementerian', 'audit_internal') ?>>Audit Internal</option>
                                <option value="kesekretariatan" <?= set_select('kementerian', 'kesekretariatan') ?>>Kesekretariatan</option>
                                <option value="keuangan" <?= set_select('kementerian', 'keuangan') ?>>Keuangan</option>
                                <option value="psdm" <?= set_select('kementerian', 'psdm') ?>>PSDM</option>
                                <option value="adkesma" <?= set_select('kementerian', 'adkesma') ?>>Adkesma</option>
                                <option value="sosmas" <?= set_select('kementerian', 'sosmas') ?>>Sosmas</option>
                                <option value="dagri" <?= set_select('kementerian', 'dagri') ?>>Dagri</option>
                                <option value="mitbis" <?= set_select('kementerian', 'mitbis') ?>>Mitbis</option>
                                <option value="lugri" <?= set_select('kementerian', 'lugri') ?>>Lugri</option>
                                <option value="kastrat" <?= set_select('kementerian', 'kastrat') ?>>Kastrat</option>
                                <option value="komris" <?= set_select('kementerian', 'komris') ?>>Komris</option>
                                <option value="pp" <?= set_select('kementerian', 'pp') ?>>PP</option>
                            </select>
                        </div>
                    </div>
                    <!-- foto (File Upload) -->
                    <div class="mb-3">
                        <label for="foto" class="form-label">Upload Foto (Max 2MB, JPG/PNG)</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept=".jpg, .jpeg, .png">
                        <div class="form-text">File ini akan digunakan sebagai foto pengurus.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Simpan Pengurus</button>
                </div>
            </form>
        </div>
    </div>
</div>