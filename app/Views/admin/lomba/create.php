<?php 
// File: app/Views/admin/lomba/create_modal.php
// Modal untuk menambah data Lomba baru
?>

<!-- Modal Tambah Lomba -->
<div class="modal fade" id="createLombaModal" tabindex="-1" aria-labelledby="createLombaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createLombaModalLabel"><i class="fa-solid fa-trophy"></i> Tambah Lomba Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form untuk menyimpan data. Action mengarah ke Controller/save -->
            <form action="<?= base_url('admin/lomba/store') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <!-- Nama Lomba -->
                    <div class="mb-3">
                        <label for="nama_lomba" class="form-label">Nama Lomba <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_lomba" name="nama_lomba" 
                            value="<?= set_value('nama_lomba') ?>" placeholder="Contoh: Lomba Hari Kesehatan Indonesia" required>
                    </div>
                    <!-- Kategori -->
                     <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kategori" name="kategori" 
                            value="<?= set_value('kategori') ?>" placeholder="Contoh: Karya Tulis Ilmiah" required>
                    </div>
                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Lomba</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" 
                            placeholder="Jelaskan deskripsi dan persyratan lomba ini."><?= set_value('deskripsi') ?></textarea>
                    </div>

                    <div class="row">
                        <!-- Status Lomba -->
                        <div class="col-md-6 mb-3">
                            <label for="status_lomba" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status_lomba" name="status_lomba" required>
                                <option value="" disabled selected>Pilih Status Pendaftaran</option>
                                <option value="buka" <?= set_select('status_lomba', 'buka') ?>>Buka Pendaftaran</option>
                                <option value="tutup" <?= set_select('status_lomba', 'tutup') ?>>Tutup Pendaftaran</option>
                                <option value="segera" <?= set_select('status_lomba', 'segera') ?>>Segera Hadir</option>
                            </select>
                        </div>

                        <!-- Link Informasi -->
                        <div class="col-md-6 mb-3">
                            <label for="link_informasi" class="form-label">Link Informasi (URL)</label>
                            <input type="url" class="form-control" id="link_informasi" name="link_informasi" 
                                value="<?= set_value('link_informasi') ?>" placeholder="Contoh: https://lomba.kemendikbud.go.id">
                        </div>
                    </div>
                    
                    <!-- Poster (File Upload) -->
                    <div class="mb-3">
                        <label for="poster_file" class="form-label">Upload Poster (Max 2MB, JPG/PNG)</label>
                        <input type="file" class="form-control" id="poster_file" name="poster_file" accept=".jpg, .jpeg, .png">
                        <div class="form-text">File ini akan digunakan sebagai gambar promosi lomba.</div>
                    </div>

                    <!-- Hidden field for Author (Jika diperlukan) -->
                    <!-- <input type="hidden" name="author" value="<//?= $author_id //?>"> -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Simpan Lomba</button>
                </div>
            </form>
        </div>
    </div>
</div>