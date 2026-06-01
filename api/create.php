<?php
// api/create.php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

require_once '../config/database.php';
require_once '../models/Barang.php';

// Ambil input JSON atau form data
$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
    $input = $_POST;
}

$kode_barang = $input['kode_barang'] ?? '';
$nama_barang = $input['nama_barang'] ?? '';
$jumlah = $input['jumlah'] ?? '';
$harga = $input['harga'] ?? '';
$satuan = $input['satuan'] ?? '';
$lokasi = $input['lokasi'] ?? '';
$tanggal_masuk = $input['tanggal_masuk'] ?? null;

if (empty($kode_barang) || empty($nama_barang) || $jumlah === '' || $harga === '') {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap. Pastikan kode_barang, nama_barang, jumlah, dan harga terisi."
    ]);
    exit;
}

try {
    $barangModel = new Barang($pdo);
    
    // Cek apakah kode barang sudah ada
    $existing = $barangModel->getById($kode_barang);
    if ($existing) {
        http_response_code(409);
        echo json_encode(["status" => "error", "message" => "Kode barang sudah digunakan."]);
        exit;
    }

    $data = [
        'kode_barang' => $kode_barang,
        'nama_barang' => $nama_barang,
        'jumlah' => (int)$jumlah,
        'harga' => (int)$harga,
        'satuan' => $satuan,
        'lokasi' => $lokasi,
        'tanggal_masuk' => $tanggal_masuk,
        'gambar' => null // API create sederhana, belum menangani unggah gambar kompleks
    ];

    $result = $barangModel->insert($data);

    if ($result) {
        http_response_code(201);
        echo json_encode([
            "status" => "success",
            "message" => "Data barang berhasil ditambahkan."
        ]);
    } else {
        http_response_code(503);
        echo json_encode([
            "status" => "error",
            "message" => "Gagal menambahkan data barang."
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Terjadi kesalahan pada server: " . $e->getMessage()
    ]);
}
