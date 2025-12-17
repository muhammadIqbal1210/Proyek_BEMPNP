<div class="container-fluid">
    <!-- Area Pesan Flashdata -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Gagal Menyimpan!</h4>
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php endif; ?>
    <!-- Akhir Area Pesan Flashdata -->
    <!-- Breadcrumb -->
    <ol class="breadcrumb" style="background: none; padding: 0;">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Katalog</li>
    </ol>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <!-- Tombol Tambah Data -->
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                data-bs-target="#createKatalogModal">
                <i class="fas fa-plus me-1"></i> Tambah Katalog
            </button>
            <hr>

            <!-- Form Pencarian dan Filter -->
            <form method="GET" action="<?= base_url('admin/katalog') ?>">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="Cari Katalog..."
                                aria-label="Search"
                                value="<?= esc(isset($filters['keyword']) ? $filters['keyword'] : '') ?>">
                            <button class="btn btn-outline-secondary" type="submit"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-5 text-end">
                        <a href="<?= base_url('admin/katalog') ?>" class="btn btn-sm btn-secondary"><i
                                class="fas fa-redo me-1"></i> Reset Filter</a>
                    </div>
                </div>
            </form>
            <!-- Akhir Form Pencarian -->
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Katalog</th>
                            <th>Deskripsi Singkat</th>
                            <th>Harga</th>
                            <th>Link Penjualan</th>
                            <th>Foto Utama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($katalog_list)): ?>
                        <?php 
                        // Hitung nomor awal untuk pagination (asumsi variabel $pager tersedia)
                        $perPage = @$pager->getPerPage() ?: 10;
                        $currentPage = @$pager->getCurrentPage() ?: 1;
                        $no = 1 + (($currentPage - 1) * $perPage); 
                        ?>
                        <?php foreach ($katalog_list as $katalog): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($katalog['nama_barang']) ?></td>
                            <!-- Menampilkan deskripsi singkat (dibatasi 50 karakter) -->
                            <td>
                                <?= substr(esc($katalog['deskripsi']), 0, 50) . (strlen($katalog['deskripsi']) > 50 ? '...' : '') ?>
                            </td>
                            <!-- Kolom Harga/Detail Katalog -->
                            <td>
                                <!-- Asumsi field 'harga' ada dan berupa angka -->
                                <?= 'Rp ' . number_format($katalog['harga'] ?? 0, 0, ',', '.') ?>
                            </td>
                            <!-- Link Jual -->
                            <td>
                                    <?php if (!empty($katalog['link_jual'])): ?>
                                        <a href="<?= esc($katalog['link_jual']) ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Buka Link Penjual">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                            <!-- Kolom Foto Utama -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php if (!empty($katalog['foto_produk'])): ?>
                                    <!-- Variabel $produk_base_url harus didefinisikan di Controller -->
                                    <img src="<?= esc($produk_base_url . $katalog['foto_produk']) ?>" 
                                            alt="Foto Utama" 
                                            class="w-16 h-16 object-cover rounded-md border border-gray-200"
                                            style="width: 64px; height: 64px;">
                                <?php else: ?>
                                    <span class="text-red-500">No Foto</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Aksi: Edit (Menggunakan modal edit) -->
                                <button class="btn btn-sm btn-outline-warning btn-edit" title="Edit Katalog"
                                    data-id="<?= $katalog['id'] ?>" data-bs-toggle="modal"
                                    data-bs-target="#editKatalogModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <!-- Aksi: Hapus -->
                                <a href="<?= base_url('admin/katalog/delete/' . $katalog['id']) ?>"
                                    onclick="return confirm('Anda yakin ingin menghapus katalog ini? Tindakan ini tidak dapat dibatalkan.');"
                                    class="btn btn-sm btn-outline-danger" title="Hapus Katalog">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <!-- Kolom colspan diubah menjadi 6 sesuai jumlah kolom header -->
                            <td colspan="6" class="text-center text-muted">Belum ada data katalog yang tersedia.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <!-- Paging dan informasi jumlah data -->
            <span class="text-muted small">
                <?php if (!empty($katalog_list)): ?>
                Menampilkan <?= count($katalog_list) ?> Katalog
                <?php else: ?>
                Data kosong
                <?php endif; ?>
            </span>
            <nav aria-label="Page navigation">
                <!-- Placeholder untuk pagination - Ganti dengan fungsi framework Anda jika tersedia -->
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Memanggil View Modal Create (Wajib ada) -->
    <?php echo view('admin/katalog/create'); ?>

    <!-- Memanggil View Modal Edit -->
    <?= $this->include('admin/katalog/edit') ?>

    <!-- Asumsi Anda mungkin memerlukan modal detail atau view lain -->
    <?= $this->include('admin/katalog/detail') ?>


</div>