<!-- ======================================================= -->
<!-- MODAL EDIT BEASISWA (CONTENT PROVIDED BY USER) -->
<!-- ======================================================= -->
<div class="modal fade" id="editBeasiswaModal" tabindex="-1" aria-labelledby="editBeasiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editBeasiswaModalLabel"><i class="fa-solid fa-graduation-cap"></i> Edit Beasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form Action akan diisi oleh JavaScript -->
            <?= form_open_multipart('', ['id' => 'editForm', 'method' => 'POST']) ?>
            <div class="modal-body">
                <!-- ID tersembunyi untuk proses update -->
                <input type="hidden" name="id" id="edit_id">

                <div class="mb-3">
                    <label for="edit_nama_beasiswa" class="form-label">Nama Beasiswa</label>
                    <input type="text" class="form-control" id="edit_nama_beasiswa" name="nama_beasiswa" required>
                </div>
                
                <div class="mb-3">
                    <label for="edit_deskripsi" class="form-label">Deskripsi Beasiswa</label>
                    <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3" 
                            placeholder="Jelaskan deskripsi dan persyratan beasiswa ini."><?= set_value('deskripsi') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="edit_status_beasiswa" class="form-label">Status</label>
                    <select class="form-control" id="edit_status_beasiswa" name="status_beasiswa" required>
                        <option value="buka">Buka (Aktif)</option>
                        <option value="tutup">Tutup (Non-Aktif)</option>
                        <option value="segera">Segera (Draf)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="edit_link_informasi" class="form-label">Link Informasi</label>
                    <input type="url" class="form-control" id="edit_link_informasi" name="link_informasi" required>
                </div>

                <div class="mb-3">
                    <label for="edit_poster_file" class="form-label">Poster Baru (Max 5MB)</label>
                    <input type="file" class="form-control" id="edit_poster_file" name="poster_file">
                    <small class="form-text text-muted">Abaikan jika tidak ingin mengganti file.</small>
                </div>
                
                <div class="mb-3">
                    <p id="current_file_info" class="text-sm fw-bold" style="display:none;"></p>
                    <div class="form-check" id="remove_file_group" style="display:none;">
                        <input class="form-check-input" type="checkbox" name="remove_file" value="1" id="edit_removeFile">
                        <label class="form-check-label" for="edit_removeFile">Hapus file yang sudah ada</label>
                    </div>
                    <p class="mt-2 text-muted small" id="no_file_info" style="display:none;">Belum ada file terlampir.</p>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update Beasiswa</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- ======================================================= -->
<!-- SCRIPT UNTUK AJAX AMBIL DATA DAN ISI MODAL -->
<!-- Pastikan library Bootstrap JS dan jQuery (jika digunakan) sudah dimuat -->
<!-- ======================================================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // PERBAIKAN: Menggunakan ID modal yang benar: 'editBeasiswaModal'
        const editModal = document.getElementById('editBeasiswaModal');
        const editForm = document.getElementById('editForm');
        // Base URL diambil dari PHP (assuming base_url() helper works here)
        const baseUrl = '<?= base_url('admin/beasiswa') ?>';

        if (!editModal) {
            console.error("Error: Element modal dengan ID 'editBeasiswaModal' tidak ditemukan.");
            return;
        }

        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const beasiswaId = button.getAttribute('data-id');

            // Verifikasi ID sebelum melanjutkan
            if (!beasiswaId) {
                console.error("Error: Tombol edit tidak memiliki atribut data-id.");
                // alert('Gagal memuat data: ID beasiswa tidak ditemukan pada tombol.'); // Replacing alert with console error and graceful exit
                const modalInstance = bootstrap.Modal.getInstance(editModal);
                if(modalInstance) modalInstance.hide();
                return;
            }

            // 2. Atur action form ke URL Update yang benar
            editForm.setAttribute('action', `${baseUrl}/update/${beasiswaId}`);
            
            // 3. Lakukan AJAX call untuk mengambil data beasiswa (Controller::edit)
            fetch(`${baseUrl}/edit/${beasiswaId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Standard practice for AJAX requests in some frameworks
                }
            })
                .then(response => {
                    if (!response.ok) {
                        // Jika respons bukan 200 OK
                        const errorMessage = response.status === 404 
                            ? 'Beasiswa tidak ditemukan (404).' 
                            : 'Gagal mengambil data beasiswa. Status: ' + response.status;
                        throw new Error(errorMessage);
                    }
                    return response.json();
                })
                .then(data => {
                    // 4. Isi data ke dalam field modal
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_nama_beasiswa').value = data.nama_beasiswa;
                    document.getElementById('edit_deskripsi').value = data.deskripsi;
                    // Pastikan value status sesuai dengan option value ('buka', 'tutup', 'segera')
                    document.getElementById('edit_status_beasiswa').value = data.status_beasiswa.toLowerCase(); 
                    document.getElementById('edit_link_informasi').value = data.link_informasi;

                    // 5. Penanganan File Pendukung
                    const currentFileInfo = document.getElementById('current_file_info');
                    const removeFileGroup = document.getElementById('remove_file_group');
                    const noFileInfo = document.getElementById('no_file_info');
                    
                    if (data.poster && data.poster !== '') {
                        const posterUrl = `<?= base_url('uploads/beasiswa/') ?>${data.poster}`;
                        currentFileInfo.innerHTML = `Poster saat ini: <a href="${posterUrl}" target="_blank" class="text-primary">${data.poster}</a>`;
                        currentFileInfo.style.display = 'block';
                        removeFileGroup.style.display = 'block';
                        noFileInfo.style.display = 'none';
                    } else {
                        currentFileInfo.innerHTML = '';
                        currentFileInfo.style.display = 'none';
                        removeFileGroup.style.display = 'none';
                        noFileInfo.style.display = 'block';
                    }
                    // Reset checkbox hapus file
                    document.getElementById('edit_removeFile').checked = false;
                })
                .catch(error => {
                    console.error('Error saat memuat data:', error);
                    // Hide modal on failure
                    const modalInstance = bootstrap.Modal.getInstance(editModal);
                    if(modalInstance) modalInstance.hide();
                    
                    // You might want to display a user-friendly error message here
                    // e.g., by setting a flash message or using a custom toast/modal
                });
        });
        
        // Reset file input saat modal ditutup
        editModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('edit_poster_file').value = '';
        });
    });
</script>