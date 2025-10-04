<?php
require_once __DIR__ . '/../config/database.php';

if (isset($_POST['kategori'])) {
    $kategoriId = $_POST['kategori'];

    // Ambil daftar sparepart berdasarkan kategori yang dipilih
    $stmt = $pdo->prepare("SELECT * FROM sparepart WHERE kategori = :kategoriId");
    $stmt->execute(['kategoriId' => $kategoriId]);
    $spareparts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mengembalikan data dalam format JSON
    echo json_encode($spareparts);
}
?>