<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengajuan Katalog Baru</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('member/katalog/store') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang *</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= set_value('nama_barang') ?>" required>
                                    <?php if (isset($errors['nama_barang'])): ?>
                                        <small class="text-danger"><?= $errors['nama_barang'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="harga">Harga *</label>
                                    <input type="number" class="form-control" id="harga" name="harga" value="<?= set_value('harga') ?>" step="0.01" required>
                                    <?php if (isset($errors['harga'])): ?>
                                        <small class="text-danger"><?= $errors['harga'] ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi *</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= set_value('deskripsi') ?></textarea>
                            <?php if (isset($errors['deskripsi'])): ?>
                                <small class="text-danger"><?= $errors['deskripsi'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="link_jual">Link Penjualan *</label>
                            <input type="url" class="form-control" id="link_jual" name="link_jual" value="<?= set_value('link_jual') ?>" required>
                            <?php if (isset($errors['link_jual'])): ?>
                                <small class="text-danger"><?= $errors['link_jual'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="foto_produk_file">Foto Produk *</label>
                            <input type="file" class="form-control" id="foto_produk_file" name="foto_produk_file" accept="image/*" required>
                            <small class="form-text text-muted">Format: JPG, PNG, Max: 2MB</small>
                            <?php if (isset($errors['foto_produk_file'])): ?>
                                <small class="text-danger"><?= $errors['foto_produk_file'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Ajukan Katalog</button>
                            <a href="<?= base_url('member/katalog') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
