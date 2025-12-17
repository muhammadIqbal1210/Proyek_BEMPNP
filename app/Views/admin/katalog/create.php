<?php
// Pastikan CodeIgniter Helper telah dimuat (misalnya form_helper, url_helper)
?>

<!-- Modal Tambah Item Katalog -->
<div class="modal fade" id="createKatalogModal" tabindex="-1" aria-labelledby="createKatalogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createKatalogModalLabel"><i class="fa-solid fa-box"></i> Tambah Item Katalog Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form untuk menyimpan data. Action mengarah ke Controller/store -->
            <!-- Catatan: Sesuaikan URL 'admin/katalog/store' dengan route yang benar di aplikasi Anda -->
            <form action="<?= base_url('admin/katalog/store') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <!-- Nama Katalog / Produk -->
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Item Katalog <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" 
                            value="<?= set_value('nama_barang') ?>" placeholder="Contoh : Buku Panduan Digital" required>
                    </div>
                    
                    <!-- Deskripsi Katalog -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Lengkap</label>
                        <!-- Disarankan menggunakan editor kaya (seperti TinyMCE/CKEditor) untuk deskripsi panjang -->
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" 
                            placeholder="Jelaskan detail dan spesifikasi item katalog ini."><?= set_value('deskripsi') ?></textarea>
                    </div>

                    <div class="row">

                        <!-- Kolom Harga -->
                        <div class="col-md-6 mb-3">
                            <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="harga" name="harga" min="0" 
                                    value="<?= set_value('harga') ?>" placeholder="Contoh: 150000" required>
                            </div>
                        </div>
                    </div>

                    <!-- Link Informasi/Detail (URL) -->
                    <div class="mb-3">
                        <label for="link_jual" class="form-label">Link Penjual (WhatsApp)</label>
                        <input type="url" class="form-control" id="link_jual" name="link_jual" 
                            value="<?= set_value('link_jual') ?>" placeholder="Contoh: https://link-ke-produk-detail.com">
                    </div>
                    <div class="mb-3">
                        <label for="foto_produk" class="form-label">Masukkan 1 Foto Produk</label>
                        <input type="file" class="form-control" id="foto_produk" name="foto_produk" accept=".jpg, .jpeg, .png">
                        <div class="form-text">File ini akan digunakan sebagai gambar promosi.</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Simpan Katalog</button>
                </div>
            </form>
        </div>
    </div>
</div>