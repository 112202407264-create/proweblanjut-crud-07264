<?php
// api/read.php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require_once '../config/database.php';
require_once '../app/models/Barang.php';

try {
    $barangModel = new Barang($pdo);
    $data = $barangModel->getAll();

    if ($data) {
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Data barang berhasil diambil.",
            "data" => $data
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            "status" => "success",
            "message" => "Data barang kosong.",
            "data" => []
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Terjadi kesalahan pada server: " . $e->getMessage()
    ]);
}
