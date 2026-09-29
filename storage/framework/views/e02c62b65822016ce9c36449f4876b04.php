<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - E-Parkir</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white shadow-lg px-6 py-4 flex justify-between items-center">
            <a href="<?php echo e(route('dashboard')); ?>" class="bg-blue-900 hover:bg-blue-950 px-4 py-2 rounded-xl text-xs font-bold transition">
                ⬅️ Kembali ke Dashboard
            </a>
            <h1 class="text-md font-black uppercase tracking-wider">Laporan Rekapitulasi Pendapatan</h1>
            <span class="text-xs bg-blue-600 px-3 py-1 rounded-lg font-bold uppercase"><?php echo e(session('role')); ?></span>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 max-w-5xl mx-auto w-full">
            
            <!-- Widget Total Pendapatan -->
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-6 rounded-3xl text-white shadow-xl mb-8 flex justify-between items-center">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-blue-200">Total Uang Parkir Masuk (Selesai)</h3>
                    <div class="text-3xl font-black mt-1">
                        Rp <?php echo e(number_format($laporan->sum('biaya_total'), 0, ',', '.')); ?>

                    </div>
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
                            <?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 font-black tracking-wide uppercase"><?php echo e($l->plat_nomor); ?></td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md text-xs font-bold uppercase bg-slate-100 text-slate-600"><?php echo e($l->jenis_kendaraan); ?></span></td>
                                    <td class="py-3.5 px-4 text-slate-500 text-xs"><?php echo e($l->durasi_jam); ?> Jam</td>
                                    <td class="py-3.5 px-4 text-right font-bold text-blue-600">Rp <?php echo e(number_format($l->biaya_total, 0, ',', '.')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="py-8 px-4 text-center text-slate-400 text-xs italic">
                                        Belum ada data rekapitulasi pendapatan kendaraan selesai parkir.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html><?php /**PATH C:\xii-reg\web-xii\parkir-xii-reguler\resources\views/owner/rekap.blade.php ENDPATH**/ ?>