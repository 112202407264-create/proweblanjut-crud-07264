pwl-inventaris-crud
====================

Aplikasi web sederhana untuk manajemen inventaris barang menggunakan **PHP Native** dan **MySQL (PDO)**.

## Struktur File

- `koneksi.php` – konfigurasi dan koneksi ke database dengan PDO
- `index.php` – halaman utama, menampilkan daftar barang (Read)
- `tambah.php` – form tambah barang baru (Create)
- `edit.php` – form edit barang (Update)
- `hapus.php` – aksi hapus barang (Delete)

## Cara Menyiapkan Database

1. Jalankan Apache dan MySQL di XAMPP.
2. Buka phpMyAdmin (`http://localhost/phpmyadmin`).
3. Buat database baru dengan nama `pwl_inventaris`.
4. Jalankan SQL berikut di tab **SQL**:

```sql
CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(20) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    jumlah INT NOT NULL,
    satuan VARCHAR(20),
    lokasi VARCHAR(100),
    tanggal_masuk DATE
);
```

Jika Anda ingin menggunakan nama database, username, atau password lain, sesuaikan di file `koneksi.php`.

## Cara Menjalankan Aplikasi

1. Pastikan folder ini berada di `C:\xampp\htdocs\pwl-inventaris-crud-1`.
2. Jalankan Apache dan MySQL di XAMPP.
3. Buka browser dan akses:

   `http://localhost/pwl-inventaris-crud-1/index.php`

4. Gunakan tombol **Tambah Barang** untuk menambah data baru, tombol **Edit** untuk mengubah data, dan tombol **Hapus** untuk menghapus data.
