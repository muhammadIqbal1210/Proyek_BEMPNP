<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengajuan Berita Baru</h3>
                </div>
                <div class="card-body">
                    <?php $errors = $errors ?? session()->getFlashdata('errors') ?? []; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
                    <?php endif; ?>
                    <form action="<?= base_url('member/berita/store') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judulberita">Judul Berita *</label>
                                    <input type="text" class="form-control" id="judulberita" name="judulberita" value="<?= set_value('judulberita') ?>" required>
                                    <?php if (isset($errors['judulberita'])): ?>
                                        <small class="text-danger"><?= $errors['judulberita'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggalberita">Tanggal Berita *</label>
                                    <input type="date" class="form-control" id="tanggalberita" name="tanggalberita" value="<?= set_value('tanggalberita', date('Y-m-d')) ?>" required>
                                    <?php if (isset($errors['tanggalberita'])): ?>
                                        <small class="text-danger"><?= $errors['tanggalberita'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="editor_berita_member">Isi Berita *</label>
                            <textarea class="form-control" id="editor_berita_member" name="isiberita" rows="10"><?= set_value('isiberita') ?></textarea>
                            <?php if (isset($errors['isiberita'])): ?>
                                <small class="text-danger"><?= $errors['isiberita'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="gambarberita_file">Gambar Berita *</label>
                            <input type="file" class="form-control" id="gambarberita_file" name="gambarberita_file" accept="image/*" required>
                            <small class="form-text text-muted">Format: JPG, PNG, Max: 2MB</small>
                            <?php if (isset($errors['gambarberita_file'])): ?>
                                <small class="text-danger"><?= $errors['gambarberita_file'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Ajukan Berita</button>
                            <a href="<?= base_url('member/berita') ?>" class="btn btn-secondary">Batal</a>
                            <span id="submittingText" style="display:none; margin-left: 10px;">
                                <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                                Mengirim...
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
<style>
    .ck-editor__editable_inline {
        min-height: 360px;
        background-color: #fff;
    }
</style>
<script>
    class MemberBeritaUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }
        upload() {
            return this.loader.file.then(file => new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve({ default: reader.result });
                reader.onerror = error => reject(error);
                reader.readAsDataURL(file);
            }));
        }
        abort() {}
    }

    function MemberBeritaUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = loader => new MemberBeritaUploadAdapter(loader);
    }

    let editorInstance;
    ClassicEditor
        .create(document.querySelector('#editor_berita_member'), {
            extraPlugins: [MemberBeritaUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'uploadImage', 'insertTable', 'blockQuote', 'undo', 'redo'
                ]
            }
        })
        .then(editor => {
            editorInstance = editor;

            // SINKRONISASI OTOMATIS TIAP KALI ADA PERUBAHAN TEKS
            editor.model.document.on('change:data', () => {
                document.querySelector('#editor_berita_member').value = editor.getData();
            });
        })
        .catch(error => console.error('CKEditor error:', error));

    // Script penanganan form submit lama bisa tetap dibiarkan atau dihapus safely
    document.querySelector('form').addEventListener('submit', function(e) {
        if (editorInstance) {
            document.querySelector('#editor_berita_member').value = editorInstance.getData();
        }
        
        // Memunculkan text loading "Mengirim..." yang sudah kamu buat
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submittingText').style.display = 'inline-block';
    });
</script>
