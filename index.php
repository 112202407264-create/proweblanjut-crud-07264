<?php
// index.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/database.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/BarangController.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
    // Auth Routes
    case 'login':
        $controller = new AuthController($pdo);
        $controller->login();
        break;
    case 'register':
        $controller = new AuthController($pdo);
        $controller->register();
        break;
    case 'logout':
        $controller = new AuthController($pdo);
        $controller->logout();
        break;

    // Dashboard Route
    case 'dashboard':
        $controller = new BarangController($pdo);
        $controller->dashboard();
        break;

    // Barang Routes
    case 'home':
        $controller = new BarangController($pdo);
        $controller->index();
        break;
    case 'tambah':
        $controller = new BarangController($pdo);
        $controller->tambah();
        break;
    case 'edit':
        $controller = new BarangController($pdo);
        $controller->edit();
        break;
    case 'hapus':
        $controller = new BarangController($pdo);
        $controller->hapus();
        break;

    // Default 404 / Fallback
    default:
        $controller = new BarangController($pdo);
        $controller->index();
        break;
}