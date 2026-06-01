<?php
// api/delete.php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

require_once '../config/database.php';
require_once '../app/models/Barang.php';

// Ambil input JSON atau form data
$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = $_POST;
    } else {
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
    
    // Cek apakah data ada
    $existing = $barangModel->getById($id);
    if (!$existing) {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Data barang dengan ID tersebut tidak ditemukan."]);
        exit;
    }

    $result = $barangModel->delete($id);

    if ($result) {
        // Hapus file gambar jika ada
        if (!empty($existing['gambar']) && file_exists('../' . $existing['gambar'])) {
            unlink('../' . $existing['gambar']);
        }

        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Data barang berhasil dihapus."
        ]);
    } else {
        http_response_code(503);
        echo json_encode([
            "status" => "error",
            "message" => "Gagal menghapus data barang."
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Terjadi kesalahan pada server: " . $e->getMessage()
    ]);
}
