<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Parkir - E-Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg px-6 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="bg-blue-800 hover:bg-blue-900 px-4 py-2 rounded-xl text-xs font-bold transition">
                ⬅️ Kembali ke Dashboard
            </a>
            <h1 class="text-md font-black uppercase tracking-wider">Operasional Transaksi Parkir</h1>
            <span class="text-xs bg-blue-700 px-3 py-1 rounded-lg font-bold uppercase">{{ session('role') }}</span>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 max-w-6xl mx-auto w-full grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Form Input -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 h-fit">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2"><span>➕</span> Catat Kendaraan Masuk</h3>
                
                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-3 mb-4 rounded-r-lg text-xs text-emerald-700 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('petugas.transaksi.simpan') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Nomor Plat Kendaraan</label>
                        <input type="text" name="plat_nomor" placeholder="Contoh: N 1234 AB" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 uppercase font-bold tracking-wide text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Jenis Kendaraan</label>
                        <select name="id_tarif" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @foreach($tarif as $t)
                                <option value="{{ $t->id_tarif }}">{{ ucfirst($t->jenis_kendaraan) }} (Rp {{ number_format($t->tarif_per_jam, 0, ',', '.') }}/jam)</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Area / Slot Parkir</label>
                        <select name="id_area" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @foreach($area as $a)
                                <option value="{{ $a->id_area }}">{{ $a->nama_area }} (Slot: {{ $a->kapasitas }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl shadow-md text-sm transition">
                        🖨️ Cetak Karcis Masuk
                    </button>
                </form>
            </div>

            <!-- Tabel Data -->
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2"><span>🚘</span> Kendaraan Aktif di Dalam Area</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-bold uppercase text-slate-400 bg-slate-50">
                                <th class="py-3 px-4">Plat Nomor</th>
                                <th class="py-3 px-4">Jenis</th>
                                <th class="py-3 px-4">Lokasi Area</th>
                                <th class="py-3 px-4">Waktu Masuk</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100 font-medium">
                            @forelse($transaksi_aktif as $tr)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 font-black text-slate-800 tracking-wide uppercase">{{ $tr->plat_nomor }}</td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md text-xs font-bold uppercase bg-slate-100 text-slate-600">{{ $tr->jenis_kendaraan }}</span></td>
                                    <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $tr->nama_area }}</td>
                                    <td class="py-3.5 px-4 text-slate-500 text-xs">{{ date('d M, H:i', strtotime($tr->waktu_masuk)) }} WIB</td>
                                    <td class="py-3.5 px-4 flex flex-col gap-1 items-center justify-center">
                                        <a href="#" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-3 py-1 rounded-xl text-xs shadow-sm transition w-28 text-center">Keluar & Bayar</a>
                                        <form action="{{ route('petugas.transaksi.hapus', $tr->id_transaksi) }}" method="POST" onsubmit="return confirm('Hapus data kendaraan ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold px-3 py-1 rounded-xl text-xs shadow-sm transition w-28">🗑️ Hapus Data</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400 font-normal">📭 Tidak ada kendaraan di dalam area parkir.</td>
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
