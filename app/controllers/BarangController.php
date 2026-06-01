<?php
class BarangController {
    private $barangModel;

    public function __construct($pdo) {
        $this->checkAuth();
        require_once 'app/models/Barang.php';
        $this->barangModel = new Barang($pdo);
    }

    private function checkAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    public function dashboard() {
        $pageTitle = 'Dashboard';
        require 'app/views/layout/header.php';
        require 'app/views/dashboard/index.php';
        require 'app/views/layout/footer.php';
    }

    public function index() {
        $msg = $_GET['msg'] ?? '';
        $error = '';
        
        try {
            $barang = $this->barangModel->getAll();
        } catch (PDOException $e) {
            $error = 'Gagal mengambil data: ' . $e->getMessage();
            $barang = [];
        }

        $pageTitle = 'Data Barang';
        require 'app/views/layout/header.php';
        require 'app/views/barang/index.php';
        require 'app/views/layout/footer.php';
    }

    public function tambah() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'kode_barang'   => $_POST['kode_barang'] ?? '',
                'nama_barang'   => trim($_POST['nama_barang'] ?? ''),
                'jumlah'        => $_POST['jumlah'] ?? '',
                'harga'         => $_POST['harga'] ?? '',
                'satuan'        => $_POST['satuan'] ?? '',
                'lokasi'        => $_POST['lokasi'] ?? '',
                'tanggal_masuk' => $_POST['tanggal_masuk'] ?? null,
                'gambar'        => null
            ];

            if ($data['kode_barang'] === '') $errors[] = 'Kode barang tidak boleh kosong.';
            if ($data['nama_barang'] === '') $errors[] = 'Nama barang tidak boleh kosong.';
            if ($data['jumlah'] === '' || !is_numeric($data['jumlah'])) $errors[] = 'Jumlah harus berupa angka.';
            if ($data['harga'] === '' || !is_numeric($data['harga'])) $errors[] = 'Harga harus berupa angka.';

            if (empty($errors)) {
                $data['jumlah'] = (int)$data['jumlah'];
                $data['harga'] = (int)$data['harga'];
                
                // Handle Upload
                if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/';
                    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                    
                    $file_tmp = $_FILES['gambar']['tmp_name'];
                    $file_name = $_FILES['gambar']['name'];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    
                    if (!in_array($file_ext, $allowed_exts)) {
                        $errors[] = 'Format gambar tidak valid.';
                    } elseif ($_FILES['gambar']['size'] > 2000000) {
                        $errors[] = 'Ukuran gambar maksimal 2MB.';
                    } else {
                        $new_file_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', $file_name);
                        $dest_path = $upload_dir . $new_file_name;
                        
                        if (move_uploaded_file($file_tmp, $dest_path)) {
                            $data['gambar'] = $dest_path;
                        } else {
                            $errors[] = 'Gagal memindahkan file gambar.';
                        }
                    }
                }

                if (empty($errors)) {
                    try {
                        $this->barangModel->insert($data);
                        header('Location: index.php?action=home&msg=' . urlencode('Data barang berhasil ditambahkan'));
                        exit;
                    } catch (PDOException $e) {
                        if ($e->getCode() == 23000) {
                            $errors[] = 'Kode barang sudah digunakan, silakan gunakan kode lain.';
                        } else {
                            $errors[] = 'Gagal menyimpan data ke database.';
                        }
                        if ($data['gambar'] && file_exists($data['gambar'])) {
                            unlink($data['gambar']);
                        }
                    }
                }
            }
        }

        $pageTitle = 'Tambah Sepatu';
        require 'app/views/layout/header.php';
        require 'app/views/barang/tambah.php';
        require 'app/views/layout/footer.php';
    }

    public function edit() {
        $kode_barang = $_GET['kode'] ?? ($_POST['kode_barang'] ?? '');
        if ($kode_barang === '') {
            header('Location: index.php?action=home');
            exit;
        }

        $data = $this->barangModel->getById($kode_barang);
        if (!$data) {
            header('Location: index.php?action=home&msg=' . urlencode('Data sepatu tidak ditemukan'));
            exit;
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateData = [
                'nama_barang'   => trim($_POST['nama_barang'] ?? ''),
                'jumlah'        => trim($_POST['jumlah'] ?? ''),
                'harga'         => trim($_POST['harga'] ?? ''),
                'satuan'        => trim($_POST['satuan'] ?? ''),
                'lokasi'        => trim($_POST['lokasi'] ?? ''),
                'tanggal_masuk' => trim($_POST['tanggal_masuk'] ?? ''),
                'gambar'        => $data['gambar']
            ];

            if ($updateData['nama_barang'] === '') $errors[] = 'Nama barang wajib diisi.';
            if ($updateData['jumlah'] === '' || !is_numeric($updateData['jumlah'])) $errors[] = 'Jumlah harus berupa angka.';
            if ($updateData['harga'] === '' || !is_numeric($updateData['harga'])) $errors[] = 'Harga harus berupa angka.';
            
            if ($updateData['tanggal_masuk'] === '') {
                $updateData['tanggal_masuk'] = $data['tanggal_masuk'];
            }

            if (empty($errors)) {
                if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/';
                    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                    
                    $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                    if (!in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        $errors[] = 'Format gambar tidak valid.';
                    } elseif ($_FILES['gambar']['size'] > 2000000) {
                        $errors[] = 'Ukuran gambar maksimal 2MB.';
                    } else {
                        $new_file_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', $_FILES['gambar']['name']);
                        $dest_path = $upload_dir . $new_file_name;
                        
                        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $dest_path)) {
                            if ($updateData['gambar'] && file_exists($updateData['gambar'])) {
                                unlink($updateData['gambar']);
                            }
                            $updateData['gambar'] = $dest_path;
                        } else {
                            $errors[] = 'Gagal mengunggah gambar baru.';
                        }
                    }
                }

                if (empty($errors)) {
                    try {
                        $updateData['jumlah'] = (int)$updateData['jumlah'];
                        $updateData['harga'] = (int)$updateData['harga'];
                        $this->barangModel->update($kode_barang, $updateData);
                        header('Location: index.php?action=home&msg=' . urlencode('Data sepatu berhasil diperbarui!'));
                        exit;
                    } catch (PDOException $e) {
                        $errors[] = 'Gagal menyimpan ke database.';
                    }
                }
            }
        }

        $pageTitle = 'Edit Sepatu';
        require 'app/views/layout/header.php';
        require 'app/views/barang/edit.php';
        require 'app/views/layout/footer.php';
    }

    public function hapus() {
        $kode_barang = $_GET['kode'] ?? '';
        if ($kode_barang !== '') {
            $data = $this->barangModel->getById($kode_barang);
            if ($data) {
                if (!empty($data['gambar']) && file_exists($data['gambar'])) {
                    unlink($data['gambar']);
                }
                $this->barangModel->delete($kode_barang);
                header('Location: index.php?action=home&msg=' . urlencode('Data sepatu berhasil dihapus.'));
                exit;
            }
        }
        header('Location: index.php?action=home');
        exit;
    }
}
