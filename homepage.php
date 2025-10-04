<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Pengajuan Sparepart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .header-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('https://ik.trn.asia/uploads/2023/02/1675660821165.jpeg') center no-repeat;
            background-size: cover;
            background-blend-mode: darken;
        }

        .text-shadow {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .role-card {
            background-color: #f5f5f5;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        .bg-gradient {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
        }

        .content-spacing {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            padding-top: 3rem;
            padding-bottom: 3rem;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Header Section -->
    <header class="header-bg text-white py-24">
        <div class="container mx-auto text-center">
            <img src="https://sikp.pusri.co.id/static/media/logo-white.b054006e16dac76de809.png" alt="Logo"
                class="w-1/4 mx-auto mb-6">
            <h1 class="text-4xl font-bold text-shadow">Aplikasi Pengajuan Sparepart</h1>
            <p class="mt-4 text-lg max-w-2xl mx-auto text-shadow">Aplikasi untuk mengelola pengajuan sparepart di PT
                Pupuk
                Sriwidjaja Palembang.</p>
            <a href="login.php"
                class="mt-8 inline-block bg-white text-blue-600 font-semibold px-6 py-3 rounded-full hover:bg-gray-100 transition duration-300">Masuk
                ke Aplikasi</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto my-16 p-6">
        <!-- Introduction Section -->
        <section class="text-center mb-16">
            <h2 class="text-3xl font-semibold text-gray-800">Tentang Aplikasi</h2>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                Aplikasi ini memudahkan pengelolaan dan persetujuan pengajuan sparepart.
            </p>
        </section>

        <!-- Role Cards Section -->
        <section>
            <h2 class="text-3xl font-semibold text-gray-800 text-center mb-10">Peran dan Tata Cara Penggunaan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 content-spacing">

                <!-- Super Admin Role -->
                <div class="role-card p-6 rounded-lg shadow-lg">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-700 mb-4">Admin Pengelola</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Mengelola seluruh sistem, termasuk data sparepart, pengguna, dan pengajuan departemen.
                        </p>
                        <h4 class="text-xl font-semibold text-gray-700 mt-4">Tata Cara Penggunaan:</h4>
                        <ul class="list-disc text-left text-gray-600 mt-2 ml-4">
                            <li>Login sebagai Super Admin.</li>
                            <li>Kelola data sparepart dan pengguna melalui fitur yang tersedia seperti, data
                                pengguna, total pengajuan, daftar sparepart dan menambah pengguna di register.</li>
                            <li>Setiap pengajuan departemen dapat dilihat.</li>
                        </ul>
                    </div>
                </div>

                <!-- Admin departemen Role -->
                <div class="role-card p-6 rounded-lg shadow-lg">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-700 mb-4">Admin departemen</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Mengelola pengajuan sparepart departemen.
                        </p>
                        <h4 class="text-xl font-semibold text-gray-700 mt-4">Tata Cara Penggunaan:</h4>
                        <ul class="list-disc text-left text-gray-600 mt-2 ml-4">
                            <li>Login sebagai Admin departemen.</li>
                            <li>Buat pengajuan sparepart sesuai kebutuhan departemen.</li>
                            <li>Periksa status pengajuan di dashboard departemen.</li>
                        </ul>
                    </div>
                </div>

                <!-- Admin Approval Role -->
                <div class="role-card p-6 rounded-lg shadow-lg">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-700 mb-4">Petugas Pengajuan (Approval)</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Menyetujui pengajuan sparepart berdasarkan kebutuhan dan stok yang tersedia.
                        </p>
                        <h4 class="text-xl font-semibold text-gray-700 mt-4">Tata Cara Penggunaan:</h4>
                        <ul class="list-disc text-left text-gray-600 mt-2 ml-4">
                            <li>Login sebagai Admin Approval.</li>
                            <li>Periksa pengajuan sparepart yang masuk.</li>
                            <li>Tinjau dan setujui pengajuan yang memenuhi kriteria.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Call to Action Section -->
    <!-- <section class="bg-gradient py-16 text-white text-center">
        <h2 class="text-3xl font-bold">Mulai Pengajuan Sparepart Anda</h2>
        <p class="mt-4 text-lg">Masuk untuk memulai proses pengajuan sparepart.</p>
        <a href="login.php"
            class="mt-8 inline-block bg-white text-blue-600 font-semibold px-6 py-3 rounded-full hover:bg-gray-100 transition duration-300">Masuk
            ke Aplikasi</a>
    </section> -->

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-6">
        <p>&copy; 2024 PT Pupuk Sriwidjaja Palembang. All rights reserved.</p>
    </footer>

</body>

</html>