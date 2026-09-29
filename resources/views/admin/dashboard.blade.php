@extends('utama') {{-- Atau layout utama Anda --}}

@section('content')
<div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
    <h1 class="text-2xl font-bold text-slate-800 mb-4">Dashboard Admin</h1>
    <p class="text-slate-600 mb-6">Selamat datang kembali, Admin! Berikut ringkasan sistem E-Parkir.</p>

    <!-- Grid Menu Ringkasan Admin -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-blue-50 border border-blue-200 rounded-2xl">
            <h3 class="font-semibold text-blue-800">Total Kendaraan</h3>
            <p class="text-3xl font-bold text-blue-900 mt-2">120</p>
        </div>
        <div class="p-6 bg-green-50 border border-green-200 rounded-2xl">
            <h3 class="font-semibold text-green-800">Petugas Aktif</h3>
            <p class="text-3xl font-bold text-green-900 mt-2">5</p>
        </div>
        <div class="p-6 bg-purple-50 border border-purple-200 rounded-2xl">
            <h3 class="font-semibold text-purple-800">Pengaturan Tarif</h3>
            <p class="text-sm text-purple-600 mt-2">Kelola biaya parkir di sini</p>
        </div>
    </div>
</div>
@endsection
