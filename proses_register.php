<?php
session_start(); // Memulai session
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        global $pdo;

        // Cari pengguna berdasarkan email
        $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifikasi password dan cek apakah pengguna aktif
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id_pengguna'];
            $_SESSION['email'] = $email;
            $_SESSION['nm_pengguna'] = $user['nm_pengguna'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id_divisi'] = $user['id_divisi']; // Simpan id_divisi dalam sesi

            header("Location: index.php?page=dashboard");
            exit;
        } else {
            $_SESSION['error'] = "Email atau password salah, atau akun tidak aktif.";
            header("Location: login.php"); // Kembali ke login.php dengan error
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Terjadi kesalahan pada database: " . $e->getMessage();
        header("Location: login.php"); // Kembali ke login.php dengan error
        exit;
    }
}
?>