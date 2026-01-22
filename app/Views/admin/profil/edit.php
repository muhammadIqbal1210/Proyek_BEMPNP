<?php 
// File: app/Views/admin/profilorganisasi/edit_modal.php
// Modal untuk mengedit data Profil Organisasi
?>

<!-- Modal Edit Profil Organisasi -->
<div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editProfilModalLabel">
                    <i class="fa-solid fa-id-card-clip me-2"></i> Update Profil Organisasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form untuk menyimpan data. Action mengarah ke Controller ProfilOrganisasi/update -->
            <form action="<?= base_url('admin/profilorganisasi/update') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    
                    <!-- Nama Kabinet & Periode -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_kabinet" class="form-label">Nama Kabinet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_kabinet" name="nama_kabinet" 
                                value="<?= old('nama_kabinet', $profil['nama_kabinet'] ?? '') ?>" placeholder="Contoh: Kabinet Sinergi" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="periode" class="form-label">Periode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="periode" name="periode" 
                                value="<?= old('periode', $profil['periode'] ?? '') ?>" placeholder="Contoh: 2024-2025" required>
                        </div>
                    </div>

                    <!-- Visi -->
                    <div class="mb-3">
                        <label for="visi" class="form-label">Visi Organisasi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="visi" name="visi" rows="2" 
                            placeholder="Tuliskan visi utama organisasi..." required><?= old('visi', $profil['visi'] ?? '') ?></textarea>
                    </div>

                    <!-- Misi -->
                    <div class="mb-3">
                        <label for="misi" class="form-label">Misi (Gunakan baris baru untuk tiap poin)</label>
                        <textarea class="form-control" id="misi" name="misi" rows="4" 
                            placeholder="1. Poin misi pertama&#10;2. Poin misi kedua"><?= old('misi', $profil['misi'] ?? '') ?></textarea>
                        <div class="form-text">Tips: Pisahkan setiap poin misi dengan menekan Enter.</div>
                    </div>

                    <hr>

                    <!-- Sambutan Presiden & Wapres -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="s_pres" class="form-label">Sambutan Presiden</label>
                            <textarea class="form-control" id="s_pres" name="s_pres" rows="3" 
                                placeholder="Pesan dari Presiden..."><?= old('s_pres', $profil['s_pres'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="s_wapres" class="form-label">Sambutan Wakil Presiden</label>
                            <textarea class="form-control" id="s_wapres" name="s_wapres" rows="3" 
                                placeholder="Pesan dari Wapres..."><?= old('s_wapres', $profil['s_wapres'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- Video Profil & Foto Kabinet -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="videoprofil" class="form-label">Link Video Profil (YouTube/Drive URL)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-brands fa-youtube"></i></span>
                                <input type="url" class="form-control" id="videoprofil" name="videoprofil" 
                                    value="<?= old('videoprofil', $profil['videoprofil'] ?? '') ?>" placeholder="https://youtube.com/watch?v=...">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>