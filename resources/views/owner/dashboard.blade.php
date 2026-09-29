@extends('utama')

@section('content')
<div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
    <h1 class="text-2xl font-bold text-slate-800 mb-4">Laporan Owner</h1>
    <p class="text-slate-600 mb-6">Ringkasan pendapatan bulanan dan performa lahan parkir.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-6 bg-emerald-50 border border-emerald-200 rounded-2xl">
            <h3 class="font-semibold text-emerald-800">Pendapatan Hari Ini</h3>
            <p class="text-3xl font-bold text-emerald-900 mt-2">Rp 450.000</p>
        </div>
        <div class="p-6 bg-amber-50 border border-amber-200 rounded-2xl">
            <h3 class="font-semibold text-amber-800">Total Transaksi</h3>
            <p class="text-3xl font-bold text-amber-900 mt-2">1,240</p>
        </div>
    </div>
</div>
@endsection
