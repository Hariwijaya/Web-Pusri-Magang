<?php
session_start();
require_once 'partials/navbar.php';
require_once __DIR__ . '/../config/database.php'; // Pastikan path sesuai dengan lokasi database.php

$role = $_SESSION['role'];
$id_divisi = $_SESSION['id_divisi']; // Ambil id_divisi dari session pengguna

// Cek apakah role pengguna adalah 'manager_pembelian'
if ($role === 'manager_pembelian') {
    header('Location: unauthorized.php'); // Halaman untuk pengguna yang tidak memiliki akses
    exit();
}

// Mendapatkan instance PDO
$pdo = getPDOInstance();

// Mendapatkan ID pengajuan dari query string
$id_pengajuan = $_GET['id_pengajuan'] ?? null;

if (!$id_pengajuan) {
    header("Location: ../views/404.php");
    exit();
}


// Ambil data pengajuan berdasarkan ID
try {
    $stmt = $pdo->prepare("SELECT p.*, s.nm_sparepart FROM pengajuan p JOIN sparepart s ON p.nm_barang = s.id_sparepart WHERE p.id_pengajuan = ?");
    $stmt->execute([$id_pengajuan]);
    $pengajuan = $stmt->fetch();

    if (!$pengajuan) {
        header("Location: ../views/404.php");
        exit();
    }
} catch (PDOException $e) {
    die("Failed to retrieve pengajuan: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengajuan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    <div id="sidebar"
        class="sidebar bg-gray-800 text-white h-screen fixed top-0 left-0 overflow-y-auto z-10 w-64 transition-transform duration-300">
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
                        <i class="bi bi-house-door text-lg mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <?php if ($role !== 'approval'): ?>
                    <li class="mb-4">
                        <a href="index.php?page=pengajuan"
                            class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                            <i class="bi bi-file-earmark-text text-lg mr-2"></i>
                            Pengajuan Sparepart
                        </a>
                    </li>
                <?php endif; ?>
                <li class="mb-4">
                    <a href="/penjualan/index.php?page=totalpengajuan"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-clipboard2-check-fill text-lg mr-2"></i>
                        Total Pengajuan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="/penjualan/index.php?page=sparepart"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-gear text-lg mr-3"></i>
                        Sparepart
                    </a>
                </li>
                <li class="mb-4">
                    <a href="index.php?page=riwayat" class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-clock text-lg mr-2"></i>
                        Riwayat
                    </a>
                </li>
            </ul>
            <ul>
                <li class="mb-4 mt-4">
                    <a href="index.php?page=profile" class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-person-circle text-lg mr-3"></i> <!-- Mengganti ikon gear dengan ikon profil -->
                        Profile
                    </a>
                </li>
            </ul>
            <hr>
            <ul>
                <?php if ($role !== 'approval' && $role !== 'admin_divisi'): ?>
                    <li class="mb-4 mt-4">
                        <a href="index.php?page=datapengguna"
                            class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                            <i class="bi bi-person text-lg mr-2"></i>
                            Data Pengguna
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

    <!-- Main Content -->
    <div id="mainContent" class="ml-64 p-6 transition-all duration-300">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Edit Pengajuan</h1>
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
            <form action="../views/proses_edit_pengajuan.php?action=update" method="post" class="space-y-6">
                <input type="hidden" name="id_pengajuan"
                    value="<?php echo htmlspecialchars($pengajuan['id_pengajuan']); ?>">

                <input type="hidden" name="id_divisi" value="<?php echo $id_divisi; ?>"> <!-- ID Divisi dari session -->
                <div>
                    <label for="nm_barang" class="block text-lg font-medium text-gray-700">Nama Sparepart:</label>
                    <!-- Dropdown untuk memilih nama sparepart -->
                    <select name="nm_barang" id="nm_barang"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="<?php echo $pengajuan['nm_barang']; ?>" selected>
                            <?php echo htmlspecialchars($pengajuan['nm_sparepart']); ?>
                        </option>
                        <?php
                        // Ambil daftar sparepart untuk ditampilkan dalam dropdown
                        try {
                            $stmt = $pdo->query("SELECT id_sparepart, nm_sparepart FROM sparepart");
                            while ($sparepart = $stmt->fetch()) {
                                echo "<option value='{$sparepart['id_sparepart']}'>" . htmlspecialchars($sparepart['nm_sparepart']) . "</option>";
                            }
                        } catch (PDOException $e) {
                            die("Failed to retrieve spareparts: " . $e->getMessage());
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="jumlah" class="block text-lg font-medium text-gray-700">Jumlah:</label>
                    <input type="number" id="jumlah" name="jumlah"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="<?php echo htmlspecialchars($pengajuan['jumlah']); ?>" required>
                </div>
                <div>
                    <label for="keterangan" class="block text-lg font-medium text-gray-700">Keterangan:</label>
                    <textarea id="keterangan" name="keterangan"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required><?php echo htmlspecialchars($pengajuan['keterangan']); ?></textarea>
                </div>
                <div>
                    <button type="submit" class="w-full bg-gray-700 text-white p-2 rounded-md">Update</button>
                </div>
            </form>
        </div>
    </div>

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

            if (sidebar.classList.contains('-translate-x-full')) {
                showSidebarBtn.classList.remove('hidden');
            } else {
                showSidebarBtn.classList.add('hidden');
            }
        });

        showSidebarBtn.addEventListener('click', function () {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('w-64');
            sidebar.classList.remove('w-0');
            mainContent.classList.add('ml-64');
            mainContent.classList.remove('ml-0');
            showSidebarBtn.classList.add('hidden');
        });
    </script>
</body>

</html>