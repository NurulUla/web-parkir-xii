<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Parkir XII</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-200">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800">E-Parkir XII</h2>
            <p class="text-slate-500 mt-2 text-sm">Silakan masuk untuk mengelola sistem parkir</p>
        </div>

        <!-- Notifikasi Error jika Gagal -->
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.proses') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input type="password" name="password" placeholder="••••••••" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
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

</body>
</html>
