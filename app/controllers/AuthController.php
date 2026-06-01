<?php
class AuthController {
    private $userModel;

    public function __construct($pdo) {
        require_once 'app/models/User.php';
        $this->userModel = new User($pdo);
    }

    public function login() {
        // Cek autologin cookie
        if (empty($_SESSION['user_id']) && !empty($_COOKIE['remember_me'])) {
            $uid = (int) $_COOKIE['remember_me'];
            $user = $this->userModel->getById($uid);

            if ($user) {
                $_SESSION['user_id']  = (int) $user['user_id'];
                $_SESSION['username'] = $user['username'];
            } else {
                setcookie('remember_me', '', time() - 3600, '/');
            }
        }

        if (!empty($_SESSION['user_id'])) {
            header('Location: index.php?action=dashboard');
            exit;
        }

        $error = '';
        $msg   = $_GET['msg'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username   = trim($_POST['username'] ?? '');
            $password   = $_POST['password']      ?? '';
            $rememberMe = isset($_POST['remember_me']);

            if ($username === '' || $password === '') {
                $error = 'Username dan password wajib diisi.';
            } else {
                $user = $this->userModel->getByUsername($username);
                if (!$user || !password_verify($password, $user['password_hash'])) {
                    $error = 'Username atau password salah.';
                } else {
                    $_SESSION['user_id']  = (int) $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    if ($rememberMe) {
                        setcookie('remember_me', (string) $user['user_id'], time() + (30 * 24 * 60 * 60), '/'); // 30 hari
                    }
                    header('Location: index.php?action=dashboard');
                    exit;
                }
            }
        }

        require 'app/views/auth/login.php';
    }

    public function register() {
        if (!empty($_SESSION['user_id'])) {
            header('Location: index.php?action=dashboard');
            exit;
        }

        $error = '';
        $msg   = $_GET['msg'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            if ($username === '' || $password === '' || $password_confirm === '') {
                $error = 'Semua kolom wajib diisi.';
            } elseif (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
                $error = 'Username hanya boleh huruf, angka, dan underscore (3-30 karakter).';
            } elseif (strlen($password) < 6) {
                $error = 'Password minimal 6 karakter.';
            } elseif ($password !== $password_confirm) {
                $error = 'Konfirmasi password tidak sesuai.';
            } else {
                try {
                    $existing = $this->userModel->getByUsername($username);
                    if ($existing) {
                        $error = 'Username sudah digunakan. Silakan pilih username lain.';
                    } else {
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);
                        $this->userModel->insert($username, $password_hash);
                        header('Location: index.php?action=login&msg=' . urlencode('Registrasi berhasil. Silakan login.'));
                        exit;
                    }
                } catch (Exception $e) {
                    $error = 'Gagal register. Cek struktur tabel (users).';
                }
            }
        }

        require 'app/views/auth/register.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        setcookie('remember_me', '', time() - 3600, '/');
        header('Location: index.php?action=login');
        exit;
    }
}
