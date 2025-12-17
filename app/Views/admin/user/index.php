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
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($user_list)): ?>
                            <?php $no = 1; ?>
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
                                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <!-- Tombol Aksi (Lihat Detail, Edit, Hapus) -->
                                        <button class="btn btn-sm btn-outline-warning btn-edit-user me-1" 
                                            title="Edit Akun" 
                                            data-id="<?= $user['id'] ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editPenggunaModal">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <a href="<?= base_url('admin/user/delete/' . $user['id']) ?>" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?');" 
                                            class="btn btn-sm btn-outline-danger" title="Hapus Akun">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
            <!-- Placeholder untuk Pagination jika diperlukan -->
             <nav aria-label="Page navigation">
                <!-- Placeholder untuk pagination -->
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
    
    <!-- Area untuk Modal Create dan Edit (Anda perlu membuat file modalnya) -->
    <?php echo view('admin/user/create'); ?>
    <?php echo view('admin/user/edit'); ?> 

</div>