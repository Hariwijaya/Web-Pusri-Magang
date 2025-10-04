<?php

require_once __DIR__ . '/../config/database.php';

// Pastikan ada ID yang diterima dari parameter GET
if (isset($_GET['id'])) {
    $id_sparepart = $_GET['id'];

    // Mendapatkan instance PDO
    $pdo = getPDOInstance();

    // Menyiapkan query untuk menghapus sparepart
    $stmt = $pdo->prepare("DELETE FROM sparepart WHERE id_sparepart = :id_sparepart");
    $stmt->bindParam(':id_sparepart', $id_sparepart, PDO::PARAM_INT);

    // Eksekusi query dan periksa apakah berhasil
    if ($stmt->execute()) {
        header("Location: daftar_sparepart.php?status=success");
        exit;
    } else {
        header("Location: daftar_sparepart.php?status=error");
        exit;
    }
} else {
    // Jika tidak ada ID yang diterima
    header("Location: daftar_sparepart.php?status=invalid");
    exit;
}
?>