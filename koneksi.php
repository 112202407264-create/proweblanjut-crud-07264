<?php
/**
 * File koneksi database menggunakan PDO
 * Sesuaikan nilai host, dbname, username, dan password dengan setelan MySQL Anda.
 */

$host = 'localhost';
$db   = 'pwl_inventaris'; // nama database
$user = 'root';           // default XAMPP
$pass = '';               // default XAMPP biasanya kosong
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Matikan pada produksi, ini hanya untuk tugas/latihan
    die('Koneksi ke database gagal: ' . $e->getMessage());
}


