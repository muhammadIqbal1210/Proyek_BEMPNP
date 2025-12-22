<?php 
// File: app/Views/admin/beasiswa/create_modal.php
// Modal untuk menambah data Beasiswa baru
?>

<!-- Modal Tambah Beasiswa -->
<div class="modal fade" id="createBeasiswaModal" tabindex="-1" aria-labelledby="createBeasiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createBeasiswaModalLabel"><i class="fa-solid fa-graduation-cap"></i> Tambah Beasiswa Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form untuk menyimpan data. Action mengarah ke Controller/save -->
            <form action="<?= base_url('admin/beasiswa/store') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <!-- Nama Beasiswa -->
                    <div class="mb-3">
                        <label for="nama_beasiswa" class="form-label">Nama Beasiswa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_beasiswa" name="nama_beasiswa" 
                            value="<?= set_value('nama_beasiswa') ?>" placeholder="Contoh: Beasiswa Unggulan Kemendikbud" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Beasiswa</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" 
                            placeholder="Jelaskan deskripsi dan persyratan beasiswa ini."><?= set_value('deskripsi') ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_buka" class="form-label">Tanggal Buka <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_buka" name="tanggal_buka" required value="<?= old('tanggal_buka') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_tutup" class="form-label">Tanggal Tutup <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_tutup" name="tanggal_tutup" required value="<?= old('tanggal_tutup') ?>">
                    </div>

                    <div class="row">
                        <!-- Status Beasiswa -->
                        <div class="col-md-6 mb-3">
                            <label for="status_beasiswa" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status_beasiswa" name="status_beasiswa" required>
                                <option value="" disabled selected>Pilih Status Pendaftaran</option>
                                <option value="buka" <?= set_select('status_beasiswa', 'buka') ?>>Buka Pendaftaran</option>
                                <option value="tutup" <?= set_select('status_beasiswa', 'tutup') ?>>Tutup Pendaftaran</option>
                                <option value="segera" <?= set_select('status_beasiswa', 'segera') ?>>Segera Hadir</option>
                            </select>
                        </div>

                        <!-- Link Informasi -->
                        <div class="col-md-6 mb-3">
                            <label for="link_informasi" class="form-label">Link Informasi (URL)</label>
                            <input type="url" class="form-control" id="link_informasi" name="link_informasi" 
                                value="<?= set_value('link_informasi') ?>" placeholder="Contoh: https://beasiswa.kemendikbud.go.id">
                        </div>
                    </div>
                    
                    <!-- Poster (File Upload) -->
                    <div class="mb-3">
                        <label for="poster_file" class="form-label">Upload Poster (Max 2MB, JPG/PNG)</label>
                        <input type="file" class="form-control" id="poster_file" name="poster_file" accept=".jpg, .jpeg, .png">
                        <div class="form-text">File ini akan digunakan sebagai gambar promosi beasiswa.</div>
                    </div>

                    <!-- Hidden field for Author (Jika diperlukan) -->
                    <!-- <input type="hidden" name="author" value="<//?= $author_id //?>"> -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Simpan Beasiswa</button>
                </div>
            </form>
        </div>
    </div>
</div>