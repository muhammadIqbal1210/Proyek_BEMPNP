<!-- ======================================================= -->
<!-- MODAL LIHAT DETAIL PENGUMUMAN -->
<!-- ======================================================= -->
<div class="modal fade" id="viewPengumumanModal" tabindex="-1" aria-labelledby="viewPengumumanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPengumumanModalLabel">Detail Pengumuman: <span id="detail_title_header"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Tanggal Publikasi</label>
                        <p class="form-control-static fw-bold" id="detail_tanggal_publikasi">-</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Status</label>
                        <p class="form-control-static fw-bold" id="detail_status">-</p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Judul Pengumuman</label>
                    <h4 id="detail_title" class="mb-3"></h4>
                </div>
                
                <!-- Konten Utama (Deskripsi) -->
                <div class="mb-4 p-3 bg-light rounded shadow-sm">
                    <label class="form-label text-muted mb-2">Isi Pengumuman (Deskripsi)</label>
                    <!-- Asumsi field deskripsi bernama 'description' di database -->
                    <div id="detail_description" style="white-space: pre-wrap; word-wrap: break-word;">
                        Loading description...
                    </div>
                </div>

                <!-- Informasi File Pendukung -->
                <div class="mb-3">
                    <label class="form-label text-muted">File Pendukung</label>
                    <p class="form-control-static" id="detail_file_info">
                        Tidak ada file terlampir.
                    </p>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================= -->
<!-- SCRIPT UNTUK AJAX AMBIL DATA DAN ISI MODAL DETAIL -->
<!-- ======================================================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewModal = document.getElementById('viewPengumumanModal');
        const baseUrl = '<?= base_url('admin/pengumuman') ?>';

        if (!viewModal) {
            console.error("Error: Element modal dengan ID 'viewPengumumanModal' tidak ditemukan.");
            return;
        }

        viewModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const pengumumanId = button.getAttribute('data-id');
            
            if (!pengumumanId) {
                console.error("Error: Tombol detail tidak memiliki atribut data-id.");
                alert('Gagal memuat data: ID pengumuman tidak ditemukan pada tombol.');
                const modalInstance = bootstrap.Modal.getInstance(viewModal);
                if(modalInstance) modalInstance.hide();
                return;
            }

            // Lakukan AJAX call (menggunakan endpoint edit yang mengembalikan JSON)
            fetch(`${baseUrl}/edit/${pengumumanId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data pengumuman. Respons status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    // Isi Header Title
                    document.getElementById('detail_title_header').textContent = data.title;
                    
                    // Isi Field Utama
                    document.getElementById('detail_title').textContent = data.title;
                    // Ubah format tanggal (jika diperlukan)
                    const date = new Date(data.tanggal_publikasi);
                    document.getElementById('detail_tanggal_publikasi').textContent = date.toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'});

                    // Status
                    const statusText = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                    const statusClass = data.status === 'aktif' ? 'success' : (data.status === 'draf' ? 'warning' : 'danger');
                    document.getElementById('detail_status').innerHTML = `<span class="badge bg-${statusClass}">${statusText}</span>`;

                    // Konten Deskripsi
                    // PENTING: Asumsi field deskripsi bernama 'description'
                    document.getElementById('detail_description').innerHTML = data.description || "Tidak ada deskripsi/isi konten.";

                    // Informasi File Pendukung
                    const fileInfo = document.getElementById('detail_file_info');
                    if (data.file_path) {
                        // Menggunakan rute download yang sudah diatur
                        // Nama file yang ditampilkan hanya menggunakan file_path (nama unik di server)
                        fileInfo.innerHTML = `File terlampir: <a href="${baseUrl}/download/${data.id}" target="_blank" class="btn btn-sm btn-link p-0 text-decoration-none"> ${data.file_path} <i class="fas fa-external-link-alt ms-1"></i></a>`;
                    } else {
                        fileInfo.textContent = "Tidak ada file terlampir.";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat detail data: ' + error.message);
                    const modalInstance = bootstrap.Modal.getInstance(viewModal);
                    if(modalInstance) modalInstance.hide();
                });
        });
    });
</script>