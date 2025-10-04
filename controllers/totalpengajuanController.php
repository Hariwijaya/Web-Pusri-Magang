<?php
require_once __DIR__ . '/../config/database.php';

$pdo = getPDOInstance();

try {
    // Tambahkan variabel untuk filter bulan dan status
    $selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
    $selectedStatus = isset($_GET['status']) ? $_GET['status'] : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            $idPengajuan = $_POST['id_pengajuan'];

            if ($_POST['action'] === 'approve') {
                $stmt = $pdo->prepare("UPDATE pengajuan SET status = 'Disetujui' WHERE id_pengajuan = ?");
                $stmt->execute([$idPengajuan]);
                header("Location: ../index.php?page=totalpengajuan");
                exit;
            } elseif ($_POST['action'] === 'reject') {
                $stmt = $pdo->prepare("UPDATE pengajuan SET status = 'Ditolak' WHERE id_pengajuan = ?");
                $stmt->execute([$idPengajuan]);
                header("Location: ../index.php?page=totalpengajuan");
                exit;
            } elseif ($_POST['action'] === 'delete') {
                // Menghapus pengajuan dari database
                $stmt = $pdo->prepare("DELETE FROM pengajuan WHERE id_pengajuan = ?");
                $stmt->execute([$idPengajuan]);
                header("Location: ../index.php?page=totalpengajuan");
                exit;
            }
        }
    }

    // Query dimodifikasi untuk mendukung filter bulan dan status
    $query = "
    SELECT p.*, d.nm_divisi, s.nm_sparepart 
    FROM pengajuan p
    JOIN divisi d ON p.id_divisi = d.id_divisi
    JOIN sparepart s ON p.nm_barang = s.id_sparepart
    WHERE DATE_FORMAT(p.tgl_pengajuan, '%Y-%m') = :selectedMonth
    ";

    if (!empty($selectedStatus)) {
        $query .= " AND p.status = :selectedStatus";
    }

    $query .= " ORDER BY p.tgl_pengajuan DESC";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':selectedMonth', $selectedMonth);
    if (!empty($selectedStatus)) {
        $stmt->bindParam(':selectedStatus', $selectedStatus);
    }
    $stmt->execute();
    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Dapatkan daftar bulan yang tersedia untuk filter
    $stmtMonths = $pdo->prepare("
    SELECT DISTINCT DATE_FORMAT(tgl_pengajuan, '%Y-%m') as month
    FROM pengajuan
    ORDER BY month DESC
    ");
    $stmtMonths->execute();
    $availableMonths = $stmtMonths->fetchAll(PDO::FETCH_COLUMN);

    // Statistik untuk bulan yang dipilih
    $queryTotal = "
    SELECT COUNT(*) as total 
    FROM pengajuan 
    WHERE DATE_FORMAT(tgl_pengajuan, '%Y-%m') = :selectedMonth
    ";

    if (!empty($selectedStatus)) {
        $queryTotal .= " AND status = :selectedStatus";
    }

    $stmtTotal = $pdo->prepare($queryTotal);
    $stmtTotal->bindParam(':selectedMonth', $selectedMonth);
    if (!empty($selectedStatus)) {
        $stmtTotal->bindParam(':selectedStatus', $selectedStatus);
    }
    $stmtTotal->execute();
    $totalPengajuan = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

    $queryTertunda = "
    SELECT COUNT(*) as total 
    FROM pengajuan 
    WHERE status = 'Pending' AND DATE_FORMAT(tgl_pengajuan, '%Y-%m') = :selectedMonth
    ";

    if (!empty($selectedStatus)) {
        $queryTertunda .= " AND status = :selectedStatus";
    }

    $stmtTertunda = $pdo->prepare($queryTertunda);
    $stmtTertunda->bindParam(':selectedMonth', $selectedMonth);
    if (!empty($selectedStatus)) {
        $stmtTertunda->bindParam(':selectedStatus', $selectedStatus);
    }
    $stmtTertunda->execute();
    $pengajuanTertunda = $stmtTertunda->fetch(PDO::FETCH_ASSOC)['total'];

    $queryDisetujui = "
    SELECT COUNT(*) as total 
    FROM pengajuan 
    WHERE status = 'Disetujui' AND DATE_FORMAT(tgl_pengajuan, '%Y-%m') = :selectedMonth
    ";

    if (!empty($selectedStatus)) {
        $queryDisetujui .= " AND status = :selectedStatus";
    }

    $stmtDisetujui = $pdo->prepare($queryDisetujui);
    $stmtDisetujui->bindParam(':selectedMonth', $selectedMonth);
    if (!empty($selectedStatus)) {
        $stmtDisetujui->bindParam(':selectedStatus', $selectedStatus);
    }
    $stmtDisetujui->execute();
    $pengajuanDisetujui = $stmtDisetujui->fetch(PDO::FETCH_ASSOC)['total'];

    $queryDitolak = "
    SELECT COUNT(*) as total 
    FROM pengajuan 
    WHERE status = 'Ditolak' AND DATE_FORMAT(tgl_pengajuan, '%Y-%m') = :selectedMonth
    ";

    if (!empty($selectedStatus)) {
        $queryDitolak .= " AND status = :selectedStatus";
    }

    $stmtDitolak = $pdo->prepare($queryDitolak);
    $stmtDitolak->bindParam(':selectedMonth', $selectedMonth);
    if (!empty($selectedStatus)) {
        $stmtDitolak->bindParam(':selectedStatus', $selectedStatus);
    }
    $stmtDitolak->execute();
    $pengajuanDitolak = $stmtDitolak->fetch(PDO::FETCH_ASSOC)['total'];

} catch (PDOException $e) {
    die("Failed to fetch riwayat: " . $e->getMessage());
}
?>