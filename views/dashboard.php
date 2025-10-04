<?php
require_once 'views/partials/navbar.php';
require_once __DIR__ . '/../controllers/totalpengajuanController.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');  // Jika tidak login, arahkan ke halaman login
    exit;
}

// Ambil role dari session
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

    <button id="showSidebar" class="fixed top-4 left-4 z-20 bg-gray-700 text-white p-2 rounded hidden">
        <i class="bi bi-chevron-double-right text-lg"></i>
    </button>

    <div id="mainContent" class="ml-64 p-6 transition-all duration-300">
        <div class="border-b border-gray-200 pb-2 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Selamat Datang di Dashboard</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow-md rounded-lg p-4 flex flex-col">
                <div class="border-b border-gray-200 pb-2 mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Diagram Pengajuan</h2>
                </div>
                <div class="flex items-center">
                    <div class="chart-container w-full lg:w-1/2">
                        <canvas id="pengajuanChart" width="200" height="200"></canvas>
                    </div>
                    <div id="percentageInfo" class="w-full lg:w-1/2 pl-6 text-gray-800">
                        <p class="font-bold">Pengajuan Disetujui: <span id="approvedPercentage">0%</span></p>
                        <p class="font-bold">Pengajuan Tertunda: <span id="pendingPercentage">0%</span></p>
                        <p class="font-bold">Pengajuan Ditolak: <span id="rejectedPercentage">0%</span></p>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div
                    class="bg-blue-500 shadow-md rounded-lg p-6 text-white flex items-center transition transform hover:shadow-lg hover:bg-blue-600">
                    <i class="bi bi-bar-chart-line-fill text-5xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold">Total Pengajuan</h3>
                        <p class="text-3xl font-bold"><?php echo htmlspecialchars($totalPengajuan); ?></p>
                    </div>
                </div>
                <div
                    class="bg-yellow-500 shadow-md rounded-lg p-6 text-white flex items-center transition transform hover:shadow-lg hover:bg-yellow-600">
                    <i class="bi bi-clock-fill text-5xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold">Pengajuan Tertunda</h3>
                        <p class="text-3xl font-bold"><?php echo htmlspecialchars($pengajuanTertunda); ?></p>
                    </div>
                </div>
                <div
                    class="bg-green-500 shadow-md rounded-lg p-6 text-white flex items-center transition transform hover:shadow-lg hover:bg-green-600">
                    <i class="bi bi-check-circle-fill text-5xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold">Pengajuan Disetujui</h3>
                        <p class="text-3xl font-bold"><?php echo htmlspecialchars($pengajuanDisetujui); ?></p>
                    </div>
                </div>
                <div
                    class="bg-red-500 shadow-md rounded-lg p-6 text-white flex items-center transition transform hover:shadow-lg hover:bg-red-600">
                    <i class="bi bi-x-circle-fill text-5xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold">Pengajuan Ditolak</h3>
                        <p class="text-3xl font-bold"><?php echo htmlspecialchars($pengajuanDitolak); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <?php
        $totalData = count($riwayat);
        ?>

        <section class="mt-6">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800">Log Status</h3>

                <!-- Filter Nama Pengaju dan Kotak Total Data -->
                <div class="flex items-center space-x-4">
                    <!-- Button Refresh -->
                    <button onclick="location.reload()"
                        class="bg-green-500 text-white w-10 h-10 rounded hover:bg-green-600 transition flex items-center justify-center">
                        <i class="bi bi-arrow-clockwise text-lg"></i>
                    </button>

                    <!-- Kotak Total Data -->
                    <div class="bg-blue-500 text-white px-4 py-2 rounded shadow-md">
                        <span class="font-bold"><?php echo $totalData; ?></span>
                    </div>
                </div>
            </div>

            <!-- Table Log Aktivitas -->
            <table class="min-w-full bg-white mt-6" id="logTable">
                <thead>
                    <tr>
                        <th
                            class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">
                            No
                        </th>
                        <th
                            class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">
                            Nama Pengaju
                        </th>
                        <th
                            class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">
                            Departemen
                        </th>
                        <th
                            class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-600">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody id="logTableBody">
                    <!-- Data rows will be inserted here by JavaScript -->
                </tbody>
            </table>

            <div id="pagination" class="flex justify-between items-center mt-4">
                <div id="paginationInfo" class="text-sm text-gray-600"></div>
                <div class="flex space-x-2">
                    <button id="prevPage"
                        class="px-4 py-2 bg-gray-300 text-gray-600 rounded hover:bg-gray-400">Prev</button>
                    <button id="nextPage"
                        class="px-4 py-2 bg-gray-300 text-gray-600 rounded hover:bg-gray-400">Next</button>
                </div>
            </div>
        </section>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        const totalPengajuan = <?php echo $totalPengajuan; ?>;
        const pengajuanDisetujui = <?php echo $pengajuanDisetujui; ?>;
        const pengajuanTertunda = <?php echo $pengajuanTertunda; ?>;
        const pengajuanDitolak = <?php echo $pengajuanDitolak; ?>;

        // Hitung persentase
        const approvedPercentage = (pengajuanDisetujui / totalPengajuan * 100).toFixed(2);
        const pendingPercentage = (pengajuanTertunda / totalPengajuan * 100).toFixed(2);
        const rejectedPercentage = (pengajuanDitolak / totalPengajuan * 100).toFixed(2);

        // Tampilkan persentase
        document.getElementById('approvedPercentage').innerText = approvedPercentage + '%';
        document.getElementById('pendingPercentage').innerText = pendingPercentage + '%';
        document.getElementById('rejectedPercentage').innerText = rejectedPercentage + '%';

        // Inisialisasi chart
        const ctx = document.getElementById('pengajuanChart').getContext('2d');
        const pengajuanChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Pengajuan Disetujui', 'Pengajuan Tertunda', 'Pengajuan Ditolak'],
                datasets: [{
                    label: 'Persentase Pengajuan',
                    data: [pengajuanDisetujui, pengajuanTertunda, pengajuanDitolak],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.9)',
                        'rgba(245, 158, 11, 0.9)',
                        'rgba(239, 68, 68, 0.9)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' pengajuan';
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const riwayat = <?php echo json_encode($riwayat); ?>;
        const itemsPerPage = 10;
        let currentPage = 1;

        function renderTable(page) {
            const tableBody = document.getElementById('logTableBody');
            const paginationInfo = document.getElementById('paginationInfo');
            tableBody.innerHTML = '';

            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginatedItems = riwayat.slice(start, end);

            paginatedItems.forEach((activity, index) => {
                const row = document.createElement('tr');
                row.classList.add('border-b', 'border-gray-200');

                // Kondisi untuk menampilkan status dengan ikon dan warna
                let statusHTML = '';
                if (activity.status.toLowerCase() === 'disetujui') {
                    statusHTML = '<span class="text-green-500"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>' + activity.status + '</span>';
                } else if (activity.status.toLowerCase() === 'ditolak') {
                    statusHTML = '<span class="text-red-500"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>' + activity.status + '</span>';
                } else {
                    // Untuk status pending, gunakan ikon animasi berputar
                    statusHTML = '<span class="text-blue-500"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v2m0 12v2m8-10h2m-18 0H2m15.364-4.636l1.414 1.414M6.636 18.364l-1.414-1.414M18.364 18.364l-1.414 1.414M6.636 6.636L5.222 5.222" /></svg>' + activity.status + '</span>';
                }

                row.innerHTML = `
                <td class="px-4 py-2">${start + index + 1}</td>
                <td class="px-4 py-2">${activity.nm_pengaju}</td>
                <td class="px-4 py-2">${activity.nm_divisi}</td>
                <td class="px-4 py-2">${statusHTML}</td>
            `;
                tableBody.appendChild(row);
            });

            // Update pagination info
            const totalPages = Math.ceil(riwayat.length / itemsPerPage);
            paginationInfo.innerText = `Halaman ${page} dari ${totalPages}`;

            // Disable/enable pagination buttons
            document.getElementById('prevPage').disabled = page === 1;
            document.getElementById('nextPage').disabled = end >= riwayat.length;
        }

        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable(currentPage);
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            const totalPages = Math.ceil(riwayat.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable(currentPage);
            }
        });

        // Initial render
        renderTable(currentPage);
    </script>



</body>

</html>