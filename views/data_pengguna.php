<?php
require_once 'partials/navbar.php';  // Pastikan path sesuai dengan lokasi navbar.php
require_once '../penjualan/controllers/data_penggunaController.php';  // Mengimpor controller

// Ambil role dari session
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body class="bg-gray-100">
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

    </div>
    <div id="mainContent" class="ml-64 p-6 transition-all duration-300">
        <h1 class="text-3xl font-bold mb-6">Data Pengguna</h1>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error_message)): ?>
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Tombol Tambah Pengguna -->
        <button onclick="document.getElementById('addUserModal').classList.remove('hidden')"
            class="bg-gray-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mb-4">
            Tambah Pengguna
        </button>

        <!-- Tabel Daftar Pengguna -->
        <table class="min-w-full bg-white rounded-lg shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-200">Username</th>
                    <th class="py-2 px-4 bg-gray-200">Nama</th>
                    <th class="py-2 px-4 bg-gray-200">Email</th>
                    <th class="py-2 px-4 bg-gray-200">Departemen</th>
                    <th class="py-2 px-4 bg-gray-200">Tanggal Buat</th>
                    <th class="py-2 px-4 bg-gray-200">Role</th>
                    <th class="py-2 px-4 bg-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($penggunas as $pengguna): ?>
                    <tr>
                        <td class="py-2 px-4"><?php echo $pengguna['username']; ?></td>
                        <td class="py-2 px-4"><?php echo $pengguna['nm_pengguna']; ?></td>
                        <td class="py-2 px-4"><?php echo $pengguna['email']; ?></td>
                        <td class="py-2 px-4"><?php echo $pengguna['nm_divisi']; ?></td>
                        <td class="py-2 px-4"><?php echo $pengguna['tgl_buat']; ?></td>
                        <td class="py-2 px-4"><?php echo ucfirst($pengguna['role']); ?></td>

                        <td class="py-2 px-4">
                            <a href="index.php?page=datapengguna&edit=<?php echo $pengguna['id_pengguna']; ?>"
                                class="text-blue-500 hover:text-blue-700">Edit</a>
                            <a href="index.php?page=datapengguna&delete=<?php echo $pengguna['id_pengguna']; ?>"
                                class="text-red-500 hover:text-red-700 ml-2">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modal Tambah Pengguna -->
        <div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-2xl font-bold mb-4">Tambah Pengguna Baru</h2>

                <form action="controllers/data_penggunaController.php" method="POST">
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-md"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="nm_pengguna" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="nm_pengguna" name="nm_pengguna"
                            class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="id_divisi" class="block text-sm font-medium text-gray-700">Departemen</label>
                        <select id="id_divisi" name="id_divisi" required
                            class="w-full border-none focus:outline-none bg-white">
                            <option value="" disabled selected>Pilih Departemen</option>
                            <?php
                            require_once 'config/database.php';
                            $stmt = $pdo->query("SELECT id_divisi, nm_divisi FROM divisi");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['id_divisi']}'>{$row['nm_divisi']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-md"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select id="role" name="role" required class="w-full border-none focus:outline-none bg-white">
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="admin_divisi">Admin Departemen</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="approval">Approval</option>
                        </select>
                    </div>


                    <div class="mb-4">
                        <a href="index.php?page=datapengguna"
                            class="bg-gray-700 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Kembali
                        </a>
                        <button type="submit" name="add_pengguna"
                            class="bg-gray-700 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Pengguna -->
        <?php if (isset($_GET['edit'])): ?>
            <?php
            $id_pengguna = $_GET['edit'];
            $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE id_pengguna = ?");
            $stmt->execute([$id_pengguna]);
            $pengguna = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                    <h2 class="text-2xl font-bold mb-4">Edit Pengguna</h2>
                    <form action="controllers/data_penggunaController.php" method="POST">
                        <input type="hidden" name="id_pengguna" value="<?php echo $pengguna['id_pengguna']; ?>">

                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-md"
                                value="<?php echo $pengguna['username']; ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="nm_pengguna" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" id="nm_pengguna" name="nm_pengguna"
                                class="w-full px-4 py-2 border rounded-md" value="<?php echo $pengguna['nm_pengguna']; ?>"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-md"
                                value="<?php echo $pengguna['email']; ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="id_divisi" class="block text-sm font-medium text-gray-700">Departemen</label>
                            <select id="id_divisi" name="id_divisi" required
                                class="w-full border-none focus:outline-none bg-white">
                                <option value="" disabled>Pilih Departemen</option>
                                <?php
                                $stmt = $pdo->query("SELECT id_divisi, nm_divisi FROM divisi");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = $row['id_divisi'] == $pengguna['id_divisi'] ? 'selected' : '';
                                    echo "<option value='{$row['id_divisi']}' $selected>{$row['nm_divisi']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select id="role" name="role" required class="w-full border-none focus:outline-none bg-white">
                                <option value="admin_divisi" <?php echo $pengguna['role'] == 'admin_divisi' ? 'selected' : ''; ?>>Admin Departemen</option>
                                <option value="super_admin" <?php echo $pengguna['role'] == 'super_admin' ? 'selected' : ''; ?>>Super Admin</option>
                                <option value="approval" <?php echo $pengguna['role'] == 'approval' ? 'selected' : ''; ?>>
                                    Approval</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <a href="index.php?page=datapengguna"
                                class="bg-gray-700 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Kembali
                            </a>
                            <button type="submit" name="edit_pengguna"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

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