<?php

require_once __DIR__ . '/../config/database.php';

$pdo = getPDOInstance();

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'tambah') {
    // Menambah sparepart baru
    $nm_sparepart = $_POST['nm_sparepart'];
    $spesifikasi = $_POST['spesifikasi'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $tgl_diperbarui = date('Y-m-d H:i:s'); // Waktu saat sparepart diperbarui

    try {
        $stmt = $pdo->prepare("INSERT INTO sparepart (nm_sparepart, spesifikasi, stok, kategori, tgl_diperbarui) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nm_sparepart, $spesifikasi, $stok, $kategori, $tgl_diperbarui]);

        header("Location: ../views/daftar_sparepart.php");
        exit;
    } catch (PDOException $e) {
        die("Failed to add sparepart: " . $e->getMessage());
    }

} elseif ($action == 'edit') {
    // Mengedit sparepart
    $id_sparepart = $_POST['id_sparepart'];
    $nm_sparepart = $_POST['nm_sparepart'];
    $spesifikasi = $_POST['spesifikasi'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $tgl_diperbarui = date('Y-m-d H:i:s'); // Waktu saat sparepart diperbarui

    try {
        $stmt = $pdo->prepare("UPDATE sparepart 
                               SET nm_sparepart = ?, spesifikasi = ?, stok = ?, kategori = ?, tgl_diperbarui = ? 
                               WHERE id_sparepart = ?");
        $stmt->execute([$nm_sparepart, $spesifikasi, $stok, $kategori, $tgl_diperbarui, $id_sparepart]);

        header("Location: ../views/daftar_sparepart.php");
        exit;
    } catch (PDOException $e) {
        die("Failed to update sparepart: " . $e->getMessage());
    }

} elseif ($action == 'hapus') {
    // Menghapus sparepart
    $id_sparepart = $_POST['id_sparepart'];

    try {
        $stmt = $pdo->prepare("DELETE FROM sparepart WHERE id_sparepart = ?");
        $stmt->execute([$id_sparepart]);

        header("Location: ../views/daftar_sparepart.php");
        exit;
    } catch (PDOException $e) {
        die("Failed to delete sparepart: " . $e->getMessage());
    }

} else {
    // Menampilkan daftar sparepart
    try {
        $stmt = $pdo->prepare("SELECT * FROM sparepart");
        $stmt->execute();
        $spareparts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'views/daftar_sparepart.php';
    } catch (PDOException $e) {
        die("Failed to retrieve spareparts: " . $e->getMessage());
    }
}