<!-- Modal Tambah Berita -->
<div class="modal fade" id="createBeritaModal" tabindex="-1" aria-labelledby="createBeritaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createBeritaModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Berita Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/berita/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="judulberita" class="form-label fw-bold">Judul Berita</label>
                                <input type="text" class="form-control" id="judulberita" name="judulberita" placeholder="Masukkan judul..." required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Isi Berita</label>
                                <div id="editor_container">
                                    <!-- Field yang akan dikirim ke Database -->
                                    <textarea name="isiberita" id="editor_berita"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light border-0 p-3">
                                <div class="mb-3">
                                    <label for="tanggalberita" class="form-label fw-bold">Tanggal Berita</label>
                                    <input type="date" class="form-control" id="tanggalberita" name="tanggalberita" value="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="gambarberita" class="form-label fw-bold">Gambar Utama (Thumbnail)</label>
                                    <input type="file" class="form-control" id="gambarberita" name="gambarberita" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Menggunakan Build yang mendukung Base64 Upload -->
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

<style>
    .ck-editor__editable_inline {
        min-height: 400px;
        background-color: white;
    }
    /* Memastikan toolbar editor tidak tertutup modal */
    .ck-rounded-corners .ck.ck-balloon-panel, .ck.ck-balloon-panel {
        z-index: 1060 !important;
    }
</style>

<script>
    // Plugin sederhana untuk mengubah upload file menjadi Base64
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }
        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => {
                        resolve({ default: reader.result });
                    };
                    reader.onerror = error => reject(error);
                    reader.readAsDataURL(file);
                }));
        }
        abort() {}
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    // Inisialisasi Editor
    ClassicEditor
        .create(document.querySelector('#editor_berita'), {
            extraPlugins: [MyCustomUploadAdapterPlugin], // Masukkan plugin upload di sini
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'uploadImage', 'insertTable', 'blockQuote', 'undo', 'redo'
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>