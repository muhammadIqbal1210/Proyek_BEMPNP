<!-- ======================================================= -->
<!-- MODAL EDIT KATALOG -->
<!-- ======================================================= -->
<div class="modal fade" id="editKatalogModal" tabindex="-1" aria-labelledby="editKatalogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editKatalogModalLabel"><i class="fa-solid fa-pen-to-square"></i> Edit Item Katalog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form Action akan diisi oleh JavaScript -->
            <?= form_open_multipart('', ['id' => 'editForm', 'method' => 'POST']) ?>
                <div class="modal-body">
                    <!-- ID tersembunyi untuk proses update -->
                    <input type="hidden" name="id" id="edit_id">

                    <!-- Nama Katalog / Produk -->
                    <div class="mb-3">
                        <label for="edit_nama_barang" class="form-label">Nama Item Katalog <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_barang" name="nama_barang" required>
                    </div>
                    
                    <!-- Deskripsi Katalog -->
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi Lengkap</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="5"></textarea>
                    </div>

                    <div class="row">
                        <!-- Kolom Harga -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_harga" class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="edit_harga" name="harga" min="0" required>
                            </div>
                        </div>

                        <!-- Link Jual -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_link_jual" class="form-label">Nomor Penjual (WhatsApp)</label>
                            <input type="text" class="form-control" id="edit_link_jual" name="link_jual">
                        </div>
                    </div>

                    <!-- Foto Produk -->
                    <div class="mb-3">
                        <label for="edit_foto_produk" class="form-label">Ganti Foto Produk (Abaikan jika tidak ingin mengganti)</label>
                        <input type="file" class="form-control" id="edit_foto_produk" name="foto_produk" accept=".jpg, .jpeg, .png">
                    </div>
                    
                    <!-- Info Foto Saat Ini -->
                    <div class="mb-3 p-2 border rounded bg-light">
                        <small class="text-muted d-block mb-2">Foto saat ini:</small>
                        <div id="preview_foto_container" style="display:none;">
                            <img src="" id="img_preview" class="img-thumbnail mb-2" style="max-height: 150px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remove_foto" value="1" id="edit_removeFoto">
                                <label class="form-check-label text-danger" for="edit_removeFoto">Hapus foto ini</label>
                            </div>
                        </div>
                        <p class="text-muted small mb-0" id="no_foto_info" style="display:none;">Tidak ada foto terlampir.</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Update Katalog</button>
                </div>
            <?= form_close() ?>>
        </div>
    </div>
</div>

<!-- ======================================================= -->
<!-- SCRIPT AJAX UNTUK MENGISI DATA EDIT -->
<!-- ======================================================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const editKatalogModal = document.getElementById('editKatalogModal');
    const editKatalogForm = document.getElementById('editForm');
    const baseUrl = '<?= base_url('admin/katalog') ?>';

    // PERBAIKAN: Jangan return jika modal ada, tapi cek keberadaannya dengan benar
    if (!editKatalogModal) {
        console.error("Error: Element modal 'editKatalogModal' tidak ditemukan.");
        return;
    }

    editKatalogModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');

        if (!id) return;

        // 1. Atur action form menggunakan variabel yang benar (editKatalogForm)
        editKatalogForm.setAttribute('action', `${baseUrl}/update/${id}`);
        
        // 2. Ambil data via AJAX
        fetch(`${baseUrl}/edit/${id}`, {
            method: 'GET',
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal mengambil data dari server');
            return response.json();
        })
        .then(data => {
            // Debugging: Lihat di console browser (F12) apakah data muncul
            console.log("Data diterima:", data);

            // 3. Isi field input (Gunakan fallback || '' agar tidak muncul 'undefined' di form)
            // Pastikan 'id_katalog' atau 'id' sesuai dengan nama kolom di database Anda
            document.getElementById('edit_id').value = data.id ;
            document.getElementById('edit_nama_barang').value = data.nama_barang;
            document.getElementById('edit_deskripsi').value = data.deskripsi;
            document.getElementById('edit_harga').value = data.harga;
            document.getElementById('edit_link_jual').value = data.link_jual;

            // 4. Penanganan Foto
            const previewContainer = document.getElementById('preview_foto_container');
            const imgPreview = document.getElementById('img_preview');
            const noFotoInfo = document.getElementById('no_foto_info');
            
            if (data.foto_produk && data.foto_produk !== '') {
                imgPreview.src = `<?= base_url('uploads/katalog/') ?>/${data.foto_produk}`;
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
            console.error('Error:', error);
            // Optional: Beri notifikasi ke user jika gagal
        });
    });

    // Reset input file saat modal ditutup
    editKatalogModal.addEventListener('hidden.bs.modal', function () {
        document.getElementById('edit_foto_produk').value = '';
    });
});
</script>