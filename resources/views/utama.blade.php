<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utama - E-Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🅿️</span>
                <h1 class="text-xl font-black tracking-wider uppercase">Sistem E-Parkir XII</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex flex-col text-right hidden sm:flex">
                    <span class="font-bold text-sm">{{ session('nama') }}</span>
                    <span class="text-xs text-blue-200 font-semibold tracking-wide uppercase">{{ session('role') }}</span>
                </div>
                <div class="h-8 w-px bg-blue-400 hidden sm:block"></div>
                <a href="{{ route('logout') }}" class="bg-rose-500 hover:bg-rose-600 px-4 py-2 rounded-xl text-sm font-bold shadow-md shadow-rose-900/20 transition duration-200 transform active:scale-95">Keluar</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-10 max-w-6xl mx-auto w-full">
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">Selamat Datang Kembali, {{ session('nama') }}! 👋</h2>
                    <p class="text-slate-500 mt-1">Status hak akses Anda: <span class="text-blue-600 font-bold uppercase">{{ session('role') }}</span>. Kelola sistem parkir secara real-time dengan menu di bawah ini.</p>
                </div>
                <div class="text-sm font-semibold text-slate-400 bg-slate-100 px-4 py-2 rounded-xl">📅 {{ date('d M Y') }}</div>
            </div>

            <!-- Widgets -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl border border-blue-200 shadow-sm">
                    <div class="flex justify-between items-center mb-3"><span class="text-sm font-bold text-blue-800 uppercase">Kendaraan Aktif</span><span class="text-2xl">🚗</span></div>
                    <div class="text-3xl font-black text-blue-900">120 <span class="text-sm font-normal text-blue-600">Unit</span></div>
                </div>
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-6 rounded-2xl border border-emerald-200 shadow-sm">
                    <div class="flex justify-between items-center mb-3"><span class="text-sm font-bold text-emerald-800 uppercase">Slot Tersedia</span><span class="text-2xl">🔲</span></div>
                    <div class="text-3xl font-black text-emerald-900">65 <span class="text-sm font-normal text-emerald-600">Slot</span></div>
                </div>
                <div class="bg-gradient-to-br from-violet-50 to-violet-100 p-6 rounded-2xl border border-violet-200 shadow-sm">
                    <div class="flex justify-between items-center mb-3"><span class="text-sm font-bold text-violet-800 uppercase">Pendapatan Hari Ini</span><span class="text-2xl">💰</span></div>
                    <div class="text-3xl font-black text-violet-900">Rp 345.000</div>
                </div>
            </div>

            <!-- Menus -->
            <div class="space-y-10">
                @if(session('role') == 'admin')
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4">🛠️ Otoritas & Manajemen Admin</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <a href="{{ route('admin.user') }}" class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-400 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition text-xl">👥</div>
                            <div><h4 class="font-bold text-slate-800 group-hover:text-blue-600 transition">CRUD User</h4><p class="text-xs text-slate-400 mt-0.5">Kelola data login petugas & hak akses.</p></div>
                        </a>
                        <a href="{{ route('admin.tarif') }}" class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-400 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition text-xl">💵</div>
                            <div><h4 class="font-bold text-slate-800 group-hover:text-emerald-600 transition">CRUD Tarif Parkir</h4><p class="text-xs text-slate-400 mt-0.5">Atur tarif per jam motor / mobil.</p></div>
                        </a>
                        <a href="{{ route('admin.area') }}" class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-amber-400 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition text-xl">🗺️</div>
                            <div><h4 class="font-bold text-slate-800 group-hover:text-amber-600 transition">CRUD Area Parkir</h4><p class="text-xs text-slate-400 mt-0.5">Pantau kapasitas gedung / slot parkir.</p></div>
                        </a>
                        <a href="{{ route('admin.kendaraan') }}" class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-400 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition text-xl">🚘</div>
                            <div><h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition">CRUD Kendaraan</h4><p class="text-xs text-slate-400 mt-0.5">Kelola plat nomor & data pemilik resmi.</p></div>
                        </a>
                        <a href="{{ route('admin.log') }}" class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-violet-400 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-violet-50 text-violet-600 rounded-xl group-hover:bg-violet-600 group-hover:text-white transition text-xl">📜</div>
                            <div><h4 class="font-bold text-slate-800 group-hover:text-violet-600 transition">Akses Log Aktivitas</h4><p class="text-xs text-slate-400 mt-0.5">Audit jejak aktivitas sistem petugas.</p></div>
                        </a>
                    </div>
                </div>
                @endif

                @if(session('role') == 'petugas' || session('role') == 'admin')
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4">🚗 Operasional Lapangan / Petugas</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <a href="{{ route('petugas.transaksi') }}" class="group bg-gradient-to-br from-amber-500 to-orange-600 p-5 rounded-2xl shadow-md flex items-center gap-4 text-white">
                            <div class="p-3 bg-white/20 text-white rounded-xl text-xl">🎫</div>
                            <div><h4 class="font-black">Input Transaksi Parkir</h4><p class="text-xs text-amber-100 mt-0.5">Catat masuk & keluar / cetak karcis.</p></div>
                        </a>
                    </div>
                </div>
                @endif

                @if(session('role') == 'owner' || session('role') == 'admin')
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4">📈 Laporan Eksekutif / Owner</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <a href="{{ route('owner.rekap') }}" class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-purple-400 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition text-xl">📊</div>
                            <div><h4 class="font-bold text-slate-800 group-hover:text-purple-600 transition">Rekap & Laporan</h4><p class="text-xs text-slate-400 mt-0.5">Analisis pendapatan sesuai rentang waktu.</p></div>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </main>

        @include('layout.footer')
    </div>
</body>
</html>
