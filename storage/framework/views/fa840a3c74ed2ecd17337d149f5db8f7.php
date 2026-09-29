<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Parkir - E-Parkir</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <div class="min-h-screen flex flex-col">
        <!-- 🖥️ Top Navbar -->
        <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg px-6 py-4 flex justify-between items-center">
            <a href="<?php echo e(route('dashboard')); ?>" class="bg-blue-800 hover:bg-blue-900 px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                ⬅️ Kembali ke Dashboard
            </a>
            <h1 class="text-md font-black uppercase tracking-wider">Manajemen Area Parkir</h1>
            <span class="text-xs bg-blue-700 px-3 py-1 rounded-lg font-bold uppercase"><?php echo e(session('role')); ?></span>
        </nav>

        <!-- 📊 Main Content Area -->
        <main class="flex-1 p-6 max-w-5xl mx-auto w-full">
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span>🗺️</span> Daftar Kapasitas Slot Area Parkir
                </h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-50">
                                <th class="py-3 px-4">ID Area</th>
                                <th class="py-3 px-4">Nama Lokasi Area</th>
                                <th class="py-3 px-4 text-center">Total Kapasitas</th>
                                <th class="py-3 px-4">TERISI</th>
                            </tr>
                        </thead>
                                <tbody class="text-sm divide-y divide-slate-100 font-medium">
                                <?php $__empty_1 = true; $__currentLoopData = $area; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3.5 px-4 text-slate-400 font-bold">#<?php echo e($a->id_area); ?></td>
                                        <td class="py-3.5 px-4 font-black text-slate-800 tracking-wide uppercase"><?php echo e($a->nama_area); ?></td>
                                        
                                        <!-- 🛠️ UBAH BARIS INI SEPERTI DI BAWAH: -->
                                        <td class="py-3.5 px-4 text-blue-600 font-bold text-center">
                                            <?php echo e($a->kapasitas - $a->terisi); ?> Slot Tersisa
                                        </td>
                                        
                                        <!-- Menampilkan jumlah slot yang terisi -->
                                        <td class="py-3.5 px-4 text-orange-600 font-bold"><?php echo e($a->terisi); ?> Slot</td> 
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-slate-400">Data area parkir tidak ditemukan.</td>
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
<?php /**PATH C:\xii-reg\web-xii\parkir-xii-reguler\resources\views/admin/area.blade.php ENDPATH**/ ?>