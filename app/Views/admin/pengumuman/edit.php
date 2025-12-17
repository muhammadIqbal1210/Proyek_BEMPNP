
<!-- ======================================================= -->
<!-- MODAL EDIT PENGUMUMAN -->
<!-- ======================================================= -->
<div class="modal fade" id="editPengumumanModal" tabindex="-1" aria-labelledby="editPengumumanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editPengumumanModalLabel"><i class="fa-solid fa-bullhorn me-2"></i>Edit Pengumuman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form Action akan diisi oleh JavaScript -->
            <?= form_open_multipart('', ['id' => 'editForm']) ?>
            <div class="modal-body">
                <!-- ID tersembunyi untuk proses update -->
                <input type="hidden" name="id" id="edit_id">

                <div class="mb-3">
                    <label for="edit_title" class="form-label">Judul Pengumuman</label>
                    <input type="text" class="form-control" id="edit_title" name="title" required>
                </div>
                
                <div class="mb-3">
                    <label for="edit_tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                    <input type="date" class="form-control" id="edit_tanggal_publikasi" name="tanggal_publikasi" required>
                </div>

                <div class="mb-3">
                    <label for="edit_status" class="form-label">Status</label>
                    <select class="form-control" id="edit_status" name="status" required>
                        <option value="aktif">Aktif</option>
                        <option value="non-aktif">Non-Aktif</option>
                        <option value="draf">Draf</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_file_pendukung" class="form-label">File Pendukung Baru (Max 5MB)</label>
                    <input type="file" class="form-control" id="edit_file_pendukung" name="file_pendukung">
                    <small class="form-text text-muted">Abaikan jika tidak ingin mengganti file.</small>
                </div>
                
                <div class="mb-3">
                    <p id="current_file_info" style="display:none;"></p>
                    <div class="form-check" id="remove_file_group" style="display:none;">
                        <input class="form-check-input" type="checkbox" name="remove_file" value="1" id="edit_removeFile">
                        <label class="form-check-label" for="edit_removeFile">Hapus file yang sudah ada</label>
                    </div>
                    <p class="mt-2 text-muted" id="no_file_info" style="display:none;">Belum ada file terlampir.</p>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update Pengumuman</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- ======================================================= -->
<!-- SCRIPT UNTUK AJAX AMBIL DATA DAN ISI MODAL -->
<!-- ======================================================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // PERBAIKAN: Menggunakan ID modal yang benar: 'editPengumumanModal'
        const editModal = document.getElementById('editPengumumanModal');
        const editForm = document.getElementById('editForm');
        // Base URL diambil dari PHP
        const baseUrl = '<?= base_url('admin/pengumuman') ?>';

        if (!editModal) {
            console.error("Error: Element modal dengan ID 'editPengumumanModal' tidak ditemukan.");
            return;
        }

        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const pengumumanId = button.getAttribute('data-id');
            
            // Verifikasi ID sebelum melanjutkan
            if (!pengumumanId) {
                console.error("Error: Tombol edit tidak memiliki atribut data-id.");
                alert('Gagal memuat data: ID pengumuman tidak ditemukan pada tombol.');
                const modalInstance = bootstrap.Modal.getInstance(editModal);
                if(modalInstance) modalInstance.hide();
                return;
            }

            // 1. Atur action form ke URL Update yang benar
            editForm.setAttribute('action', `${baseUrl}/update/${pengumumanId}`);
            
            // 2. Lakukan AJAX call untuk mengambil data pengumuman (Controller::edit)
            fetch(`${baseUrl}/edit/${pengumumanId}`)
                .then(response => {
                    if (!response.ok) {
                        // Jika respons bukan 200 OK, periksa apakah 404
                        if (response.status === 404) {
                            throw new Error('Pengumuman tidak ditemukan (404).');
                        }
                        throw new Error('Gagal mengambil data pengumuman. Respons status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    // 3. Isi data ke dalam field modal
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_title').value = data.title;
                    document.getElementById('edit_tanggal_publikasi').value = data.tanggal_publikasi;
                    document.getElementById('edit_status').value = data.status;

                    // 4. Penanganan File Pendukung
                    const currentFileInfo = document.getElementById('current_file_info');
                    const removeFileGroup = document.getElementById('remove_file_group');
                    const noFileInfo = document.getElementById('no_file_info');
                    
                    if (data.file_path) {
                        currentFileInfo.innerHTML = `File saat ini: <a href="<?= base_url('uploads/pengumuman/') ?>${data.file_path}" target="_blank">${data.file_path}</a>`;
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
                    console.error('Error:', error);
                    alert('Gagal memuat data: ' + error.message);
                    const modalInstance = bootstrap.Modal.getInstance(editModal);
                    if(modalInstance) modalInstance.hide();
                });
        });
        
        // Reset file input saat modal ditutup
        editModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('edit_file_pendukung').value = '';
        });
    });
</script>