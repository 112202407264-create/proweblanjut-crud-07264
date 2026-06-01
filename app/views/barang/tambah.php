<div class="app-shell">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Sepatu</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $err): ?>
                                    <li><?= htmlspecialchars($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="index.php?action=tambah" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="kode_barang" class="form-label">Kode Sepatu</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang"
                                   required value="<?= htmlspecialchars($_POST['kode_barang'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Sepatu</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                   required value="<?= htmlspecialchars($_POST['nama_barang'] ?? '') ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jumlah" class="form-label">Jumlah/Stok</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" min="0"
                                       required value="<?= htmlspecialchars($_POST['jumlah'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" id="harga" name="harga" min="0"
                                       required value="<?= htmlspecialchars($_POST['harga'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan"
                                   value="<?= htmlspecialchars($_POST['satuan'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi"
                                   value="<?= htmlspecialchars($_POST['lokasi'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Barang (Opsional)</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">Batas upload gambar maksimal 2MB. Ekstensi .jpg, .png, .gif, .webp diperbolehkan.</div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk"
                                   value="<?= htmlspecialchars($_POST['tanggal_masuk'] ?? '') ?>">
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php?action=home" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
