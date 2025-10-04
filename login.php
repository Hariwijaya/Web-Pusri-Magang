<?php
session_start(); // Memulai session agar bisa mengambil pesan error
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logopusri">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/login.css">
</head>

<body class="flex h-screen bg-gray-100">
    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white relative">
        <div class="absolute top-0 w-full h-4 bg-gray-800 p-4"></div>
        <h2 class="text-2xl font-bold mb-8 mt-4">Login</h2>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($_SESSION['error']) && $_SESSION['error'] !== ''): ?>
            <div class="w-1/2 bg-red-100 text-red-700 p-4 rounded mb-4">
                <?php
                echo htmlspecialchars($_SESSION['error']); // Menampilkan pesan error
                unset($_SESSION['error']); // Menghapus pesan error setelah ditampilkan
                ?>
            </div>
        <?php endif; ?>

        <form action="proses_login.php" method="POST" class="w-1/2">
            <div class="mb-4 flex items-center border border-gray-300 rounded px-3 py-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 12V8a4 4 0 10-8 0v4H3l7 7 7-7h-5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12l-9 9-9-9" />
                </svg>

                <input type="email" id="email" name="email" placeholder="Email" required
                    class="w-full border-none focus:outline-none">
            </div>
            <div class="mb-6 flex items-center border border-gray-300 rounded px-3 py-2 relative">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11V7a4 4 0 10-8 0v4m12-2h4a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V13a2 2 0 012-2h4m4 4v2m0-2a1 1 0 100 2" />
                </svg>
                <input type="password" id="password" name="password" placeholder="Password" required
                    class="w-full border-none focus:outline-none">
                <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 focus:outline-none">
                    <svg id="eye-icon" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.942 5 12 5c4.059 0 8.269 2.943 9.542 7-1.273 4.057-5.483 7-9.542 7-4.058 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </button>
            </div>
            <button type="submit"
                class="w-full bg-gray-800 p-4 text-white font-bold py-2 px-4 rounded hover:bg-gray-500 p-4">
                Login
            </button>
        </form>
    </div>
    <div class="hidden lg:flex w-1/2 flex-col justify-center items-center bg-gray-800 p-4 relative">
        <img src="https://sikp.pusri.co.id/static/media/logo-white.b054006e16dac76de809.png" alt="Logo"
            class="w-1/2 mb-8">
        <div class="random-boxes box-1"></div>
        <div class="random-boxes box-2"></div>
        <div class="random-boxes box-3"></div>
        <div class="random-boxes box-4"></div>
    </div>
    <script src="js/login.js"></script>
</body>

</html>