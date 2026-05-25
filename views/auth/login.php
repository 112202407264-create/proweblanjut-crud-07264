<?php
// views/auth/login.php
$cssVer = file_exists(__DIR__ . '/../../assets/app.css') ? filemtime(__DIR__ . '/../../assets/app.css') : time();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Inventaris Sepatu</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/app.css?v=<?= (int) $cssVer ?>">
</head>
<body class="auth-page-body">
<div class="auth-card">
    <div class="auth-card-header">
        <h5>Selamat Datang</h5>
        <div class="auth-card-subtitle">Silakan login untuk melanjutkan</div>
    </div>

    <div class="auth-card-body">

        <?php if (!empty($msg)): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" method="post" action="index.php?action=login">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="remember_me" name="remember_me"
                    <?= isset($_POST['remember_me']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="remember_me">
                    Remember Me <span class="text-muted">(tetap login 30 hari)</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary auth-primary-btn">
                <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk Sekarang
            </button>
        </form>

        <div class="text-center mt-3 small">
            Belum punya akun? <a href="index.php?action=register" class="auth-link">Daftar di sini</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
