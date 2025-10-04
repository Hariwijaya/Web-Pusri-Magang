<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style>
        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Fixed Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-white p-4 shadow-md z-10">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Placeholder for alignment -->
            <div></div>

            <!-- User info (aligned to the right) -->
            <div class="relative flex items-center space-x-4">
                <!-- User Name -->
                <span class="text-gray-700 font-semibold cursor-pointer"
                    id="userName"><?php echo htmlspecialchars($_SESSION['nm_pengguna']); ?></span>
                <!-- User Logo (Bootstrap Icon) -->
                <i class="bi bi-person-circle text-gray-700 text-2xl cursor-pointer" id="userIcon"></i>

                <!-- Dropdown Menu -->
                <div
                    class="dropdown-menu absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg">
                    <ul>
                        <li>
                            <a href="/penjualan/index.php?page=logout"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="pt-16">
        <!-- Isi konten halaman Anda di sini -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userDropdown = document.querySelector('.relative');
            const dropdownMenu = userDropdown.querySelector('.dropdown-menu');
            const userIcon = document.getElementById('userIcon');
            const userName = document.getElementById('userName');

            function toggleDropdown() {
                dropdownMenu.classList.toggle('show');
            }

            userIcon.addEventListener('click', toggleDropdown);
            userName.addEventListener('click', toggleDropdown);

            document.addEventListener('click', function (event) {
                if (!userDropdown.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>
</body>

</html>