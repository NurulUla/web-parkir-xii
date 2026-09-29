@extends('utama')

@section('content')
<div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
    <h1 class="text-2xl font-bold text-slate-800 mb-4">Dashboard Petugas</h1>
    <p class="text-slate-600 mb-6">Menu input kendaraaan masuk dan keluar.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="#" class="p-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-center block transition">
            <span class="block text-lg font-semibold">Parkir Masuk (Check-In)</span>
        </a>
        <a href="#" class="p-6 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl text-center block transition">
            <span class="block text-lg font-semibold">Parkir Keluar (Check-Out)</span>
        </a>
    </div>
</div>
@endsection
