<?php ?>

<!-- Modal Tambah Event -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createEventModalLabel"><i class="fa-solid fa-calendar-days"></i> Tambah Event Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form untuk menyimpan data. Action mengarah ke Controller/save -->
            <form action="<?= base_url('admin/event/store') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <!-- Nama Event -->
                    <div class="mb-3">
                        <label for="nama_event" class="form-label">Nama Event <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_event" name="nama_event" 
                            value="<?= set_value('nama_event') ?>" placeholder="Contoh : Seminar Kewirausahan" required>
                    </div>
                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Event</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" 
                            placeholder="Jelaskan deskripsi event ini."><?= set_value('deskripsi') ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="waktu" class="form-label">Waktu Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="waktu" name="waktu" required value="<?= old('waktu') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="biaya" class="form-label">Biaya <span class="text-danger">*</span></label>
                        <select class="form-select" id="biaya" name="biaya" required>
                            <option value="berbayar" <?= old('biaya') == 'berbayar' ? 'selected' : '' ?>>Berbayar</option>
                            <option value="gratis" <?= old('biaya') == 'gratis' ? 'selected' : '' ?>>Gratis</option>
                        </select>
                    </div>
                    <div class="row">
                        <!-- Link Informasi -->
                        <div class="col-md-6 mb-3">
                            <label for="link_informasi" class="form-label">Link Informasi (URL)</label>
                            <input type="url" class="form-control" id="link_informasi" name="link_informasi" 
                                value="<?= set_value('link_informasi') ?>" placeholder="Contoh: https://event.kemendikbud.go.id">
                        </div>
                        <!-- Poster (File Upload) -->
                        <div class="mb-3">
                            <label for="file_save" class="form-label">Upload File (Max 2MB, JPG/PNG)</label>
                            <input type="file" class="form-control" id="file_save" name="file_save" accept=".jpg, .jpeg, .png">
                            <div class="form-text">File ini akan digunakan sebagai gambar promosi event.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Simpan Event</button>
                </div>
            </form>
        </div>
    </div>
</div>