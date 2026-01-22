<!-- ======================================================= -->
<!-- MODAL EDIT PENGURUS (CONTENT PROVIDED BY USER) -->
<!-- ======================================================= -->
<div class="modal fade" id="editPengurusModal" tabindex="-1" aria-labelledby="editPengurusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editPengurusModalLabel"><i class="fa-solid fa-trophy"></i> Edit Pengurus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form Action akan diisi oleh JavaScript -->
            <?= form_open_multipart('', ['id' => 'editForm', 'method' => 'POST']) ?>
            <div class="modal-body">
                <!-- ID tersembunyi untuk proses update -->
                <input type="hidden" name="id" id="edit_id">

                <div class="mb-3">
                    <label for="edit_nama" class="form-label">Nama Pengurus</label>
                    <input type="text" class="form-control" id="edit_nama" name="nama" required>
                </div>

                <div class="mb-3">
                    <label for="edit_jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="edit_jabatan" name="jabatan" required>
                </div>

                <div class="mb-3">
                    <label for="edit_kementerian" class="form-label">Kementerian</label>
                    <select class="form-control" id="edit_kementerian" name="kementerian" required>
                        <option value="kepresidenan">Kepresidenan</option>
                        <option value="audit_internal">Audit Internal</option>
                        <option value="kesekretariatan">Kesekretariatan</option>
                        <option value="keuangan">Keuangan</option>
                        <option value="psdm">PSDM</option>
                        <option value="adkesma">Adkesma</option>
                        <option value="sosmas">Sosmas</option>
                        <option value="dagri">Dagri</option>
                        <option value="mitbis">Mitbis</option>
                        <option value="lugri">Lugri</option>
                        <option value="kastrat">Kastrat</option>
                        <option value="komris">Komris</option>
                        <option value="pp">PP</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_foto" class="form-label">Ganti Foto (Abaikan jika tidak ingin mengganti) </label>
                    <input type="file" class="form-control" id="edit_foto" name="foto" accept=".jpg, .jpeg, .png">
                </div>

                <!-- Info Foto Saat Ini -->
                <div class="mb-3 p-2 border rounded bg-light">
                    <small class="text-muted d-block mb-2">Foto saat ini:</small>
                    <div id="preview_foto_container" style="display:none;">
                        <img src="" id="img_preview" class="img-thumbnail mb-2" style="max-height: 150px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remove_foto" value="1"
                                id="edit_removeFoto">
                            <label class="form-check-label text-danger" for="edit_removeFoto">Hapus foto ini</label>
                        </div>
                    </div>
                    <p class="text-muted small mb-0" id="no_foto_info" style="display:none;">Tidak ada foto terlampir.
                    </p>
                </div>

                <div class="mb-3">
                    <p id="current_file_info" class="text-sm fw-bold" style="display:none;"></p>
                    <div class="form-check" id="remove_file_group" style="display:none;">
                        <input class="form-check-input" type="checkbox" name="remove_file" value="1"
                            id="edit_removeFile">
                        <label class="form-check-label" for="edit_removeFile">Hapus file yang sudah ada</label>
                    </div>
                    <p class="mt-2 text-muted small" id="no_file_info" style="display:none;">Belum ada file terlampir.
                    </p>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update Pengurus</button>
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
    // PERBAIKAN: Menggunakan ID modal yang benar: 'editPengurusModal'
    const editModal = document.getElementById('editPengurusModal');
    const editForm = document.getElementById('editForm');
    // Base URL diambil dari PHP (assuming base_url() helper works here)
    const baseUrl = '<?= base_url('admin/pengurus') ?>';

    if (!editModal) {
        console.error("Error: Element modal dengan ID 'editPengurusModal' tidak ditemukan.");
        return;
    }

    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const pengurusId = button.getAttribute('data-id');

        // Verifikasi ID sebelum melanjutkan
        if (!pengurusId) {
            console.error("Error: Tombol edit tidak memiliki atribut data-id.");
            // alert('Gagal memuat data: ID pengurus tidak ditemukan pada tombol.'); // Replacing alert with console error and graceful exit
            const modalInstance = bootstrap.Modal.getInstance(editModal);
            if (modalInstance) modalInstance.hide();
            return;
        }

        // 2. Atur action form ke URL Update yang benar
        editForm.setAttribute('action', `${baseUrl}/update/${pengurusId}`);

        // 3. Lakukan AJAX call untuk mengambil data pengurus (Controller::edit)
        fetch(`${baseUrl}/edit/${pengurusId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Standard practice for AJAX requests in some frameworks
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Jika respons bukan 200 OK
                    const errorMessage = response.status === 404 ?
                        'Pengurus tidak ditemukan (404).' :
                        'Gagal mengambil data pengurus. Status: ' + response.status;
                    throw new Error(errorMessage);
                }
                return response.json();
            })
            .then(data => {
                // 4. Isi data ke dalam field modal
                document.getElementById('edit_id').value = data.id;
                document.getElementById('edit_nama').value = data.nama;
                document.getElementById('edit_jabatan').value = data.jabatan;
                document.getElementById('edit_kementerian').value = data.kementerian;

                const previewContainer = document.getElementById('preview_foto_container');
                const imgPreview = document.getElementById('img_preview');
                const noFotoInfo = document.getElementById('no_foto_info');

                if (data.foto && data.foto !== '') {
                    imgPreview.src = `<?= base_url('uploads/pengurus/') ?>/${data.foto}`;
                    previewContainer.style.display = 'block';
                    noFotoInfo.style.display = 'none';
                } else {
                    previewContainer.style.display = 'none';
                    noFotoInfo.style.display = 'block';
                }

                // Reset checkbox hapus
                document.getElementById('edit_removeFoto').checked = false;
            })
            .catch(error => {
                console.error('Error saat memuat data:', error);
                // Hide modal on failure
                const modalInstance = bootstrap.Modal.getInstance(editModal);
                if (modalInstance) modalInstance.hide();

                // You might want to display a user-friendly error message here
                // e.g., by setting a flash message or using a custom toast/modal
            });
    });

    // Reset file input saat modal ditutup
    editModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('edit_foto').value = '';
    });
});
</script>