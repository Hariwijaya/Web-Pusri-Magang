<?php
require_once 'partials/navbar.php';

// Periksa apakah session berisi user_id
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Ambil user_id dari session
require_once __DIR__ . '/../config/database.php';

// Query untuk mengambil data pengguna termasuk gambar profil, email, tanggal dibuat, role, dan divisi
$query_profile = "
    SELECT p.nm_pengguna, p.foto_profil, p.email, p.tgl_buat, p.role, d.nm_divisi 
    FROM pengguna p
    LEFT JOIN divisi d ON p.id_divisi = d.id_divisi
    WHERE p.id_pengguna = :user_id";
$stmt_profile = $pdo->prepare($query_profile);
$stmt_profile->execute(['user_id' => $user_id]);
$user = $stmt_profile->fetch(PDO::FETCH_ASSOC);

// Tambahkan kode debug di sini:
// echo "<pre>";
// var_dump($_SESSION); // Cek isi session
// var_dump($user['foto_profil']); // Cek path foto dari database
// echo "</pre>";

// Cek apakah data pengguna ditemukan
if (!$user) {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

// Jika tidak ada gambar profil, gunakan gambar default

$profile_picture = $user['foto_profil'] ? str_replace("../", "/penjualan/", $user['foto_profil']) : '/penjualan/assets/uploads/default-avatar.jpg';

// Tentukan label role yang lebih mudah dipahami
$roles = [
    'super_admin' => 'Super Admin',
    'admin_divisi' => 'Admin Divisi',
    'approval' => 'Approval',
];
$role_label = $roles[$user['role']] ?? 'Pengguna';

// Ambil role dari session untuk sidebar
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-details {
            margin-left: 20px;
        }

        .profile-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-details p {
            margin: 0;
        }

        .profile-edit-btn {
            margin-top: 20px;
            text-align: center;
        }

        /* Tambahan untuk tombol edit */
        .btn-edit {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar bg-gray-800 text-white h-screen fixed top-0 left-0 overflow-y-auto z-10 w-64">
        <div class="p-3 relative">
            <img src="https://sikp.pusri.co.id/static/media/logo-white.b054006e16dac76de809.png" alt="Logo"
                class="ml-3 w-15 h-10 mx-auto">
            <button id="toggleSidebar" class="absolute mt-2 top-3 right-0 focus:outline-none">
                <i class="bi bi-chevron-double-left text-lg"></i>
            </button>
        </div>
        <hr class="border-t-2 border-dotted border-white">
        <nav class="p-4">
            <ul>
                <li class="mb-4">
                    <a href="/penjualan/index.php?page=dashboard"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-house-door text-lg mr-2"></i> Dashboard
                    </a>
                </li>
                <?php if ($role !== 'approval'): ?>
                    <li class="mb-4">
                        <a href="/penjualan/index.php?page=pengajuan"
                            class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                            <i class="bi bi-file-earmark-text text-lg mr-2"></i> Pengajuan Sparepart
                        </a>
                    </li>
                <?php endif; ?>
                <li class="mb-4">
                    <a href="/penjualan/index.php?page=totalpengajuan"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-clipboard2-check-fill text-lg mr-2"></i> Total Pengajuan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/penjualan/index.php?page=sparepart"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-gear text-lg mr-3"></i> Sparepart
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/penjualan/index.php?page=riwayat"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-clock text-lg mr-2"></i> Riwayat
                    </a>
                </li>
            </ul>
            <ul>
                <li class="mb-4 mt-4">
                    <a href="/penjualan/index.php?page=profile"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-person-circle text-lg mr-3"></i> Profile
                    </a>
                </li>
            </ul>
            <hr>
            <ul>
                <?php if ($role !== 'approval' && $role !== 'admin_divisi'): ?>
                    <li class="mb-4 mt-4">
                        <a href="/penjualan/index.php?page=datapengguna"
                            class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                            <i class="bi bi-person text-lg mr-2"></i> Data Pengguna
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul>
                <?php if ($role !== 'approval' && $role !== 'admin_divisi'): ?>
                    <li class="mb-4">
                        <a href="index.php?page=register"
                            class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                            <i class="bi bi-file-earmark-text text-lg mr-2"></i>
                            Register
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <!-- Button to Show Sidebar -->
    <button id="showSidebar" class="fixed top-4 left-4 z-20 bg-gray-700 text-white p-2 rounded hidden">
        <i class="bi bi-chevron-double-right text-lg"></i>
    </button>

    <!-- Konten Utama -->
    <div id="mainContent" class="ml-64 p-6 transition-all duration-300">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Profile Akun</h1>
        <div class="container mt-5">
            <div class="profile-container">
                <div class="profile-row">
                    <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture">
                    <div class="profile-details">
                        <h2><?php echo htmlspecialchars($user['nm_pengguna']); ?></h2>
                        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                        <p>Departemen: <?php echo htmlspecialchars($user['nm_divisi']); ?></p>
                        <p>Bergabung sejak: <?php echo date('d M Y', strtotime($user['tgl_buat'])); ?></p>
                    </div>
                </div>
                <div class="profile-edit-btn">
                    <a href="/penjualan/views/edit_profile.php" class="btn-edit">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>

</body>

<!-- JavaScript for Sidebar Toggle -->
<script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');
    const showSidebarBtn = document.getElementById('showSidebar');

    toggleSidebarBtn.addEventListener('click', function () {
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-0');
        mainContent.classList.toggle('ml-64');
        mainContent.classList.toggle('ml-0');
        showSidebarBtn.classList.toggle('hidden');
    });

    showSidebarBtn.addEventListener('click', function () {
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-0');
        mainContent.classList.toggle('ml-64');
        mainContent.classList.toggle('ml-0');
        showSidebarBtn.classList.toggle('hidden');
    });
</script>

</html>