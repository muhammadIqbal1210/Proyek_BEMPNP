<!-- FILE: app/Views/admin/user/index.php -->
<div class="container-fluid">
    <!-- Area untuk Flashdata/Pesan Sukses/Gagal -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <!-- Tambahkan logika error lainnya di sini jika diperlukan -->

    <ol class="breadcrumb" style="background: none; padding: 0;">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
    </ol>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <!-- Tombol Tambah Pengguna Baru (Asumsi Modal ID: createPenggunaModal) -->
            <button type="button" class="btn btn-sm btn-success" 
                    data-bs-toggle="modal" data-bs-target="#createPenggunaModal">
                <i class="fas fa-user-plus me-1"></i> Tambah Pengguna Baru
            </button>
            <hr>
            
            <!-- FORM PENCARIAN DAN FILTER -->
            <form method="GET" action="<?= base_url('admin/user') ?>">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <!-- Input Pencarian berdasarkan Username/Email -->
                            <input type="text" class="form-control" name="keyword" 
                                placeholder="Cari Username/Email..." aria-label="Search"
                                value="<?= esc(isset($filters['keyword']) ? $filters['keyword'] : '') ?>">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <!-- Filter berdasarkan Role -->
                        <select class="form-select" name="role" onchange="this.form.submit()">
                            <option value="" <?= (!isset($filters['role']) || $filters['role'] == '') ? 'selected' : '' ?>>Filter Role</option>
                            <option value="admin" <?= (isset($filters['role']) && $filters['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                            <option value="member" <?= (isset($filters['role']) && $filters['role'] == 'member') ? 'selected' : '' ?>>Member</option>
                        </select>
                    </div>
                    <div class="col-md-5 text-end">
                        <!-- Tombol Reset Filter -->
                        <a href="<?= base_url('admin/user') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-redo me-1"></i> Reset Filter</a>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($user_list)): ?>
                            <?php $no = 1 + ((($pager->getCurrentPage('user') ?? 1) - 1) * ($pager->getPerPage('user') ?: 10)); ?>
                            <?php foreach ($user_list as $user): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($user['username']) ?></td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td>
                                        <?php
                                            $roleClass = $user['role'] == 'admin' ? 'primary' : 'secondary';
                                        ?>
                                        <span class="badge bg-<?= $roleClass ?>">
                                            <?= ucfirst($user['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($user['is_active']) && $user['is_active'] == 1): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <!-- Mengambil data user yang sedang login -->
                                        <?php $currentUserId = session()->get('user_id'); ?>
                                        <?php $currentUserRole = session()->get('role'); // Ambil role user yang login (Pastikan session 'role' tersedia) ?>
                                        
                                        <!-- Kondisi pembanding -->
                                        <?php $isSelfUser = ($currentUserId == $user['id']); ?>
                                        <?php $targetIsSuperAdmin = ($user['role'] === 'superadmin'); ?>

                                        <!-- 1. TOMBOL EDIT -->
                                        <?php 
                                            $allowEdit = false;
                                            if ($currentUserRole === 'superadmin') {
                                                // Superadmin bisa edit siapa saja (termasuk dirinya sendiri)
                                                $allowEdit = true; 
                                            } elseif ($currentUserRole === 'admin') {
                                                // Admin biasa bisa edit pengguna lain KECUALI superadmin
                                                if (!$targetIsSuperAdmin) {
                                                    $allowEdit = true;
                                                }
                                            }
                                        ?>

                                        <?php if ($allowEdit): ?>
                                            <button class="btn btn-sm btn-outline-warning btn-edit-user me-1" 
                                                title="Edit Akun" 
                                                data-id="<?= $user['id'] ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editPenggunaModal">
                                                <i class="fas fa-user-edit"></i>
                                            </button>
                                        <?php endif; ?>

                                        <!-- 2. TOMBOL HAPUS -->
                                        <?php 
                                            $allowDelete = false;
                                            // Tidak ada yang bisa menghapus dirinya sendiri
                                            if (!$isSelfUser) {
                                                if ($currentUserRole === 'superadmin') {
                                                    // Superadmin bisa menghapus semua orang KECUALI dirinya sendiri
                                                    $allowDelete = true;
                                                } elseif ($currentUserRole === 'admin' && !$targetIsSuperAdmin) {
                                                    // Admin biasa bisa menghapus pengguna lain KECUALI superadmin
                                                    $allowDelete = true;
                                                }
                                            }
                                        ?>

                                        <?php if ($allowDelete): ?>
                                            <a href="<?= base_url('admin/user/delete/' . $user['id']) ?>" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?');" 
                                                class="btn btn-sm btn-outline-danger" title="Hapus Akun">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>

                                        <!-- 3. TAMPILAN JIKA TIDAK BISA MELAKUKAN AKSI APA PUN -->
                                        <?php if (!$allowEdit && !$allowDelete): ?>
                                            <span class="badge bg-secondary">Tidak ada aksi</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data pengguna yang ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <span class="text-muted small">Menampilkan <?= count($user_list) ?> Pengguna</span>
            <?= isset($pager) ? $pager->links('user', 'bootstrap_pagination') : '' ?>
        </div>
    </div>
    
    <!-- Area untuk Modal Create dan Edit (Anda perlu membuat file modalnya) -->
    <?php echo view('admin/user/create'); ?>
    <?php echo view('admin/user/edit'); ?> 

</div>
