<?php
// api/update.php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

require_once '../config/database.php';
require_once '../models/Barang.php';

// Ambil input JSON atau form data (PUT biasanya masuk php://input)
$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
    // Fallback jika dikirim lewat POST form urlencoded
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = $_POST;
    } else {
        // Untuk form-urlencoded PUT request
        parse_str(file_get_contents("php://input"), $input);
    }
}

$id = $input['id'] ?? ($input['kode_barang'] ?? '');

if (empty($id)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Parameter id atau kode_barang tidak ditemukan."
    ]);
    exit;
}

try {
    $barangModel = new Barang($pdo);
    
    // Cek apakah data yang akan diupdate ada
    $existing = $barangModel->getById($id);
    if (!$existing) {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Data barang dengan ID tersebut tidak ditemukan."]);
        exit;
    }

    $updateData = [
        'nama_barang' => $input['nama_barang'] ?? $existing['nama_barang'],
        'jumlah' => isset($input['jumlah']) ? (int)$input['jumlah'] : (int)$existing['jumlah'],
        'harga' => isset($input['harga']) ? (int)$input['harga'] : (int)$existing['harga'],
        'satuan' => $input['satuan'] ?? $existing['satuan'],
        'lokasi' => $input['lokasi'] ?? $existing['lokasi'],
        'tanggal_masuk' => $input['tanggal_masuk'] ?? $existing['tanggal_masuk'],
        'gambar' => $existing['gambar'] // Biarkan gambar lama via API biasa
    ];

    $result = $barangModel->update($id, $updateData);

    if ($result) {
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Data barang berhasil diperbarui."
        ]);
    } else {
        http_response_code(503);
        echo json_encode([
            "status" => "error",
            "message" => "Gagal memperbarui data barang."
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Terjadi kesalahan pada server: " . $e->getMessage()
    ]);
}
