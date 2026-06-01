<?php
// views/layout/footer.php
?>
</main>

<footer class="app-footer">
    <div class="container">
        <div class="app-footer-inner">
            <div class="app-footer-brand">
                <span class="app-brand-icon">◆</span>
                Inventaris Sepatu
            </div>
            <div class="app-footer-links">
                <a href="index.php?action=dashboard">Dashboard</a>
                <a href="index.php?action=home">Data Barang</a>
                <a href="index.php?action=tambah">Tambah Barang</a>
            </div>
            <div class="app-footer-copy">
                &copy; <?= date('Y') ?> Inventaris Sepatu. Semua hak dilindungi.
            </div>
        </div>
    </div>
</footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
