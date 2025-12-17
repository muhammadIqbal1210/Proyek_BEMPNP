<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Aplikasi</title>
    <!-- Tailwind CSS CDN untuk styling modern dan responsif -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Menggunakan font Inter */
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-xl shadow-2xl">
        <h2 class="text-3xl font-extrabold text-gray-900 text-center">
            Login
        </h2>

        <!-- Area Pesan (Sukses/Gagal) -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="p-3 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- 
            FORM LOGIN UTAMA
            Action mengarah ke rute POST 'login/auth'
            Method harus POST 
        -->
        <form action="<?= base_url('login/auth') ?>" method="post" class="space-y-4">
            <!-- CSRF Protection -->
            <?= csrf_field() ?>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="nama@email.com"
                    value="<?= set_value('email') ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                <span class="text-red-500 text-xs mt-1 block">
                    <!-- Menampilkan error validasi untuk email -->
                    <?= isset($validation) && $validation->hasError('email') ? $validation->getError('email') : '' ?>
                </span>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Masukkan password Anda"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                <span class="text-red-500 text-xs mt-1 block">
                    <!-- Menampilkan error validasi untuk password -->
                    <?= isset($validation) && $validation->hasError('password') ? $validation->getError('password') : '' ?>
                </span>
            </div>

            <!-- Tombol Submit (Login) -->
            <button 
                type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
            >
                Masuk
            </button>
        </form>

        <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">Belum punya akun? <a href="/register">Daftar Sekarang </a></p>
    </div>

</body>
</html>