<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Mendapatkan instance PDO
$pdo = getPDOInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action']) && $_GET['action'] === 'update') {
        // Menangani update pengajuan
        $id_pengajuan = $_POST['id_pengajuan'] ?? null;
        $id_divisi = $_SESSION['id_divisi']; // Ambil id_divisi dari session
        $nm_barang = $_POST['nm_barang'] ?? null;
        $jumlah = $_POST['jumlah'] ?? null;
        $keterangan = $_POST['keterangan'] ?? null;

        if ($id_pengajuan && $id_divisi && $nm_barang && $jumlah && $keterangan) {
            try {
                $stmt = $pdo->prepare("UPDATE pengajuan SET 
                    id_divisi = :id_divisi, 
                    nm_barang = :nm_barang, 
                    jumlah = :jumlah, 
                    keterangan = :keterangan, 
                    tgl_pengajuan = NOW() 
                    WHERE id_pengajuan = :id_pengajuan");

                $stmt->execute([
                    ':id_pengajuan' => $id_pengajuan,
                    ':id_divisi' => $id_divisi,
                    ':nm_barang' => $nm_barang,
                    ':jumlah' => $jumlah,
                    ':keterangan' => $keterangan
                ]);

                // Redirect ke halaman riwayat setelah berhasil
                header("Location: ../index.php?page=totalpengajuan");
                exit;
            } catch (PDOException $e) {
                // Redirect ke halaman error jika terjadi kesalahan
                die("Failed to update pengajuan: " . $e->getMessage());
            }
        } else {
            // Redirect ke halaman error jika data tidak lengkap
            header("Location: ../views/404.php");
            exit;
        }
    } else {
        // Redirect ke halaman error jika action tidak valid
        header("Location: ../views/404.php");
        exit;
    }
} else {
    // Redirect ke halaman error jika bukan request POST
    header("Location: ../views/404.php");
    exit;
}
?>