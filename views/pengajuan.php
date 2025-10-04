<?php

require_once 'partials/navbar.php';  // Pastikan path sesuai dengan lokasi navbar.php
require_once __DIR__ . '/../config/database.php';
$role = $_SESSION['role'];

// Ambil daftar kategori dari database
$stmt = $pdo->prepare("SELECT * FROM kategori");
$stmt->execute();
$kategoris = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil daftar sparepart berdasarkan kategori jika sudah dipilih
$spareparts = [];
if (isset($_POST['kategori'])) {
    $kategoriId = $_POST['kategori'];
    $stmt = $pdo->prepare("SELECT * FROM sparepart WHERE kategori = :kategoriId");
    $stmt->execute(['kategoriId' => $kategoriId]);
    $spareparts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Sparepart</title>
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
                    <a href="index.php?page=dashboard"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-house-door text-lg mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li class="mb-4">
                    <a href="index.php?page=pengajuan"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-file-earmark-text text-lg mr-2"></i>
                        Pengajuan Sparepart
                    </a>
                </li>
                <li class="mb-4">
                    <a href="index.php?page=totalpengajuan"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-clipboard2-check-fill text-lg mr-2"></i>
                        Total Pengajuan
                    </a>
                </li>
                <li class="mb-4">
                    <a href="index.php?page=sparepart"
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
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-5">Pengajuan Sparepart</h1>
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
            <form action="../penjualan/controllers/pengajuanController.php" method="post" class="space-y-6">
                <input type="hidden" name="id_divisi" value="<?php echo $_SESSION['id_divisi']; ?>">

                <!-- Dropdown Kategori -->
                <div>
                    <label for="kategori" class="block text-lg font-medium text-gray-700">Kategori:</label>
                    <select id="kategori" name="kategori"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <?php foreach ($kategoris as $kategori): ?>
                            <option value="<?php echo $kategori['id_kategori']; ?>"><?php echo $kategori['nama']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Dropdown Nama Sparepart -->
                <div>
                    <label for="nm_barang" class="block text-lg font-medium text-gray-700">Nama Sparepart:</label>
                    <select id="nm_barang" name="nm_barang"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="" disabled selected>Pilih Sparepart</option>
                    </select>
                </div>

                <div>
                    <label for="jumlah" class="block text-lg font-medium text-gray-700">Jumlah:</label>
                    <input type="number" id="jumlah" name="jumlah"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                </div>
                <div>
                    <label for="keterangan" class="block text-lg font-medium text-gray-700">Keterangan:</label>
                    <textarea id="keterangan" name="keterangan"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        rows="4" required></textarea>
                </div>
                <!-- Nama Pengaju otomatis diambil dari sesi -->
                <input type="hidden" name="nm_pengaju"
                    value="<?php echo htmlspecialchars($_SESSION['nm_pengguna']); ?>">
                <div>
                    <?php if ($role !== 'super_admin'): ?>
                        <button type="submit" class="w-full bg-gray-700 text-white p-2 rounded-md">Ajukan</button>
                    <?php else: ?>
                        <button type="button" class="w-full bg-gray-400 text-white p-2 rounded-md" disabled>Ajukan</button>
                    <?php endif; ?>
                </div>

                <div>
                    <button type="reset" class="w-full mt-2 bg-red-500 text-white p-2 rounded-md">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('kategori').addEventListener('change', function () {
            var kategoriId = this.value;

            // Hanya jalankan AJAX jika kategori dipilih
            if (kategoriId) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../penjualan/controllers/get_spareparts.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var spareparts = JSON.parse(xhr.responseText);
                        var sparepartSelect = document.getElementById('nm_barang');
                        sparepartSelect.innerHTML = '<option value="" disabled selected>Pilih Sparepart</option>';

                        // Isi dropdown sparepart berdasarkan kategori yang dipilih
                        spareparts.forEach(function (sparepart) {
                            var option = document.createElement('option');
                            option.value = sparepart.id_sparepart;
                            option.textContent = sparepart.nm_sparepart;
                            sparepartSelect.appendChild(option);
                        });
                    }
                };
                xhr.send('kategori=' + kategoriId);
            }
        });

    </script>

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