<div class="modal fade" id="createPenggunaModal" tabindex="-1" aria-labelledby="createPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createPenggunaModalLabel"><i class="fas fa-user-plus me-2"></i>Tambah Akun Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/user/store') ?>" method="POST">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <small class="form-text text-muted">Minimal 8 karakter.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Role Akun <span class="text-danger">*</span></label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="member" selected>Member (Pengguna Biasa)</option>
                            <option value="admin">Admin (Akses Penuh)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>