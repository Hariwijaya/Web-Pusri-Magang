<?php
require_once '../config/database.php';
require_once 'partials/navbar.php';

$role = $_SESSION['role'];
if ($role !== 'super_admin') {
    header('Location: /penjualan/index.php?page=dashboard');
    exit;
}

// Mendapatkan instance PDO
$pdo = getPDOInstance();

// Proses tambah kategori
$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'];

    try {
        $stmt = $pdo->prepare("INSERT INTO kategori (nama) VALUES (:nama)");
        $stmt->execute(['nama' => $nama_kategori]);
        $pesan = "Kategori berhasil ditambahkan!";
    } catch (PDOException $e) {
        $pesan = "Terjadi Kesalahan: " . $e->getMessage();
    }
}

// Proses hapus kategori
if (isset($_GET['hapus'])) {
    $kategori_id = $_GET['hapus'];
    try {
        // Cek apakah kategori masih digunakan
        $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM sparepart WHERE kategori = :kategori_id");
        $check_stmt->execute(['kategori_id' => $kategori_id]);
        $jumlah = $check_stmt->fetchColumn();

        if ($jumlah > 0) {
            $pesan = "Kategori tidak dapat dihapus karena masih digunakan oleh sparepart!";
        } else {
            $stmt = $pdo->prepare("DELETE FROM kategori WHERE id_kategori = :id");
            $stmt->execute(['id' => $kategori_id]);
            $pesan = "Kategori berhasil dihapus!";
        }
    } catch (PDOException $e) {
        $pesan = "Terjadi Kesalahan: " . $e->getMessage();
    }
}

// Ambil semua kategori
$stmt = $pdo->query("SELECT * FROM kategori ORDER BY nama");
$kategoris = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-center">Kelola Kategori Sparepart</h1>

            <?php if ($pesan): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo $pesan; ?>
                </div>
            <?php endif; ?>

            <!-- Form Tambah Kategori -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Tambah Kategori Baru</h2>
                <form method="POST" action="" class="flex gap-4">
                    <input type="text" name="nama_kategori" required
                        class="flex-1 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Masukkan nama kategori">
                    <button type="submit"
                        class="bg-gray-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Tambah
                    </button>
                </form>
            </div>

            <!-- Daftar Kategori -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">Daftar Kategori</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Nama Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($kategoris as $index => $kategori): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $index + 1 ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($kategori['nama']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="?hapus=<?= $kategori['id_kategori'] ?>"
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-6 text-center">
                <a href="/penjualan/views/daftar_sparepart.php"
                    class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali ke Daftar Sparepart
                </a>
            </div>
        </div>
    </div>
</body>

</html>