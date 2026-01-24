<!-- File: app/Views/admin/profil/edit.php -->

<div class="modal fade" id="editProfilModal" tabindex="-1" aria-labelledby="editProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editProfilModalLabel">
                    <i class="fas fa-edit me-2"></i> Edit Profil Organisasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="formEditProfil" action="" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <!-- Loading Spinner -->
                    <div id="loadingEdit" class="text-center py-5" style="display:none;">
                        <div class="spinner-border text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Mengambil data...</p>
                    </div>

                    <div id="formContentEdit">
                        <input type="hidden" name="id" id="edit_profil_id">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama_kabinet" class="form-label fw-bold">Nama Kabinet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_kabinet" name="nama_kabinet" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_periode" class="form-label fw-bold">Periode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_periode" name="periode" placeholder="Contoh: 2023/2024" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_visi" class="form-label fw-bold">Visi Organisasi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_visi" name="visi" rows="2" required></textarea>
                        </div>

                        <!-- Bagian Misi Dinamis -->
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold">Misi Organisasi</label>
                                <button type="button" id="btn-add-misi-edit" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus-circle me-1"></i> Tambah Baris
                                </button>
                            </div>
                            <div id="misi-list-container-edit">
                                <!-- Baris misi akan diisi secara dinamis oleh JS -->
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_s_pres" class="form-label fw-bold">Nama Presiden Mahasiswa</label>
                                <input type="text" class="form-control" id="edit_s_pres" name="s_pres">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_s_wapres" class="form-label fw-bold">Nama Wakil Presiden Mahasiswa</label>
                                <input type="text" class="form-control" id="edit_s_wapres" name="s_wapres">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_videoprofil" class="form-label fw-bold">Link Video Profil (YouTube)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
                                <input type="url" class="form-control" id="edit_videoprofil" name="videoprofil" 
                                    placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4 fw-bold">
                        <i class="fas fa-save me-1"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editProfilModal');
    const formEdit = document.getElementById('formEditProfil');
    const containerMisi = document.getElementById('misi-list-container-edit');
    const btnAddMisi = document.getElementById('btn-add-misi-edit');
    const baseUrl = '<?= base_url('admin/profil') ?>';

    // Fungsi untuk membuat baris input misi baru
    function createMisiRow(value = '') {
        const rowCount = containerMisi.querySelectorAll('.misi-item').length + 1;
        const div = document.createElement('div');
        div.className = 'input-group mb-2 misi-item';
        div.innerHTML = `
            <span class="input-group-text bg-light text-muted small-num">${rowCount}</span>
            <input type="text" name="misi[]" class="form-control" placeholder="Tuliskan butir misi..." value="${value}" required>
            <button type="button" class="btn btn-outline-danger btn-remove-misi-edit">
                <i class="fas fa-trash"></i>
            </button>
        `;
        containerMisi.appendChild(div);
        updateMisiNumbers();
    }

    // Fungsi update nomor urut misi
    function updateMisiNumbers() {
        containerMisi.querySelectorAll('.misi-item').forEach((item, index) => {
            item.querySelector('.small-num').textContent = index + 1;
        });
    }

    // Event Tambah Baris
    btnAddMisi.addEventListener('click', () => createMisiRow());

    // Event Hapus Baris (Delegation)
    containerMisi.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-misi-edit')) {
            const items = containerMisi.querySelectorAll('.misi-item');
            if (items.length > 1) {
                e.target.closest('.misi-item').remove();
                updateMisiNumbers();
            } else {
                alert('Minimal harus ada satu misi.');
            }
        }
    });

    if (!editModal) return;

    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        
        formEdit.reset();
        containerMisi.innerHTML = ''; // Kosongkan list misi lama
        document.getElementById('formContentEdit').style.display = 'none';
        document.getElementById('loadingEdit').style.display = 'block';

        formEdit.setAttribute('action', `${baseUrl}/update/${id}`);

        fetch(`${baseUrl}/edit/${id}`, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingEdit').style.display = 'none';
            document.getElementById('formContentEdit').style.display = 'block';

            document.getElementById('edit_profil_id').value = data.id || '';
            document.getElementById('edit_nama_kabinet').value = data.nama_kabinet || '';
            document.getElementById('edit_periode').value = data.periode || '';
            document.getElementById('edit_visi').value = data.visi || '';
            document.getElementById('edit_s_pres').value = data.s_pres || '';
            document.getElementById('edit_s_wapres').value = data.s_wapres || '';
            document.getElementById('edit_videoprofil').value = data.videoprofil || '';

            // Handle Misi Dinamis dari JSON
            if (data.misi) {
                try {
                    const misiArray = (typeof data.misi === 'string') ? JSON.parse(data.misi) : data.misi;
                    if (Array.isArray(misiArray) && misiArray.length > 0) {
                        misiArray.forEach(m => createMisiRow(m));
                    } else {
                        createMisiRow(); // Default jika kosong
                    }
                } catch (e) {
                    createMisiRow(data.misi); // Jika bukan JSON (string biasa)
                }
            } else {
                createMisiRow(); // Default jika data null
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data.');
            bootstrap.Modal.getInstance(editModal).hide();
        });
    });
});
</script>