<?php

require_once 'views/partials/navbar.php';  // Memanggil file navbar.php yang terpisah
require_once __DIR__ . '/../controllers/totalpengajuanController.php';  // Pastikan path sesuai dengan lokasi totalepengajuanController.php
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="/assets/images/logopusri.png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body class="bg-gray-200">
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
                <!-- Tampilkan menu hanya jika role bukan 'approval' -->
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
        <!-- Welcome Message -->
        <div class="border-b border-gray-200 pb-2 mb-4">
            <h1 class="text-4xl font-bold text-center text-gray-800">Riwayat</h1>
        </div>

        <!-- Content Section with Log Riwayat -->
        <section class="mt-6 flex">
            <div class="w-full">
                <div class="bg-white shadow-md p-4">
                    <div class="border-b border-gray-200 pb-2 mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Log Riwayat</h3>
                    </div>
                    <!-- Mengubah tinggi max-h-64 menjadi max-h-96 untuk memperpanjang card -->
                    <div class="space-y-2 max-h-96 h-96 overflow-y-auto hide-scrollbar">
                        <?php
                        foreach ($riwayat as $index => $activity):
                            $bgColor = '';
                            if (strtolower($activity['status']) === 'pending') {
                                $bgColor = 'bg-yellow-100';
                            } elseif (strtolower($activity['status']) === 'disetujui') {
                                $bgColor = 'bg-green-100';
                            } else {
                                $bgColor = 'bg-red-100';
                            }
                            ?>
                            <div class="<?php echo $bgColor; ?> p-4 mb-2 hover:bg-gray-100 transition-colors duration-300">
                                <ul class="list-disc pl-5">
                                    <li>
                                        Pengajuan oleh
                                        <strong><?php echo htmlspecialchars($activity['nm_pengaju']); ?></strong>
                                        dari departemen
                                        <strong><?php echo htmlspecialchars($activity['nm_divisi']); ?></strong>
                                        telah <strong><?php echo htmlspecialchars($activity['status']); ?></strong>
                                        pada <?php echo htmlspecialchars($activity['tgl_pengajuan']); ?>
                                    </li>
                                </ul>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <style>
            /* CSS untuk menyembunyikan scroll bar */
            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .hide-scrollbar {
                -ms-overflow-style: none;
                /* Internet Explorer 10+ */
                scrollbar-width: none;
                /* Firefox */
            }
        </style>

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
    </div>
</body>

</html>