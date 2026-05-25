<div class="app-shell">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0 page-title">Data Sepatu</h3>
            <div class="subtle small">Manajemen stok sepatu di gudang/toko.</div>
        </div>
        <a href="index.php?action=tambah" class="btn btn-success">+ Tambah Sepatu</a>
    </div>

    <?php if (!empty($msg)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Lokasi</th>
                        <th>Tanggal Masuk</th>
                        <th width="150">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($barang) === 0): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">Belum ada data sepatu.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($barang as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <?php if (!empty($row['gambar'])): ?>
                                        <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar" width="50" class="img-thumbnail border-0 shadow-sm">
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size:0.8rem;">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['kode_barang']) ?></td>
                                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                                <td>Rp<?= number_format((int)($row['harga'] ?? 0), 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($row['jumlah']) ?></td>
                                <td><?= htmlspecialchars($row['satuan']) ?></td>
                                <td><?= htmlspecialchars($row['lokasi']) ?></td>
                                <td><?= htmlspecialchars($row['tanggal_masuk'] ?: '-') ?></td>
                                <td>
                                    <a href="index.php?action=edit&kode=<?= urlencode($row['kode_barang']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="index.php?action=hapus&kode=<?= urlencode($row['kode_barang']) ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Yakin ingin menghapus data ini?');">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>
