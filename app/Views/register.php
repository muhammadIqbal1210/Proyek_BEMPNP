<?= $this->extend('layouts/layout_utama') ?> 

<?php $this->section('content') ?>
<section class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <!-- Main Card Container -->
    <!-- flex-row-reverse dihapus agar branding di kiri dan form di kanan -->
    <div class="max-w-5xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px] border border-gray-100">
    
        <div class="hidden md:flex md:w-1/2 bg-green-700 p-12 flex-col justify-between relative overflow-hidden text-left">
            <!-- Dekorasi Pattern -->
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-12 justify-start">
                    <img src="/bem.png" alt="Logo PNP" class="w-12 h-12 " onerror="this.src='https://via.placeholder.com/48?text=PNP'">
                    <div class="text-left">
                        <p class="text-white font-bold text-xl leading-none">BEM KM</p>
                        <p class="text-green-200 text-[10px] font-semibold tracking-widest uppercase">Politeknik Negeri Padang</p>
                    </div>
                </div>
                
                <h2 class="text-4xl font-extrabold text-white leading-tight">Mari Bergabung, <br>Aktivis Muda!</h2>
                <p class="text-green-50 mt-4 text-lg opacity-90 italic">"Suara Mahasiswa, Karya Nyata. <br>Jadilah bagian dari perubahan."</p>
            </div>

            <!-- Elemen Dekoratif Tengah -->
            <div class="relative z-10 flex justify-start py-6">
                <div class="bg-white/10 p-6 rounded-3xl backdrop-blur-sm border border-white/20">
                    <i class="fas fa-user-plus text-6xl text-orange-400"></i>
                </div>
            </div>

            <div class="relative z-10">
                <div class="w-12 h-1 bg-orange-500 mb-4 mr-auto"></div>
                <p class="text-green-100 text-sm">Pastikan data yang Anda masukkan sesuai dengan identitas mahasiswa aktif Politeknik Negeri Padang.</p>
            </div>
        </div>

        <!-- Sisi Kanan (Form Register) -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white">
            <div class="max-w-sm mx-auto w-full">
                
                <div class="mb-8 text-center md:text-left">
                    <span class="text-orange-600 font-bold tracking-widest uppercase text-xs">Pendaftaran Akun</span>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">Daftar Akun</h2>
                    <p class="text-gray-500 mt-2 text-sm">Lengkapi data diri Anda untuk bergabung.</p>
                </div>

                <!-- Alert Error -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs rounded-r-xl animate-pulse" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <p class="font-bold">Gagal Mendaftar</p>
                        </div>
                        <p class="mt-1 ml-6"><?= session()->getFlashdata('error') ?></p>
                    </div>
                <?php endif; ?>

                <form action="/register/save" method="post" class="space-y-4">
                    <?= csrf_field() ?>

                    <!-- Username -->
                    <div class="group">
                        <label for="username" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1 group-focus-within:text-green-700 transition-colors">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400 group-focus-within:text-green-600"></i>
                            </div>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                placeholder="Masukkan username"
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-green-600 focus:ring-4 focus:ring-green-600/10 transition-all outline-none text-gray-700 font-medium sm:text-sm"
                                required
                            >
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="group">
                        <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1 group-focus-within:text-green-700 transition-colors">Email Student</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400 group-focus-within:text-green-600"></i>
                            </div>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                placeholder="nim@student.pnp.ac.id"
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-green-600 focus:ring-4 focus:ring-green-600/10 transition-all outline-none text-gray-700 font-medium sm:text-sm"
                                required
                            >
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="group">
                        <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1 group-focus-within:text-green-700 transition-colors">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400 group-focus-within:text-green-600"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="••••••••"
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-green-600 focus:ring-4 focus:ring-green-600/10 transition-all outline-none text-gray-700 sm:text-sm"
                                required
                            >
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="group">
                        <label for="pass_confirm" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1 group-focus-within:text-green-700 transition-colors">Konfirmasi Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-check-double text-gray-400 group-focus-within:text-green-600"></i>
                            </div>
                            <input 
                                type="password" 
                                id="pass_confirm" 
                                name="pass_confirm" 
                                placeholder="Ulangi sandi"
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-green-600 focus:ring-4 focus:ring-green-600/10 transition-all outline-none text-gray-700 sm:text-sm"
                                required
                            >
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button 
                            type="submit" 
                            class="w-full bg-green-700 hover:bg-green-800 text-white font-extrabold py-4 rounded-2xl transition-all shadow-xl shadow-green-100 flex items-center justify-center gap-3 group transform hover:-translate-y-1 active:scale-95"
                        >
                            <span>DAFTAR AKUN</span>
                            <i class="fas fa-user-plus group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-gray-400 text-sm">
                        Sudah punya akun? 
                        <a href="/login" class="text-green-700 font-extrabold hover:text-orange-600 transition-colors inline-block underline decoration-2 underline-offset-4 ml-1">Masuk Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->endSection() ?>