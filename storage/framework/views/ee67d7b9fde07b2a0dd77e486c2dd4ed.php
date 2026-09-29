<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Parkir XII</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<!-- 🛠️ DISINI YANG SUDAH DIGANTI: Menggunakan background-parkir.jpg -->
<body style="background-image: linear-gradient(rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.4)), url('<?php echo e(asset('images/parkir.jpg')); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;" 
      class="flex items-center justify-center min-h-screen p-4">

    <!-- Card Login Putih -->
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md border border-slate-200">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800">E-Parkir XII</h2>
            <p class="text-slate-500 mt-2 text-sm">Silakan masuk untuk mengelola sistem parkir</p>
        </div>

        <!-- Notifikasi Error jika Gagal -->
        <?php if(session('error')): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg text-sm text-red-700">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="<?php echo e(route('login.proses')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <!-- Pembungkus relatif agar tombol mata bisa masuk ke dalam kotak -->
                <div class="relative">
                    <input type="password" id="passwordInput" name="password" placeholder="••••••••" required
                        class="w-full px-4 pr-12 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    
                    <!-- Tombol Mata Interaktif -->
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-slate-700 focus:outline-none">
                        <span id="eyeIcon" class="text-lg select-none">👁️</span>
                    </button>
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-blue-500/30 transition transform active:scale-95">
                Masuk ke Sistem
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-8 text-xs text-slate-400">
            &copy; 2026 Aplikasi Parkir SMK - XII Reguler
        </div>
    </div>

    <!-- Script Fungsi Tombol Intip -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = '🙈'; // Berubah jadi monyet/mata tertutup saat password kelihatan
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = '👁️'; // Berubah kembali jadi mata terbuka
            }
        }
    </script>

</body>
</html>
<?php /**PATH C:\xii-reg\web-xii\parkir-xii-reguler\resources\views/auth/login.blade.php ENDPATH**/ ?>