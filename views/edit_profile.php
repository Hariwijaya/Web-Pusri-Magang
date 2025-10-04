<?php
session_start();

// Ambil data user dari session
$user_id = $_SESSION['user_id']; // Ambil user_id dari session

require_once __DIR__ . '/../config/database.php';

// Query untuk mengambil data pengguna
$query_profile = "SELECT nm_pengguna, email, foto_profil, password FROM pengguna WHERE id_pengguna = :user_id";
$stmt_profile = $pdo->prepare($query_profile);
$stmt_profile->execute(['user_id' => $user_id]);
$user = $stmt_profile->fetch();

// Variabel untuk menentukan apakah redirect diperlukan
$should_redirect = false;

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nm_pengguna = $_POST['nm_pengguna'];
    $email = $_POST['email'];
    $profile_picture = $user['foto_profil']; // Gambar default saat ini

    // Cek apakah ada file yang diupload
    if (!empty($_FILES['foto_profil']['name'])) {
        $file_name = $_FILES['foto_profil']['name'];
        $file_tmp = $_FILES['foto_profil']['tmp_name'];
        $upload_dir = '../assets/uploads/'; // Folder tempat menyimpan gambar

        if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            echo "Gambar berhasil di-upload!";
            $profile_picture = $upload_dir . $file_name;
        } else {
            echo "Gagal meng-upload gambar.";
        }
    }

    // Jika password lama dan password baru diisi
    if (!empty($_POST['password_lama']) && !empty($_POST['password_baru'])) {
        $password_lama = $_POST['password_lama'];
        $password_baru = $_POST['password_baru'];

        // Verifikasi password lama
        if (password_verify($password_lama, $user['password'])) {
            // Hash password baru
            $password_baru_hashed = password_hash($password_baru, PASSWORD_DEFAULT);

            // Update password baru ke database
            $query_update_password = "UPDATE pengguna SET password = :password_baru WHERE id_pengguna = :user_id";
            $stmt_update_password = $pdo->prepare($query_update_password);
            $stmt_update_password->execute([
                'password_baru' => $password_baru_hashed,
                'user_id' => $user_id
            ]);
        } else {
            // Simpan pesan error di session
            $_SESSION['error_message'] = 'Password lama salah';
        }
    }

    // Query untuk memperbarui data pengguna (tanpa perubahan password)
    $query_update = "UPDATE pengguna SET nm_pengguna = :nm_pengguna, email = :email, foto_profil = :foto_profil WHERE id_pengguna = :user_id";
    $stmt_update = $pdo->prepare($query_update);
    $stmt_update->execute([
        'nm_pengguna' => $nm_pengguna,
        'email' => $email,
        'foto_profil' => $profile_picture,
        'user_id' => $user_id
    ]);

    // Set variabel untuk redirect jika tidak ada error
    if (!isset($_SESSION['error_message'])) {
        $should_redirect = true;
    }
}

// Redirect ke halaman profil jika tidak ada error dan update berhasil
if ($should_redirect) {
    header('Location: profile_akun.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .edit-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="edit-container">
            <h2 class="text-center">Edit Profil</h2>

            <!-- Menampilkan pesan error jika ada -->
            <?php
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                // Hapus pesan error setelah ditampilkan
                unset($_SESSION['error_message']);
            }
            ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3 text-center">
                    <img src="<?php echo $user['foto_profil'] ? $user['foto_profil'] : '/penjualan/assets/uploads/default-avatar.jpg'; ?>"
                        alt="Profile Picture" class="profile-picture">
                </div>

                <div class="mb-3">
                    <label for="nm_pengguna" class="form-label">Nama Pengguna</label>
                    <input type="text" class="form-control" id="nm_pengguna" name="nm_pengguna"
                        value="<?php echo htmlspecialchars($user['nm_pengguna']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="foto_profil" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" id="foto_profil" name="foto_profil">
                </div>

                <!-- Tambahkan Bagian Ubah Password -->
                <div class="mb-3">
                    <label for="password_lama" class="form-label">Password Lama</label>
                    <input type="password" class="form-control" id="password_lama" name="password_lama"
                        placeholder="Masukkan password lama">
                </div>

                <div class="mb-3">
                    <label for="password_baru" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="password_baru" name="password_baru"
                        placeholder="Masukkan password baru">
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                <a href="profile_akun.php" class="btn btn-secondary w-100 mt-2">Batal</a>
            </form>
        </div>
    </div>

</body>

</html>