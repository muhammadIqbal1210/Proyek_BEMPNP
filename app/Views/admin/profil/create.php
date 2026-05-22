<!-- Modal Create Profil -->
<div class="modal fade" id="createProfilModal" tabindex="-1" aria-labelledby="createProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createProfilModalLabel">
                    <i class="fas fa-university me-2"></i>Form Profil Organisasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('admin/profil/store') ?>" method="post">
                <?= csrf_field(); ?>                
                <div class="modal-body">
                    <div class="row">
                        <!-- Nama Kabinet & Periode -->
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Nama Kabinet</label>
                            <input type="text" name="nama_kabinet" class="form-control" placeholder="Contoh: Kabinet Harmoni Karya" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Periode</label>
                            <input type="text" name="periode" class="form-control" placeholder="2023/2024" required>
                        </div>

                        <!-- Video Profil -->
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Link Video Profil (URL)</label>
                            <input type="url" name="videoprofil" class="form-control" placeholder="https://youtube.com/watch?v=...">
                        </div>

                        <!-- Visi -->
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Visi</label>
                            <textarea name="visi" class="form-control" rows="3" placeholder="Tuliskan visi organisasi..." required></textarea>
                        </div>

                        <!-- Misi Dinamis (Sesuai Format Lomba) -->
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold">Misi Organisasi</label>
                                <button type="button" id="btn-add-misi" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus-circle me-1"></i> Tambah Baris
                                </button>
                            </div>
                            <div id="misi-list-container">
                                <div class="input-group mb-2 misi-item">
                                    <span class="input-group-text bg-light text-muted small-num">1</span>
                                    <input type="text" name="misi[]" class="form-control" placeholder="Tuliskan butir misi..." required>
                                    <button type="button" class="btn btn-outline-danger btn-remove-misi">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Sambutan Pres & Wapres -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Sambutan Presiden (S_PRES)</label>
                            <textarea name="s_pres" class="form-control" rows="4" placeholder="Teks sambutan presiden..."></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Sambutan Wapres (S_WAPRES)</label>
                            <textarea name="s_wapres" class="form-control" rows="4" placeholder="Teks sambutan wakil presiden..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('misi-list-container');
    const btnAdd = document.getElementById('btn-add-misi');

    function renumberMisi() {
        const items = container.querySelectorAll('.misi-item');
        items.forEach((item, index) => {
            item.querySelector('.small-num').innerText = index + 1;
        });
    }

    btnAdd.addEventListener('click', function() {
        const newItem = document.createElement('div');
        newItem.className = 'input-group mb-2 misi-item';
        newItem.innerHTML = `
            <span class="input-group-text bg-light text-muted small-num"></span>
            <input type="text" name="misi[]" class="form-control" placeholder="Tuliskan butir misi..." required>
            <button type="button" class="btn btn-outline-danger btn-remove-misi">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(newItem);
        renumberMisi();
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-misi')) {
            const items = container.querySelectorAll('.misi-item');
            if (items.length > 1) {
                e.target.closest('.misi-item').remove();
                renumberMisi();
            } else {
                items[0].querySelector('input').value = '';
            }
        }
    });
});
</script>