<?php
require_once __DIR__ . '/../config/database.php';

// Fungsi untuk mengambil daftar pengguna
function getPenggunaList()
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT p.*, d.nm_divisi FROM pengguna p LEFT JOIN divisi d ON p.id_divisi = d.id_divisi");
    $stmt->execute();
    $penggunas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$penggunas) {
        return [];
    }

    return $penggunas;
}

// Fungsi untuk menghapus pengguna
function deletePengguna($id_pengguna)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM pengguna WHERE id_pengguna = ?");
    $stmt->execute([$id_pengguna]);
}

// Fungsi untuk menambah pengguna baru
function addPengguna($username, $nm_pengguna, $email, $id_divisi, $password, $role)
{
    global $pdo;

    // Cek apakah email sudah ada
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pengguna WHERE email = ?");
    $stmt->execute([$email]);
    $emailExists = $stmt->fetchColumn();

    if ($emailExists > 0) {
        return "Email sudah terdaftar, silakan gunakan email lain.";
    } else {
        // Jika email belum ada, simpan data pengguna baru dengan tanggal buat
        $stmt = $pdo->prepare("INSERT INTO pengguna (username, nm_pengguna, email, id_divisi, password, role, tgl_buat) 
                               VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$username, $nm_pengguna, $email, $id_divisi, password_hash($password, PASSWORD_BCRYPT), $role]);
        return true;
    }
}

// Fungsi untuk mengedit pengguna
function editPengguna($id_pengguna, $username, $nm_pengguna, $email, $id_divisi, $role)
{
    global $pdo;

    // Update data pengguna
    $stmt = $pdo->prepare("UPDATE pengguna SET username = ?, nm_pengguna = ?, email = ?, id_divisi = ?, role = ? WHERE id_pengguna = ?");
    $stmt->execute([$username, $nm_pengguna, $email, $id_divisi, $role, $id_pengguna]);
}

// Proses Hapus Pengguna
if (isset($_GET['delete'])) {
    $id_pengguna = $_GET['delete'];
    deletePengguna($id_pengguna);
    header('Location: index.php?page=datapengguna');
    exit();
}

// Proses Tambah Pengguna
if (isset($_POST['add_pengguna'])) {
    $username = $_POST['username'];
    $nm_pengguna = $_POST['nm_pengguna'];
    $email = $_POST['email'];
    $id_divisi = $_POST['id_divisi'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $result = addPengguna($username, $nm_pengguna, $email, $id_divisi, $password, $role);
    if ($result === true) {
        header('Location: ../index.php?page=datapengguna');
        exit();
    } else {
        $error_message = $result;
    }
}

// Proses Edit Pengguna
if (isset($_POST['edit_pengguna'])) {
    $id_pengguna = $_POST['id_pengguna'];
    $username = $_POST['username'];
    $nm_pengguna = $_POST['nm_pengguna'];
    $email = $_POST['email'];
    $id_divisi = $_POST['id_divisi'];
    $role = $_POST['role'];

    editPengguna($id_pengguna, $username, $nm_pengguna, $email, $id_divisi, $role);
    header('Location: ../index.php?page=datapengguna');
    exit();
}

// Ambil Daftar Pengguna untuk ditampilkan
$penggunas = getPenggunaList();
?>