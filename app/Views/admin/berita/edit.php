<!-- MODAL EDIT BERITA -->
<div class="modal fade" id="editBeritaModal" tabindex="-1" aria-labelledby="editBeritaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editBeritaModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Berita
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form Action akan diisi oleh JavaScript -->
            <form id="formEditBerita" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" id="edit_id" name="id">
                <input type="hidden" id="edit_gambarLama" name="gambarLama">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Berita</label>
                                <input type="text" class="form-control" id="edit_judulberita" name="judulberita" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Isi Berita</label>
                                <!-- Gunakan ID yang unik untuk CKEditor Edit -->
                                <textarea name="isiberita" id="editor_edit_berita"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light border-0 p-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tanggal Berita</label>
                                    <input type="date" class="form-control" id="edit_tanggalberita" name="tanggalberita" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gambar Berita</label>
                                    <div id="preview_gambar_lama" class="mb-2 text-center">
                                        <!-- Preview gambar muncul di sini via JS -->
                                    </div>
                                    <input type="file" class="form-control" name="gambarberita" onchange="previewNewImage(this)">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
<script>
    let editorInstanceEdit;

    // Inisialisasi CKEditor saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        if (document.querySelector('#editor_edit_berita')) {
            ClassicEditor.create(document.querySelector('#editor_edit_berita'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'undo', 'redo']
            })
            .then(editor => {
                editorInstanceEdit = editor;
            })
            .catch(error => console.error(error));
        }

        const editModal = document.getElementById('editBeritaModal');
        const editForm = document.getElementById('formEditBerita');
        const baseUrl = '<?= base_url('admin/berita') ?>';
        const pathGambar = '<?= base_url('uploads/berita') ?>/';

        if (editForm) {
            editForm.addEventListener('submit', function () {
                if (editorInstanceEdit) {
                    editorInstanceEdit.updateSourceElement();
                }
            });
        }

        // Memicu pengisian data saat modal akan ditampilkan
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Tombol yang memicu modal
            const id = button.getAttribute('data-id');

            if (!id) return;

            // 1. Atur Action Form
            editForm.action = `${baseUrl}/update/${id}`;

            // 2. Ambil Data via AJAX
            fetch(`${baseUrl}/edit/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // 3. Isi Field Input
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_judulberita').value = data.judulberita;
                    document.getElementById('edit_tanggalberita').value = data.tanggalberita;
                    document.getElementById('edit_gambarLama').value = data.gambarberita;

                    // 4. Isi CKEditor
                    if (editorInstanceEdit) {
                        editorInstanceEdit.setData(data.isiberita || '');
                    }

                    // 5. Tampilkan Preview Gambar
                    const previewDiv = document.getElementById('preview_gambar_lama');
                    if (data.gambarberita) {
                        previewDiv.innerHTML = `<img src="${pathGambar}${data.gambarberita}" class="img-fluid rounded border" style="max-height: 150px;">`;
                    } else {
                        previewDiv.innerHTML = `<span class="badge bg-secondary">Tidak ada gambar</span>`;
                    }
                })
                .catch(err => {
                    console.error("Fetch error:", err);
                });
        });
    });

    // Preview jika user memilih file baru di komputer
    function previewNewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview_gambar_lama').innerHTML = 
                `<img src="${e.target.result}" class="img-fluid rounded border" style="max-height: 150px;"> <br> <small class="text-info fw-bold">Preview gambar baru</small>`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>