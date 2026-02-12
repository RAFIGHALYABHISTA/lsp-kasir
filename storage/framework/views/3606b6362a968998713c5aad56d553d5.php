

<?php $__env->startSection('title', 'Laporan Pendapatan Bulanan'); ?>
<?php $__env->startSection('subtitle', 'Analisis pendapatan berdasarkan bulan dan kategori'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Total Pendapatan -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm font-medium">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-2">
                    Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?>

                </h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-money-bill-wave text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Transaksi -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm font-medium">Total Transaksi</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-2"><?php echo e($totalTransaksi); ?></h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-shopping-cart text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Rata-rata Transaksi -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm font-medium">Rata-rata Transaksi</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-2">
                    Rp <?php echo e($totalTransaksi > 0 ? number_format($totalPendapatan / $totalTransaksi, 0, ',', '.') : '0'); ?>

                </h3>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-chart-line text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
    <form action="<?php echo e(route('admin.pendapatan')); ?>" method="GET" class="flex items-end gap-4">
        <div>
            <label for="bulan" class="block text-sm font-semibold text-slate-700 mb-2">Bulan</label>
            <select name="bulan" id="bulan" class="px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none">
                <option value="">Pilih Bulan</option>
                <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($m); ?>" <?php echo e($m == $bulan ? 'selected' : ''); ?>>
                        <?php echo e(['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$m]); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label for="tahun" class="block text-sm font-semibold text-slate-700 mb-2">Tahun</label>
            <select name="tahun" id="tahun" class="px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none">
                <option value="">Pilih Tahun</option>
                <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($y); ?>" <?php echo e($y == $tahun ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all">
            <i class="fa-solid fa-filter mr-1"></i> Filter
        </button>
        <a href="<?php echo e(route('admin.pendapatan.export', ['bulan' => $bulan, 'tahun' => $tahun])); ?>" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all">
            <i class="fa-solid fa-download mr-1"></i> Export CSV
        </a>
    </form>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Pendapatan Per Kategori -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="font-bold text-slate-800 mb-4">Pendapatan Per Kategori</h3>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $pendapatanPerKategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <p class="font-medium text-slate-800"><?php echo e($kategori); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-slate-800">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></p>
                        <p class="text-xs text-slate-400">
                            <?php echo e($totalPendapatan > 0 ? round(($total / $totalPendapatan) * 100, 1) : 0); ?>% dari total
                        </p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-slate-400 py-4">Tidak ada data untuk periode ini</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Statistik Cepat -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="font-bold text-slate-800 mb-4">Statistik</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center py-2 border-b border-slate-100">
                <span class="text-slate-600">Bulan</span>
                <span class="font-semibold">
                    <?php echo e(['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'][$bulan] ?? 'Semua'); ?>

                </span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-slate-100">
                <span class="text-slate-600">Tahun</span>
                <span class="font-semibold"><?php echo e($tahun ?? 'Semua'); ?></span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-slate-100">
                <span class="text-slate-600">Kategori</span>
                <span class="font-semibold"><?php echo e(count($pendapatanPerKategori)); ?></span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-slate-600">Periode</span>
                <span class="font-semibold text-blue-600"><?php echo e(\Carbon\Carbon::now()->format('d M Y')); ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Detail Transaksi -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mt-6">
    <div class="px-6 py-4 border-b border-slate-100 bg-white">
        <h2 class="font-bold text-slate-800">Detail Transaksi (<?php echo e(count($transaksis)); ?>)</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="bg-slate-50/50 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">ID Transaksi</th>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4 text-center">Items</th>
                    <th class="px-6 py-4 text-center">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaksi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-medium text-slate-700"><?php echo e($transaksi->tanggal_transaksi->format('d M Y')); ?></span>
                        <span class="text-xs text-slate-400 ml-2"><?php echo e($transaksi->tanggal_transaksi->format('H:i')); ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-slate-700">#TRX-<?php echo e($transaksi->id); ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-slate-700"><?php echo e($transaksi->customer?->nama ?? 'Guest'); ?></span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-slate-700"><?php echo e($transaksi->transaksiDetails->count()); ?></span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-bold rounded-full">
                            Rp <?php echo e(number_format($transaksi->total, 0, ',', '.')); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                        Tidak ada transaksi untuk periode ini
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\gudang\resources\views/admin/pendapatan.blade.php ENDPATH**/ ?>