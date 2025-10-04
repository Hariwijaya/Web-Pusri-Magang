<?php
require_once 'partials/navbar.php';
require_once __DIR__ . '/../config/database.php';

$role = $_SESSION['role'];

// Mendapatkan instance PDO
$pdo = getPDOInstance();

// Mendapatkan kategori yang dipilih dari parameter URL (GET)
$kategori_id = isset($_GET['kategori_id']) ? $_GET['kategori_id'] : '';

// Ambil daftar sparepart dari database berdasarkan kategori yang dipilih
if ($kategori_id) {
    $stmt = $pdo->prepare("SELECT * FROM sparepart WHERE kategori = :kategori_id");
    $stmt->bindParam(':kategori_id', $kategori_id, PDO::PARAM_INT);
} else {
    $stmt = $pdo->prepare("SELECT * FROM sparepart");
}

$stmt->execute();
$spareparts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil daftar kategori untuk dropdown
$stmt = $pdo->prepare("SELECT * FROM kategori");
$stmt->execute();
$kategoris = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil nama kategori untuk setiap sparepart
$kategoriMap = [];
foreach ($kategoris as $kategori) {
    $kategoriMap[$kategori['id_kategori']] = $kategori['nama'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sparepart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style>
        /* Mengatur batas tinggi dan scroll untuk tabel */
        .table-cell {
            max-height: 50px;
            /* Batas tinggi sel */
            overflow: hidden;
            /* Scroll jika isi melebihi tinggi */
            white-space: normal;
            /* Izinkan teks terputus */
            word-break: break-word;
            /* Pecah kata yang panjang */
        }

        /* Mengatur lebar kolom keterangan agar teks bisa terputus dengan baik */
        td.spesifikasi-cell {
            max-width: 300px;
            /* Batas lebar untuk kolom keterangan */
            word-wrap: break-word;
            /* Pecah kata yang panjang */
            word-break: break-all;
            /* Pecah kata jika terlalu panjang */
            white-space: normal;
            /* Teks akan wrap */
            overflow: hidden;
            /* Menghindari teks terlalu memanjang */
        }
    </style>
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
                        <a href="/penjualan/index.php?page=pengajuan"
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
                    <a href="/penjualan/index.php?page=riwayat"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-clock text-lg mr-2"></i>
                        Riwayat
                    </a>
                </li>
            </ul>
            <ul>
                <li class="mb-4 mt-4">
                    <a href="/penjualan/index.php?page=profile"
                        class="flex items-center text-white hover:bg-gray-500 p-2 rounded">
                        <i class="bi bi-person-circle text-lg mr-3"></i> <!-- Mengganti ikon gear dengan ikon profil -->
                        Profile
                    </a>
                </li>
            </ul>
            <hr>
            <ul>
                <?php if ($role !== 'approval' && $role !== 'admin_divisi'): ?>
                    <li class="mb-4 mt-4">
                        <a href="/penjualan/index.php?page=datapengguna"
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
                        <a href="/penjualan/index.php?page=register"
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
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Daftar Sparepart</h1>

        <!-- Form Filter Kategori -->
        <form method="GET" action="/penjualan/views/daftar_sparepart.php" class="mb-4">
            <label for="kategori_id" class="text-lg mr-2">Filter Kategori:</label>
            <select name="kategori_id" id="kategori_id" class="border rounded py-2 px-3">
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategoris as $kategori): ?>
                    <option value="<?= $kategori['id_kategori'] ?>" <?= $kategori['id_kategori'] == $kategori_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kategori['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit"
                class="ml-2 bg-gray-700 text-white py-2 px-4 rounded hover:bg-blue-900">Terapkan</button>
        </form>

        <?php if ($role === 'super_admin'): ?>
            <a href="/penjualan/views/tambah_sparepart.php"
                class="inline-block bg-gray-700 text-white py-2 px-4 rounded-lg mb-3 hover:bg-blue-900">Tambah Sparepart</a>
            <a href="/penjualan/views/kelola_kategori.php"
                class="inline-block bg-gray-700 text-white py-2 px-4 rounded-lg mb-3 hover:bg-blue-900">Kelola Kategori</a>
        <?php endif; ?>


        <div class="overflow-x-auto bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Sparepart</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Spesifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Kategori</th>
                        <?php if ($role === 'super_admin'): ?>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($spareparts as $index => $sparepart): ?>
                        <tr class="hover:bg-gray-200">
                            <td class="px-6 py-4 text-sm text-gray-500"><?= $index + 1 ?></td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                <?= htmlspecialchars($sparepart['nm_sparepart']) ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($sparepart['spesifikasi']) ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?= $sparepart['stok'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?= isset($kategoriMap[$sparepart['kategori']]) ? htmlspecialchars($kategoriMap[$sparepart['kategori']]) : 'Kategori tidak ditemukan' ?>
                            </td>
                            <?php if ($role === 'super_admin'): ?>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <a href="/penjualan/views/edit_sparepart.php?id=<?= $sparepart['id_sparepart'] ?>"
                                        class="text-blue-600 hover:text-blue-800">Edit</a> |
                                    <a href="/penjualan/views/hapus_sparepart.php?id=<?= $sparepart['id_sparepart'] ?>"
                                        class="text-red-600 hover:text-red-800">Hapus</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>