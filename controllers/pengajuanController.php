<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$pdo = getPDOInstance();

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Menghandle aksi approve pengajuan
    if (isset($_POST['action']) && $_POST['action'] === 'approve' && isset($_POST['id_pengajuan'])) {
        $idPengajuan = $_POST['id_pengajuan'];

        try {
            // Update status pengajuan menjadi 'Disetujui'
            $stmt = $pdo->prepare("UPDATE pengajuan SET status = 'Disetujui' WHERE id_pengajuan = ?");
            $stmt->execute([$idPengajuan]);

            header("Location: ../index.php?page=totalpengajuan");
            exit;
        } catch (PDOException $e) {
            die("Failed to approve pengajuan: " . $e->getMessage());
        }

        // Menghandle aksi untuk menambah pengajuan sparepart
    } else if (isset($_POST['nm_barang'], $_POST['jumlah'], $_POST['keterangan'], $_POST['kategori'])) {
        // Mengambil id_divisi dan nm_pengaju dari sesi pengguna
        $id_divisi = $_SESSION['id_divisi'] ?? null;  // Mengambil divisi dari sesi pengguna
        $nm_barang = $_POST['nm_barang'];
        $jumlah = $_POST['jumlah'];
        $keterangan = $_POST['keterangan'];
        $nm_pengaju = $_SESSION['nm_pengguna'] ?? null;
        $kategori = $_POST['kategori']; // Menambahkan kategori ke dalam pengajuan

        // Pastikan semua data valid sebelum melakukan penyimpanan
        if ($id_divisi && $nm_barang && $jumlah && $nm_pengaju && $keterangan && $kategori) {
            try {
                // Menyimpan pengajuan baru
                $stmt = $pdo->prepare("INSERT INTO pengajuan (id_divisi, nm_barang, jumlah, tgl_pengajuan, status, nm_pengaju, keterangan) 
                                       VALUES (:id_divisi, :nm_barang, :jumlah, NOW(), 'Pending', :nm_pengaju, :keterangan)");
                $stmt->execute([
                    ':id_divisi' => $id_divisi,
                    ':nm_barang' => $nm_barang,
                    ':jumlah' => $jumlah,
                    ':nm_pengaju' => $nm_pengaju,
                    ':keterangan' => $keterangan
                ]);

                // Update kategori sparepart jika diperlukan
                $stmt = $pdo->prepare("UPDATE sparepart SET kategori = :kategori WHERE nm_sparepart = :nm_barang");
                $stmt->execute([
                    ':kategori' => $kategori,
                    ':nm_barang' => $nm_barang
                ]);

                header("Location: ../index.php?page=totalpengajuan");
                exit;
            } catch (PDOException $e) {
                // Menangani error saat insert data
                header("Location: ../views/404.php");
                exit;
            }
        } else {
            // Jika data tidak lengkap, redirect ke halaman error
            header("Location: ../views/404.php");
            exit;
        }

        // Menghandle aksi untuk menghapus pengajuan
    } else if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id_pengajuan'])) {
        $idPengajuan = $_POST['id_pengajuan'];

        try {
            // Menghapus pengajuan berdasarkan ID
            $stmt = $pdo->prepare("DELETE FROM pengajuan WHERE id_pengajuan = ?");
            $stmt->execute([$idPengajuan]);

            header("Location: ../index.php?page=totalpengajuan");
            exit;
        } catch (PDOException $e) {
            // Menangani error saat delete data
            die("Failed to delete pengajuan: " . $e->getMessage());
        }

    } else {
        // Jika aksi tidak dikenali, redirect ke halaman error
        header("Location: ../views/404.php");
        exit;
    }

} else {
    // Jika request method bukan POST, redirect ke halaman error
    header("Location: ../views/404.php");
    exit;
}

// Jika request method adalah GET dan ada id_pengajuan, ambil data pengajuan beserta kategori
if (isset($_GET['id_pengajuan'])) {
    $id_pengajuan = $_GET['id_pengajuan'];

    try {
        // Query untuk mengambil data pengajuan, termasuk kategori
        $stmt = $pdo->prepare("SELECT p.*, k.nama AS nm_kategori 
                               FROM pengajuan p 
                               JOIN sparepart s ON p.nm_barang = s.nm_sparepart
                               JOIN kategori k ON s.kategori = k.id_kategori
                               WHERE p.id_pengajuan = ?");
        $stmt->execute([$id_pengajuan]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Data pengajuan berhasil diambil, lanjutkan ke tampilan atau proses lainnya
            $_SESSION['pengajuan'] = $row;
            header("Location: ../views/detail_pengajuan.php");
            exit;
        } else {
            // Jika tidak ada data pengajuan ditemukan
            header("Location: ../views/404.php");
            exit;
        }
    } catch (PDOException $e) {
        die("Failed to fetch pengajuan data: " . $e->getMessage());
    }
}
?>