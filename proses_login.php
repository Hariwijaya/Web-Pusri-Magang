<?php
session_start(); // Memulai session
require_once 'config/database.php'; // Pastikan file ini sudah ada dan terhubung ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form login
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        global $pdo; // Pastikan PDO sudah terhubung dengan database

        // Cari pengguna berdasarkan email
        $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifikasi apakah email ditemukan dan password sesuai
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id_pengguna'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nm_pengguna'] = $user['nm_pengguna'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id_divisi'] = $user['id_divisi']; // Simpan divisi dalam sesi

            // Redirect ke halaman dashboard
            header("Location: index.php?page=dashboard");
            exit;
        } else {
            $_SESSION['error'] = "Email atau password salah.";
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