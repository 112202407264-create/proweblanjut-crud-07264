<?php
$currentAction = $_GET['action'] ?? 'home';
?>
<div class="app-sidebar-inner">
    <nav class="app-nav-vertical">
        <a class="app-nav-item <?= ($currentAction === 'dashboard') ? 'active' : '' ?>" href="index.php?action=dashboard">
            <span class="app-nav-icon"><i class="fa-solid fa-house"></i></span>
            Dashboard
        </a>
        <a class="app-nav-item <?= ($currentAction === 'home' || $currentAction === 'tambah' || $currentAction === 'edit') ? 'active' : '' ?>" href="index.php?action=home">
            <span class="app-nav-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
            Data Barang
        </a>
    </nav>
</div>
