<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log Aktivitas - E-Parkir</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg px-6 py-4 flex justify-between items-center">
            <a href="<?php echo e(route('dashboard')); ?>" class="bg-blue-800 hover:bg-blue-900 px-4 py-2 rounded-xl text-xs font-bold transition">
                ⬅️ Kembali ke Dashboard
            </a>
            <h1 class="text-md font-black uppercase tracking-wider">Audit Log Aktivitas Sistem</h1>
            <span class="text-xs bg-blue-700 px-3 py-1 rounded-lg font-bold uppercase"><?php echo e(session('role')); ?></span>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 max-w-6xl mx-auto w-full">
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2"><span>📜</span> Jejak Aktivitas Pengguna & Petugas</h3>

                <?php if(count($logs) > 0): ?>
                    <form action="<?php echo e(route('admin.log.hapusSemua')); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus SEMUA log aktivitas? Tindakan ini tidak bisa dibatalkan!')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold px-4 py-2 rounded-xl text-xs shadow-sm transition">
                            🗑️ Hapus Semua Log
                        </button>
                    </form>
                <?php endif; ?>
            </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-bold uppercase text-slate-400 bg-slate-50">
                                <th class="py-3 px-4">Waktu Kejadian</th>
                                <th class="py-3 px-4">Nama Pelaku</th>
                                <th class="py-3 px-4">Detail Aktivitas</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100 font-medium">
                            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 text-slate-400 text-xs">
                                        📅 <?php echo e(date('d M Y, H:i:s', strtotime($log->waktu_aktivitas))); ?> WIB
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-800 font-bold">
                                        <div><?php echo e($log->nama_lengkap); ?></div>
                                        
                                        <!-- Penambahan Badge Keterangan Peran/Role secara Dinamis -->
                                        <?php if($log->role == 'admin'): ?>
                                            <span class="inline-block mt-1 px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-red-50 text-red-600 border border-red-200">
                                                🛡️ Admin
                                            </span>
                                        <?php elseif($log->role == 'petugas'): ?>
                                            <span class="inline-block mt-1 px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-blue-50 text-blue-600 border border-blue-200">
                                                💼 Petugas
                                            </span>
                                        <?php elseif($log->role == 'owner'): ?>
                                            <span class="inline-block mt-1 px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-amber-50 text-amber-600 border border-amber-200">
                                                👑 Owner
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-block mt-1 px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-slate-100 text-slate-600 border border-slate-200">
                                                ❓ Pengguna
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-1 rounded-md text-xs bg-slate-100 text-slate-600 border border-slate-200/60 font-normal"><?php echo e($log->aktivitas); ?></span></td>
                                    <td class="py-3.5 px-4 text-center">
                                        <form action="<?php echo e(route('admin.log.hapus', $log->id_log)); ?>" method="POST" onsubmit="return confirm('Hapus riwayat log aktivitas ini?')" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold px-4 py-1.5 rounded-xl text-xs shadow-sm transition">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-slate-400 font-normal">📭 Belum ada riwayat aktivitas yang tercatat.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
<?php /**PATH C:\xii-reg\web-xii\parkir-xii-reguler\resources\views/admin/log.blade.php ENDPATH**/ ?>