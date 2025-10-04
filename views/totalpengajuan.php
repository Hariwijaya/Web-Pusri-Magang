<?php

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../controllers/totalpengajuanController.php';  // Menggunakan totalpengajuanController.php
require_once 'partials/navbar.php';  // Pastikan path sesuai dengan lokasi navbar.php
$role = $_SESSION['role'];
$username = $_SESSION['nm_pengguna'];  // Nama pengguna yang sedang login

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Pengajuan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style>
        table {
            table-layout: fixed;
            width: 100%;
        }

        td,
        th {
            padding: 12px;
            word-break: keep-all;
            word-spacing: normal;
            white-space: normal;
            overflow-wrap: break-word;
            vertical-align: top;
        }

        .keterangan-cell {
            width: 100%;
            word-break: keep-all;
            white-space: normal;
            overflow-wrap: break-word;
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
                    <a href="index.php?page=dashboard"
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
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Total Pengajuan</h1>
        <div class="overflow-x-auto bg-white p-6 rounded-lg shadow-lg">
            <!-- Tambahkan di atas tabel, misalnya sebelum <div class="overflow-x-auto"> -->
            <div class="mb-4 flex items-center justify-between">
                <form method="get" action="" class="flex items-center space-x-2">
                    <input type="hidden" name="page" value="totalpengajuan">
                    <select name="month" class="form-select px-4 py-2 border rounded">
                        <?php foreach ($availableMonths as $month): ?>
                            <option value="<?php echo $month; ?>" <?php echo ($selectedMonth === $month) ? 'selected' : ''; ?>>
                                <?php
                                $monthName = date('F Y', strtotime($month . '-01'));
                                echo htmlspecialchars($monthName);
                                ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Di dalam form filter, tambahkan dropdown status -->
<select name="status" class="form-select px-4 py-2 border rounded">
    <option value="">Semua Status</option>
    <option value="Pending" <?php echo ($selectedStatus === 'Pending') ? 'selected' : ''; ?>>Pending</option>
    <option value="Disetujui" <?php echo ($selectedStatus === 'Disetujui') ? 'selected' : ''; ?>>Disetujui</option>
    <option value="Ditolak" <?php echo ($selectedStatus === 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
</select>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Filter
                    </button>
                </form>

                <!-- Tombol Export CSV -->
                <a href="../penjualan/controllers/export_csv.php?month=<?php echo $selectedMonth; ?>&status=<?php echo $selectedStatus; ?>"
    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 flex items-center">
    <i class="bi bi-file-spreadsheet mr-2"></i> Export CSV
</a>
                </form>

                <!-- Tambahan: Tampilkan total statistik untuk bulan yang dipilih -->
                <div class="flex space-x-4">
                    <div class="bg-gray-200 p-2 rounded">
                        Total Pengajuan: <span class="font-bold"><?php echo $totalPengajuan; ?></span>
                    </div>
                    <div class="bg-yellow-200 p-2 rounded">
                        Pending: <span class="font-bold"><?php echo $pengajuanTertunda; ?></span>
                    </div>
                    <div class="bg-green-200 p-2 rounded">
                        Disetujui: <span class="font-bold"><?php echo $pengajuanDisetujui; ?></span>
                    </div>
                    <div class="bg-red-200 p-2 rounded">
                        Ditolak: <span class="font-bold"><?php echo $pengajuanDitolak; ?></span>
                    </div>
                </div>

                
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Departemen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Pengajuan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Pengaju</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($riwayat as $item): ?>
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($item['nm_divisi']); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?php echo htmlspecialchars($item['nm_sparepart']); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($item['jumlah']); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?php $formattedDate = date("Y-m-d H:i:s", strtotime($item['tgl_pengajuan']));
                                echo htmlspecialchars($formattedDate); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($item['status']); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($item['nm_pengaju']); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 keterangan-cell">
                                <?php echo htmlspecialchars($item['keterangan']); ?>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 flex space-x-4">
                                <!-- Tombol aksi jika status Pending -->
                                <?php if ($item['status'] === 'Pending'): ?>
                                    <?php if ($role === 'approval'): ?>
                                        <form action="../penjualan/controllers/totalpengajuanController.php" method="post">
                                            <input type="hidden" name="id_pengajuan"
                                                value="<?php echo htmlspecialchars($item['id_pengajuan']); ?>">
                                            <button type="submit" name="action" value="approve"
                                                class="flex items-center px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                                                <i class="bi bi-check2-circle mr-2"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="../penjualan/controllers/totalpengajuanController.php" method="post"
                                            onsubmit="return confirm('Anda yakin ingin menolak pengajuan ini?');">
                                            <input type="hidden" name="id_pengajuan"
                                                value="<?php echo htmlspecialchars($item['id_pengajuan']); ?>">
                                            <button type="submit" name="action" value="reject"
                                                class="flex items-center px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                                                <i class="bi bi-x-circle mr-2"></i> Tolak
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <!-- Tombol edit jika pengaju adalah yang login dan status belum disetujui -->
                                <?php if ($role !== 'approval' && $username === $item['nm_pengaju'] && $item['status'] !== 'Disetujui'): ?>
                                    <a href="/penjualan/views/edit_pengajuan.php?id_pengajuan=<?php echo htmlspecialchars($item['id_pengajuan']); ?>"
                                        class="text-blue-500 hover:text-blue-700">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php endif; ?>

                                <!-- Tombol hapus untuk role super_admin -->
                                <?php if ($role === 'super_admin'): ?>
                                    <form action="../penjualan/controllers/totalpengajuanController.php" method="post"
                                        onsubmit="return confirm('Anda yakin ingin menghapus pengajuan ini?');">
                                        <input type="hidden" name="id_pengajuan"
                                            value="<?php echo htmlspecialchars($item['id_pengajuan']); ?>">
                                        <button type="submit" name="action" value="delete"
                                            class="flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400">
                                            <i class="bi bi-trash-fill mr-2"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


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