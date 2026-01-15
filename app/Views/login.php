<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | BEM KM PNP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .login-gradient { background: linear-gradient(135deg, #15803d 0%, #166534 100%); }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            75% { transform: translateX(6px); }
        }
        .error-shake { animation: shake 0.4s ease-in-out; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="max-w-2xl w-full bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row shadow-green-900/10">
        
        <!-- Sisi Kiri: Visual -->
        <div class="hidden md:flex md:w-5/12 login-gradient p-10 flex-col justify-between text-white">
            <div>
                <div class="bg-white/20 backdrop-blur-md w-12 h-12 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-shield-halved text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold leading-tight">Sistem Keamanan Terpadu</h1>
                <p class="mt-4 text-green-100/70 text-sm leading-relaxed">Silakan masuk untuk mengelola data organisasi dan administrasi mahasiswa.</p>
            </div>
            <div class="text-xs opacity-50 font-medium tracking-widest uppercase">
                &copy; 2025 BEM KM PNP
            </div>
        </div>

        <!-- Sisi Kanan: Form -->
        <div class="w-full md:w-7/12 p-8 md:p-14">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800">Selamat Datang</h2>
                <p class="text-gray-500 text-sm mt-1">Masukkan kredensial Anda untuk melanjutkan.</p>
            </div>

            <!-- PESAN ERROR TUNGGAL (Email/Sandi Salah) -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-6 flex items-center p-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl error-shake" role="alert">
                    <div class="bg-red-500 text-white p-2 rounded-lg mr-4 shrink-0">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div>
                        <p class="font-bold">Akses Ditolak</p>
                        <p class="text-xs opacity-80"><?= session()->getFlashdata('error') ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- PESAN ERROR VALIDASI (Array) -->
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="mb-6 flex items-start p-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl error-shake" role="alert">
                    <div class="bg-red-500 text-white p-2 rounded-lg mr-4 shrink-0">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <div>
                        <p class="font-bold">Kesalahan Input</p>
                        <ul class="text-xs opacity-80 list-disc list-inside">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- PESAN SUKSES (Jika ada logout atau reset pass) -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-6 flex items-center p-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl" role="alert">
                    <div class="bg-green-500 text-white p-2 rounded-lg mr-4 shrink-0">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="font-bold">Berhasil</p>
                        <p class="text-xs opacity-80"><?= session()->getFlashdata('success') ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/auth') ?>" method="post" class="space-y-5">
                <?= csrf_field() ?>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Email</label>
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-2xl px-4 focus-within:ring-2 focus-within:ring-green-500/20 focus-within:border-green-600 transition-all">
                        <i class="fas fa-envelope text-gray-400 mr-3"></i>
                        <input type="email" name="email" value="<?= set_value('email') ?>" required class="w-full py-4 bg-transparent text-sm outline-none text-gray-700" placeholder="nama@email.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Kata Sandi</label>
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-2xl px-4 focus-within:ring-2 focus-within:ring-green-500/20 focus-within:border-green-600 transition-all">
                        <i class="fas fa-lock text-gray-400 mr-3"></i>
                        <input type="password" id="passInput" name="password" required class="w-full py-4 bg-transparent text-sm outline-none text-gray-700" placeholder="••••••••">
                        <button type="button" onclick="togglePass()" class="text-gray-400 hover:text-green-600 transition-colors px-2">
                            <i id="eye" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="#" class="text-xs font-semibold text-green-700 hover:underline">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="w-full py-4 bg-green-700 hover:bg-green-800 text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-green-700/20 active:scale-95">
                    Masuk Sekarang
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePass() {
            const input = document.getElementById('passInput');
            const eye = document.getElementById('eye');
            input.type = input.type === 'password' ? 'text' : 'password';
            eye.classList.toggle('fa-eye');
            eye.classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>