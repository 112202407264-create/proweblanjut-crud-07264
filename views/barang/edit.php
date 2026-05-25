<div class="app-shell">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-pen-to-square me-2"></i> Edit Data Sepatu</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $err): ?>
                                    <li><i class="fa-solid fa-triangle-exclamation me-1"></i> <?= htmlspecialchars($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="index.php?action=edit&kode=<?= urlencode($kode_barang) ?>" enctype="multipart/form-data">
                        
                        <input type="hidden" name="kode_barang" value="<?= htmlspecialchars($kode_barang) ?>">

                        <div class="mb-3">
                            <label for="kode_barang_tampil" class="form-label">Kode Sepatu</label>
                            <input type="text" class="form-control bg-light text-muted" id="kode_barang_tampil" 
                                   disabled value="<?= htmlspecialchars($data['kode_barang']) ?>">
                            <div class="form-text">Kode barang otomatis terkunci dan tidak dapat diubah.</div>
                        </div>
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Sepatu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                   required value="<?= htmlspecialchars($_POST['nama_barang'] ?? $data['nama_barang']) ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="jumlah" class="form-label">Jumlah/Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" min="0"
                                       required value="<?= htmlspecialchars($_POST['jumlah'] ?? $data['jumlah']) ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="harga" name="harga" min="0"
                                       required value="<?= htmlspecialchars($_POST['harga'] ?? ($data['harga'] ?? 0)) ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan"
                                       value="<?= htmlspecialchars($_POST['satuan'] ?? $data['satuan']) ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi Gudang</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi"
                                   value="<?= htmlspecialchars($_POST['lokasi'] ?? $data['lokasi']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Barang (Opsional)</label>
                            <?php if (!empty($data['gambar'])): ?>
                                <div class="mb-2">
                                    <img src="<?= htmlspecialchars($data['gambar']) ?>" alt="Gambar" width="150" class="img-thumbnail">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar. Batas upload maksimal 2MB.</div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk"
                                   required value="<?= htmlspecialchars($_POST['tanggal_masuk'] ?? $data['tanggal_masuk']) ?>">
                        </div>
                        
                        <hr class="mt-4 mb-3">
                        <div class="d-flex justify-content-between">
                            <a href="index.php?action=home" class="btn btn-secondary">
                                <i class="fa-solid fa-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
