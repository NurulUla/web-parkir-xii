<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'password' => $request->password, 
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

        // Proteksi agar admin tidak tidak sengaja menghapus dirinya sendiri saat login
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
            ->select('tb_log_aktivitas.*', 'tb_user.nama_lengkap')
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

    // =========================================================================
    // 🚗 HAK AKSES PETUGAS
    // =========================================================================

    public function transaksi()
    {
        if (!session()->has('role')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
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
        $request->validate([
            'plat_nomor' => 'required',
            'id_tarif' => 'required',
            'id_area' => 'required'
        ]);
        $plat = strtoupper(str_replace(' ', '', $request->plat_nomor));
        $kendaraan = DB::table('tb_kendaraan')->where('plat_nomor', $plat)->first();
        if (!$kendaraan) {
            $tarif_info = DB::table('tb_tarif')->where('id_tarif', $request->id_tarif)->first();
            $id_kendaraan = DB::table('tb_kendaraan')->insertGetId([
                'plat_nomor' => $plat,
                'jenis_kendaraan' => $tarif_info->jenis_kendaraan,
                'warna' => '-',
                'pemilik' => '-'
            ]);
        } else {
            $id_kendaraan = $kendaraan->id_kendaraan;
        }
        DB::table('tb_transaksi')->insert([
            'id_kendaraan' => $id_kendaraan,
            'waktu_masuk' => now(),
            'id_tarif' => $request->id_tarif,
            'id_area' => $request->id_area,
            'status' => 'masuk',
            'id_user' => session('user_id'),
            'biaya_total' => 0,
            'durasi_jam' => 0
        ]);
        return redirect()->route('petugas.transaksi')->with('success', 'Karcis parkir masuk berhasil diterbitkan!');
    }

    public function hapusTransaksi($id)
    {
        DB::table('tb_transaksi')->where('id_transaksi', $id)->delete();
        return redirect()->route('petugas.transaksi')->with('success', 'Data transaksi berhasil dihapus!');
    }

    public function cetakStruk($id)
    {
        $transaksi = DB::table('tb_transaksi')->where('id_transaksi', $id)->first();
        return view('petugas.cetak', compact('transaksi'));
    }

    // =========================================================================
    // 📈 HAK AKSES OWNER
    // =========================================================================

    public function rekapLaporan()
    {
        if (!session()->has('role') || (session('role') !== 'owner' && session('role') !== 'admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $laporan = DB::table('tb_transaksi')
            ->join('tb_kendaraan', 'tb_transaksi.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->where('tb_transaksi.status', 'keluar')
            ->get();
        return view('owner.rekap', compact('laporan'));
    }
}