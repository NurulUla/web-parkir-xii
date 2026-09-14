<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kendaraan - E-Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <div class="min-h-screen flex flex-col">
        <!-- 🖥️ Top Navbar -->
        <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg px-6 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="bg-blue-800 hover:bg-blue-900 px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                ⬅️ Kembali ke Dashboard
            </a>
            <h1 class="text-md font-black uppercase tracking-wider">Manajemen Data Kendaraan</h1>
            <span class="text-xs bg-blue-700 px-3 py-1 rounded-lg font-bold uppercase">{{ session('role') }}</span>
        </nav>

        <!-- 📊 Main Content Area -->
        <main class="flex-1 p-6 max-w-5xl mx-auto w-full">
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span>🚘</span> Daftar Kendaraan Terdaftar Dalam Sistem
                </h3>

                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-3 mb-4 rounded-r-lg text-xs text-emerald-700 font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-50">
                                <th class="py-3 px-4">ID</th>
                                <th class="py-3 px-4">Plat Nomor</th>
                                <th class="py-3 px-4">Jenis Kendaraan</th>
                                <th class="py-3 px-4">Warna</th>
                                <th class="py-3 px-4">Nama Pemilik</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($kendaraan as $k)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 text-slate-400 text-xs">#{{ $k->id_kendaraan }}</td>
                                    <td class="py-3.5 px-4 font-black text-slate-800 tracking-wide uppercase">{{ $k->plat_nomor }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-0.5 rounded-md text-xs font-bold uppercase 
                                            {{ $k->jenis_kendaraan == 'mobil' ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600' }}">
                                            {{ $k->jenis_kendaraan }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-xs">{{ $k->warna ?? '-' }}</td>
                                    <td class="py-3.5 px-4 font-semibold">{{ $k->pemilik ?? '-' }}</td>
                                    <td class="py-3.5 px-4 text-center">
                                        <form action="{{ route('admin.kendaraan.hapus', $k->id_kendaraan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data induk kendaraan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold px-3 py-1 rounded-xl text-xs shadow-sm transition">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400 font-normal">
                                        📭 Belum ada data kendaraan terdaftar.
                                    </td>
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
