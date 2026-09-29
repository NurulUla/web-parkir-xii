<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Login
    public function showLogin() {
        return view('auth.login');
    }

    // 2. Memproses Logika Login
    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari user di database
        $user = DB::table('tb_user')
            ->where('username', $request->username)
            ->where('password', $request->password)
            ->where('status_aktif', 1)
            ->first();

        if ($user) {
            // Simpan data ke session (Disamakan menjadi 'id_user' agar sinkron ✨)
            session([
                'id_user' => $user->id_user, 
                'role' => $user->role, 
                'nama' => $user->nama_lengkap
            ]);
            
            // Catat log aktivitas login
            DB::table('tb_log_aktivitas')->insert([
                'id_user' => $user->id_user,
                'aktivitas' => 'User berhasil login ke sistem',
                'waktu_aktivitas' => now()
            ]);

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    // 3. Memproses Logout
    public function logout() {
        // ✨ TAMBAHKAN CATATAN LOG LOGOUT SEBELUM SESSION DIHAPUS
        if (session()->has('id_user')) {
            DB::table('tb_log_aktivitas')->insert([
                'id_user' => session('id_user'),
                'aktivitas' => 'User berhasil logout dari sistem',
                'waktu_aktivitas' => now()
            ]);
        }

        // Hapus session dan keluar
        session()->flush();
        return redirect()->route('login')->with('error', 'Anda telah keluar dari sistem.');
    }
}
