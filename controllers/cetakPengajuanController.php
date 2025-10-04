<?php

$id_permintaan = isset($_GET['id_permintaan']) ? $_GET['id_permintaan'] : null;

if ($id_permintaan) {

    $stmt = $pdo->prepare("SELECT * FROM permintaan WHERE id_permintaan = ?");
    $stmt->execute([$id_permintaan]);
    $detail = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$detail) {
        die("Pengajuan tidak ditemukan.");
    }


} else {
    die("ID pengajuan tidak tersedia.");
}
?>