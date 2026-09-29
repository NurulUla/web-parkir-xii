<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('role')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }
        return view('utama');
    }

    // =========================================================================
    // 🛠️ HAK AKSES ADMIN
    // =========================================================================

    public function crudUser()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $users = DB::table('tb_user')->get();
        return view('admin.users', compact('users'));
    }

    public function simpanUser(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:tb_user,username',
            'password' => 'required|min:6',
            'role' => 'required'
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah dipakai, silakan pilih username lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Hak akses (role) wajib dipilih.'
        ]);

        DB::table('tb_user')->insert([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => strtolower($request->username),
            'password' => Hash::make($request->password), // di-hash, jangan plain text
            'role' => $request->role,
            'status_aktif' => 1
        ]);

        return redirect()->route('admin.user')->with('success', 'User baru berhasil terdaftar!');
    }

    public function hapusUser($id)
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        if ($id == session('user_id')) {
            return redirect()->route('admin.user')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif!');
        }

        DB::table('tb_user')->where('id_user', $id)->delete();
        return redirect()->route('admin.user')->with('success', 'Akun pengguna berhasil dihapus dari sistem!');
    }

    public function crudTarif()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $tarif = DB::table('tb_tarif')->get();
        return view('admin.tarif', compact('tarif'));
    }

    public function crudArea()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $area = DB::table('tb_area_parkir')->get();
        return view('admin.area', compact('area'));
    }

    public function crudKendaraan()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $kendaraan = DB::table('tb_kendaraan')->get();
        return view('admin.kendaraan', compact('kendaraan'));
    }

    public function hapusKendaraan($id)
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        DB::table('tb_transaksi')->where('id_kendaraan', $id)->delete();
        DB::table('tb_kendaraan')->where('id_kendaraan', $id)->delete();
        return redirect()->route('admin.kendaraan')->with('success', 'Data kendaraan berhasil dihapus!');
    }

    public function aksesLog()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $logs = DB::table('tb_log_aktivitas')
            ->join('tb_user', 'tb_log_aktivitas.id_user', '=', 'tb_user.id_user')
            ->select('tb_log_aktivitas.*', 'tb_user.nama_lengkap', 'tb_user.role')
            ->orderBy('waktu_aktivitas', 'desc')
            ->get();
        return view('admin.log', compact('logs'));
    }

    public function hapusLog($id)
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        DB::table('tb_log_aktivitas')->where('id_log', $id)->delete();
        return redirect()->route('admin.log')->with('success', 'Log aktivitas berhasil dihapus!');
    }

    public function hapusSemuaLog()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        DB::table('tb_log_aktivitas')->truncate();
        return redirect()->route('admin.log')->with('success', 'Semua log aktivitas berhasil dihapus!');
    }


    // =========================================================================
    // 🚗 HAK AKSES PETUGAS
    // =========================================================================

    public function transaksi()
    {
        if (!session()->has('role') || session('role') !== 'petugas') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $tarif = DB::table('tb_tarif')->get();
        $area = DB::table('tb_area_parkir')->get();
        $transaksi_aktif = DB::table('tb_transaksi')
            ->join('tb_kendaraan', 'tb_transaksi.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->join('tb_area_parkir', 'tb_transaksi.id_area', '=', 'tb_area_parkir.id_area')
            ->where('tb_transaksi.status', 'masuk')
            ->select('tb_transaksi.*', 'tb_kendaraan.plat_nomor', 'tb_kendaraan.jenis_kendaraan', 'tb_area_parkir.nama_area')
            ->get();
        return view('petugas.transaksi', compact('tarif', 'area', 'transaksi_aktif'));
    }

    public function simpanTransaksiMasuk(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'petugas') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        // 1. HAPUS 'jenis_kendaraan' => 'required' dari sini karena dropdown manualnya sudah dibuang
        $request->validate([
            'plat_nomor' => 'required',
            'id_tarif'   => 'required',
            'id_area'    => 'required',
            'warna'      => 'required',
            'pemilik'    => 'required'
        ]);

        $plat = strtoupper($request->plat_nomor);
        $kendaraan = DB::table('tb_kendaraan')->where('plat_nomor', $plat)->first();

        if ($kendaraan) {
            $masihMasuk = DB::table('tb_transaksi')
                ->where('id_kendaraan', $kendaraan->id_kendaraan)
                ->where('status', 'masuk')
                ->exists();

            if ($masihMasuk) {
                return redirect()->route('petugas.transaksi')->with('error', 'Kendaraan dengan plat ini tercatat masih berada di dalam area parkir!');
            }
            
            $id_kendaraan = $kendaraan->id_kendaraan;
        } else {
            // 2. OTOMATIS AMBIL NAMA JENIS KENDARAAN DARI DATABASE TARIF (Solusi Cerdas ✨)
            $dataTarif = DB::table('tb_tarif')->where('id_tarif', $request->id_tarif)->first();
            $namaJenis = $dataTarif ? $dataTarif->jenis_kendaraan : 'lainnya';

            // 3. Masukkan variabel $namaJenis ke kolom jenis_kendaraan
            $id_kendaraan = DB::table('tb_kendaraan')->insertGetId([
                'plat_nomor'      => $plat,
                'warna'           => $request->warna,
                'pemilik'         => $request->pemilik,
                'jenis_kendaraan' => $namaJenis 
            ]);
        }

        // Catat data ke tabel transaksi masuk
        DB::table('tb_transaksi')->insert([
            'id_kendaraan' => $id_kendaraan,
            'id_tarif'     => $request->id_tarif,
            'id_area'      => $request->id_area,
            'waktu_masuk'  => now(),
            'status'       => 'masuk'
        ]);

        // Update otomatis jumlah slot terisi di area parkir terkait (+1)
        DB::table('tb_area_parkir')
            ->where('id_area', $request->id_area)
            ->increment('terisi');

        return redirect()->route('petugas.transaksi')->with('success', 'Kendaraan berhasil masuk!');
    }




    public function hapusTransaksi($id)
    {
        if (!session()->has('role') || session('role') !== 'petugas') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        DB::table('tb_transaksi')->where('id_transaksi', $id)->delete();
        return redirect()->route('petugas.transaksi')->with('success', 'Data transaksi berhasil dihapus!');
    }

    public function cetakStruk($id)
    {
        // Ditambahkan: sebelumnya method ini bisa diakses tanpa login sama sekali
        if (!session()->has('role')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $transaksi = DB::table('tb_transaksi')->where('id_transaksi', $id)->first();

        if (!$transaksi) {
            return redirect()->route('petugas.transaksi')->with('error', 'Data transaksi tidak ditemukan.');
        }

        return view('petugas.cetak', compact('transaksi'));
    }

    public function prosesKeluar($id)
    {
        if (!session()->has('role') || session('role') !== 'petugas') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $transaksi = DB::table('tb_transaksi')
            ->join('tb_tarif', 'tb_transaksi.id_tarif', '=', 'tb_tarif.id_tarif')
            ->where('id_transaksi', $id)
            ->first();

        if ($transaksi) {
            $waktu_masuk = new \DateTime($transaksi->waktu_masuk);
            $waktu_keluar = now();

            $selisih = $waktu_masuk->diff($waktu_keluar);
            $durasi_jam = $selisih->h + ($selisih->days * 24);

            if ($durasi_jam == 0) {
                $durasi_jam = 1;
            }

            $biaya_total = $durasi_jam * $transaksi->tarif_per_jam;

            DB::table('tb_transaksi')->where('id_transaksi', $id)->update([
                'waktu_keluar' => $waktu_keluar,
                'durasi_jam' => $durasi_jam,
                'biaya_total' => $biaya_total,
                'status' => 'keluar'
            ]);

            return redirect()->route('petugas.transaksi')->with('success', 'Kendaraan berhasil keluar! Total Bayar: Rp ' . number_format($biaya_total, 0, ',', '.'));
        }

        return redirect()->route('petugas.transaksi')->with('error', 'Data transaksi tidak ditemukan.');
    }

    // =========================================================================
    // 📈 HAK AKSES OWNER
    // =========================================================================

    public function rekapLaporan(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'owner') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $query = DB::table('tb_transaksi')
            ->join('tb_kendaraan', 'tb_transaksi.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->where('tb_transaksi.status', 'keluar');

        // Filter rentang waktu (opsional, dikirim lewat ?dari=YYYY-MM-DD&sampai=YYYY-MM-DD)
        if ($request->filled('dari')) {
            $query->whereDate('tb_transaksi.waktu_keluar', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tb_transaksi.waktu_keluar', '<=', $request->sampai);
        }

        $laporan = $query->orderBy('tb_transaksi.waktu_keluar', 'desc')->get();
        $total_pendapatan = $laporan->sum('biaya_total');

        return view('owner.rekap', compact('laporan', 'total_pendapatan'));
    }

}