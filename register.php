<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logopusri">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/login.css">
</head>

<body class="flex h-screen bg-gray-100">
    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white relative">
        <div class="absolute top-0 w-full h-4 bg-gray-800 p-4"></div>
        <h2 class="text-2xl font-bold mb-8 mt-4">Register</h2>

        <?php if (isset($error)): ?>
            <div class="w-1/2 bg-red-100 text-red-700 p-4 rounded mb-4">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="proses_register.php" method="POST" class="w-1/2">
            <div class="mb-4 flex items-center border border-gray-300 rounded px-3 py-2">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A9.973 9.973 0 0112 16a9.973 9.973 0 016.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0zM12 2a10 10 0 100 20 10 10 0 000-20z">
                    </path>
                </svg>
                <input type="text" id="username" name="username" placeholder="Username" required
                    class="w-full border-none focus:outline-none">
            </div>
            <div class="mb-4 flex items-center border border-gray-300 rounded px-3 py-2">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 12a4 4 0 01-8 0M8 9v1a4 4 0 008 0V9M6 12a6 6 0 0112 0M18 9v1a6 6 0 00-12 0V9m0 3h12">
                    </path>
                </svg>
                <input type="email" id="email" name="email" placeholder="Email" required
                    class="w-full border-none focus:outline-none">
            </div>
            <div class="mb-4 flex items-center border border-gray-300 rounded px-3 py-2">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9 6 9-6m-9 6v8">
                    </path>
                </svg>
                <input type="text" id="nm_pengguna" name="nm_pengguna" placeholder="Nama Lengkap" required
                    class="w-full border-none focus:outline-none">
            </div>
            <div class="mb-4 flex items-center border border-gray-300 rounded px-3 py-2">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9 6 9-6m-9 6v8">
                    </path>
                </svg>
                <select id="id_divisi" name="id_divisi" required class="w-full border-none focus:outline-none bg-white">
                    <option value="" disabled selected>Pilih Departemen</option>
                    <?php

                    require_once 'config/database.php';
                    $stmt = $pdo->query("SELECT id_divisi, nm_divisi FROM divisi");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id_divisi']}'>{$row['nm_divisi']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-6 flex items-center border border-gray-300 rounded px-3 py-2 relative">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 12a3 3 0 01-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.942 5 12 5c4.059 0 8.269 2.943 9.542 7-1.273 4.057-5.483 7-9.542 7-4.058 0-8.268-2.943-9.542-7z">
                    </path>
                </svg>
                <input type="password" id="password" name="password" placeholder="Password" required
                    class="w-full border-none focus:outline-none">
            </div>

            <div class="mb-6 flex items-center border border-gray-300 rounded px-3 py-2">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M12 9v6"></path>
                </svg>
                <select id="role" name="role" required class="w-full border-none focus:outline-none bg-white">
                    <option value="" disabled selected>Select Role</option>
                    <option value="super_admin">Admin Pengelola</option>
                    <option value="admin_divisi">Admin Divisi</option>
                    <option value="approval">Approval</option>
                </select>
            </div>
            <button type="submit"
                class="w-full bg-gray-800 p-4 text-white font-bold py-2 px-4 rounded hover:bg-gray-500">
                Register
            </button>

            <div class="mt-6 text-center">
                <p class="text-gray-600">Sudah punya akun? <a href="login.php"
                        class="text-blue-500 hover:underline">Login disini</a></p>
            </div>
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
</body>

</html>