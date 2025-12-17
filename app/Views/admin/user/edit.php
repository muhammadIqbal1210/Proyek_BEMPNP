<div class="modal fade" id="editPenggunaModal" tabindex="-1" aria-labelledby="editPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editPenggunaModalLabel"><i class="fas fa-user-edit me-2"></i>Edit Akun Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form ini akan diperbarui action-nya oleh JavaScript -->
            <form id="editUserForm" action="" method="POST">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <!-- Field tersembunyi untuk metode PUT/PATCH di CI4 jika diperlukan -->
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit-user-id">

                    <div class="mb-3">
                        <label for="edit-username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit-username" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="edit-email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-role" class="form-label">Role Akun <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit-role" name="role" required>
                            <option value="member">Member (Pengguna Biasa)</option>
                            <option value="admin">Admin (Akses Penuh)</option>
                        </select>
                    </div>

                    <hr>
                    <div class="mb-3">
                        <label for="edit-password" class="form-label">Ubah Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" class="form-control" id="edit-password" name="password">
                        <small class="form-text text-muted">Isi hanya jika Anda ingin mengganti password.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT JS UNTUK MENGISI DATA MODAL EDIT (Asumsi Anda menggunakan JQuery atau Vanilla JS) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editPenggunaModal');
    
    editModal.addEventListener('show.bs.modal', function (event) {
        // Tombol yang memicu modal
        const button = event.relatedTarget; 
        const userId = button.getAttribute('data-id');

        // Lakukan AJAX call untuk mengambil data pengguna
        fetch('<?= base_url('admin/user/edit/') ?>' + userId)
            .then(response => response.json())
            .then(data => {
                // Isi Form
                document.getElementById('edit-user-id').value = data.id;
                document.getElementById('edit-username').value = data.username;
                document.getElementById('edit-email').value = data.email;
                document.getElementById('edit-role').value = data.role;
                
                // Atur Action form
                const form = document.getElementById('editUserForm');
                form.action = '<?= base_url('admin/user/update/') ?>' + data.id;
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
                // Di dunia nyata, Anda harus menampilkan pesan error di UI
            });
    });
});
</script>