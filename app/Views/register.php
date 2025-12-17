<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Menggunakan font Inter */
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f3f4f6; 
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-xl shadow-2xl">
        <h2 class="text-3xl font-extrabold text-gray-900 text-center">
            Daftar Akun Baru
        </h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="p-3 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <form action="/register" method="post" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Masukkan username Anda"
                    value="<?= set_value('username') ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                <span class="text-red-500 text-xs mt-1 block">
                    <?= isset($validation) ? $validation->getError('username') : '' ?>
                </span>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="nama@email.com"
                    value="<?= set_value('email') ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                <span class="text-red-500 text-xs mt-1 block">
                    <?= isset($validation) ? $validation->getError('email') : '' ?>
                </span>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Buat password baru"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                <span class="text-red-500 text-xs mt-1 block">
                    <?= isset($validation) ? $validation->getError('password') : '' ?>
                </span>
            </div>

            <div>
                <label for="pass_confirm" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="pass_confirm" 
                    name="pass_confirm" 
                    placeholder="Ulangi password Anda"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                <span class="text-red-500 text-xs mt-1 block">
                    <?= isset($validation) ? $validation->getError('pass_confirm') : '' ?>
                </span>
            </div>

            <button 
                type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
            >
                Daftar Akun
            </button>
        </form>

        <p class="text-center text-sm">
            Sudah punya akun? 
            <a href="/login" class="text-indigo-600 hover:text-indigo-800 font-medium">Masuk di sini</a>
        </p>
    </div>

</body>
</html>