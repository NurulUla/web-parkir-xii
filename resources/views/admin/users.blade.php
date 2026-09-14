<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - E-Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <div class="min-h-screen flex flex-col">
        <!-- 🖥️ Top Navbar -->
        <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="bg-blue-800 hover:bg-blue-900 px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                    ⬅️ Kembali ke Dashboard
                </a>
            </div>
            <h1 class="text-md font-black uppercase tracking-wider">Manajemen Pengguna (User)</h1>
            <span class="text-xs bg-blue-700 px-3 py-1 rounded-lg font-bold uppercase">{{ session('role') }}</span>
        </nav>

        <!-- 📊 Main Content Area -->
        <main class="flex-1 p-6 max-w-6xl mx-auto w-full grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- 📥 Form Tambah User -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 h-fit">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2"><span>➕</span> Tambah User</h3>
                
                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-3 mb-4 rounded-r-lg text-xs text-emerald-700 font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-rose-50 border-l-4 border-rose-500 p-3 mb-4 rounded-r-lg text-xs text-rose-700 font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.user.simpan') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" placeholder="Nama Petugas" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Username Login</label>
                        <input type="text" name="username" placeholder="petugas_budi" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm lowercase focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Password</label>
                        <input type="password" name="password" placeholder="••••••••" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Hak Akses (Role)</label>
                        <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="petugas">Petugas Lapangan</option>
                            <option value="admin">Administrator</option>
                            <option value="owner">Owner / Pemilik</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm transition">💾 Simpan User</button>
                </form>
            </div>

            <!-- 👥 Tabel Daftar User -->
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2"><span>👥</span> Pengguna Terdaftar</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-bold uppercase text-slate-400 bg-slate-50">
                                <th class="py-3 px-4">Nama Lengkap</th>
                                <th class="py-3 px-4">Username</th>
                                <th class="py-3 px-4">Role</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100 font-medium">
                            @foreach($users as $u)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 font-bold text-slate-800">{{ $u->nama_lengkap }}</td>
                                    <td class="py-3.5 px-4 text-slate-500 text-xs">@<span>{{ $u->username }}</span></td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-0.5 rounded-md text-xs font-bold uppercase 
                                            @if($u->role == 'admin') bg-blue-50 text-blue-600 
                                            @elseif($u->role == 'owner') bg-purple-50 text-purple-600 
                                            @else bg-amber-50 text-amber-600 @endif">
                                            {{ $u->role }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Aktif</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <!-- Tombol Hapus User Akun -->
                                        <form action="{{ route('admin.user.hapus', $u->id_user) }}" method="POST" onsubmit="return confirm('Hapus akun ini permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold px-2.5 py-1 rounded-lg text-xs shadow-sm transition">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
