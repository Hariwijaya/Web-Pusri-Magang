<?php
session_start();
require_once 'config/database.php';

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: homepage.php"); // Arahkan ke homepage.php jika belum login
    exit;
}

$role = $_SESSION['role'];

$allowed_roles = [
    'dashboard' => ['admin_divisi', 'super_admin', 'approval'],
    'pengajuan' => ['admin_divisi', 'super_admin'],
    'totalpengajuan' => ['admin_divisi', 'super_admin', 'approval'],
    'sparepart' => ['admin_divisi', 'super_admin', 'approval'],
    'riwayat' => ['admin_divisi', 'super_admin', 'approval'],
    'datapengguna' => ['super_admin'],
    'profile' => ['admin_divisi', 'super_admin', 'approval'],
    'register' => ['super_admin']
];

// Proses logout
if (isset($_GET['page']) && $_GET['page'] === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

if (array_key_exists($page, $allowed_roles)) {
    $allowed = $allowed_roles[$page];
    if (is_array($allowed)) {
        if (!in_array($role, $allowed)) {
            require_once 'views/404.php'; // Alihkan ke halaman 403
            exit;
        }
    } else {
        if ($role !== $allowed) {
            require_once 'views/404.php'; // Alihkan ke halaman 403
            exit;
        }
    }
} else {
    require_once 'views/404.php';
    exit;
}

switch ($page) {
    case 'dashboard':
        require_once 'views/dashboard.php';
        break;
    case 'pengajuan':
        require_once 'views/pengajuan.php';
        break;
    case 'editpengajuan':
        require_once 'views/edit_pengajuan.php';
        break;
    case 'totalpengajuan':
        require_once 'controllers/totalpengajuanController.php';
        require_once 'views/totalpengajuan.php';
        break;
    case 'sparepart':
        require_once 'controllers/sparepartController.php';
        require_once 'views/daftar_sparepart.php';
        break;
    case 'profile':
        require_once 'views/profile_akun.php';
        break;
    case 'riwayat':
        require_once 'views/riwayat.php';
        break;
    case 'datapengguna':
        require_once 'views/data_pengguna.php';
        break;
    case 'register':
        require_once 'register.php';
        break;
    default:
        require_once 'views/404.php';
        break;
}
?>