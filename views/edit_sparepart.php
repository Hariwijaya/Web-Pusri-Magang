<?php

require_once 'partials/navbar.php';
require_once __DIR__ . '/../config/database.php';

$role = $_SESSION['role'];

$pdo = getPDOInstance();

$id_sparepart = $_GET['id'];

// Ambil data sparepart berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM sparepart WHERE id_sparepart = ?");
$stmt->execute([$id_sparepart]);
$sparepart = $stmt->fetch();

// Ambil daftar kategori untuk dropdown
$stmt = $pdo->prepare("SELECT * FROM kategori");
$stmt->execute();
$kategoris = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sparepart</title>
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
                    <a href="../index.php?page=dashboard"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-house-door text-lg mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-4">
                    <a href="../index.php?page=pengajuan"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-file-earmark-text text-lg mr-2"></i>
                        Pengajuan Sparepart
                    </a>
                </li>
                <li class="mb-4">
                    <a href="../index.php?page=totalpengajuan"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-clipboard2-check-fill text-lg mr-2"></i>
                        Total Pengajuan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="../index.php?page=sparepart"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-gear text-lg mr-3"></i>
                        Sparepart
                    </a>
                </li>
                <li class="mb-4">
                    <a href="../index.php?page=riwayat"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-clock text-lg mr-2"></i>
                        Riwayat
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
        </nav>
    </div>

    <!-- Button to Show Sidebar -->
    <button id="showSidebar" class="fixed top-4 left-4 z-20 bg-gray-700 text-white p-2 rounded hidden">
        <i class="bi bi-chevron-double-right text-lg"></i>
    </button>

    <div id="mainContent" class="ml-64 p-6 transition-all duration-300">
        <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Edit Sparepart</h2>
            <form action="../controllers/sparepartController.php" method="POST">
                <input type="hidden" name="action" value="edit" />
                <input type="hidden" name="id_sparepart" value="<?= $sparepart['id_sparepart'] ?>" />

                <div class="mb-6">
                    <label for="nm_sparepart" class="block text-sm font-medium text-gray-700">Nama Sparepart</label>
                    <input type="text"
                        class="form-input mt-1 block w-full p-3 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        id="nm_sparepart" name="nm_sparepart" value="<?= $sparepart['nm_sparepart'] ?>" required />
                </div>

                <div class="mb-6">
                    <label for="spesifikasi" class="block text-sm font-medium text-gray-700">Spesifikasi</label>
                    <textarea
                        class="form-input mt-1 block w-full p-3 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        id="spesifikasi" name="spesifikasi" required><?= $sparepart['spesifikasi'] ?></textarea>
                </div>

                <div class="mb-6">
                    <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number"
                        class="form-input mt-1 block w-full p-3 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        id="stok" name="stok" value="<?= $sparepart['stok'] ?>" required />
                </div>

                <div class="mb-6">
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select
                        class="form-select mt-1 block w-full p-3 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        name="kategori" id="kategori" required>
                        <?php foreach ($kategoris as $kategori): ?>
                            <option value="<?= $kategori['id_kategori'] ?>"
                                <?= $kategori['id_kategori'] == $sparepart['kategori'] ? 'selected' : '' ?>>
                                <?= $kategori['nama'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="submit"
                        class="bg-gray-700 text-white px-6 py-3 rounded-lg hover:bg-indigo-900 focus:outline-none">Simpan
                        Perubahan</button>
                    <a href="../views/daftar_sparepart.php"
                        class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-indigo-900 focus:outline-none">Kembali</a>
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