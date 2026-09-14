<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - E-Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-purple-700 to-indigo-800 text-white shadow-lg px-6 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="bg-purple-900 hover:bg-purple-950 px-4 py-2 rounded-xl text-xs font-bold transition">
                ⬅️ Kembali ke Dashboard
            </a>
            <h1 class="text-md font-black uppercase tracking-wider">Laporan Rekapitulasi Pendapatan</h1>
            <span class="text-xs bg-purple-600 px-3 py-1 rounded-lg font-bold uppercase">{{ session('role') }}</span>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 max-w-5xl mx-auto w-full">
            
            <!-- Widget Total Pendapatan -->
            <div class="bg-gradient-to-br from-purple-600 to-indigo-700 p-6 rounded-3xl text-white shadow-xl mb-8 flex justify-between items-center">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-purple-200">Total Uang Parkir Masuk (Selesai)</h3>
                    <div class="text-3xl font-black mt-1">Rp 4.000</div>
                </div>
                <span class="text-4xl">💰</span>
            </div>

            <!-- Tabel Rekap Transaksi -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2"><span>📊</span> Riwayat Kendaraan Selesai Parkir</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-bold uppercase text-slate-400 bg-slate-50">
                                <th class="py-3 px-4">Plat Nomor</th>
                                <th class="py-3 px-4">Jenis</th>
                                <th class="py-3 px-4">Durasi</th>
                                <th class="py-3 px-4 text-right">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($laporan as $l)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 font-black tracking-wide uppercase">{{ $l->plat_nomor }}</td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md text-xs font-bold uppercase bg-slate-100 text-slate-600">{{ $l->jenis_kendaraan }}</span></td>
                                    <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $l->durasi_jam }} Jam</td>
                                    <td class="py-3.5 px-4 text-right font-bold text-purple-600">Rp {{ number_format($l->biaya_total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <!-- Contoh data static jika query kosong -->
                                    <td class="py-3.5 px-4 font-black tracking-wide uppercase">N 1234 AB</td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md text-xs font-bold uppercase bg-slate-100 text-slate-600">motor</span></td>
                                    <td class="py-3.5 px-4 text-slate-500 text-xs">2 Jam</td>
                                    <td class="py-3.5 px-4 text-right font-bold text-purple-600">Rp 4.000</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>
