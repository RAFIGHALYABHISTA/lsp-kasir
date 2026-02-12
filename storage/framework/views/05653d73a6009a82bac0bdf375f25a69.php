

<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('subtitle', 'Kelola stok dan data barang gudang secara terpusat'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
                
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-colors hover:border-blue-300 h-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Barang</p>
                            <p class="text-2xl font-bold text-slate-900"><?php echo e(count($barangs)); ?></p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <i class="fa-solid fa-box-archive text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
        </div>

        
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-all hover:border-red-300 hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Barang Habis</p>
                    <p class="text-3xl font-bold text-red-600 mt-1"><?php echo e($barangs->where('stok', '<=', 0)->count()); ?></p>
                </div>
                <div class="p-4 bg-red-50 rounded-xl">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>

        
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-all hover:border-orange-300 hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Stok Rendah</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1"><?php echo e($barangs->where('stok', '>', 0)->where('stok', '<=', 10)->count()); ?></p>
                </div>
                <div class="p-4 bg-orange-50 rounded-xl">
                    <i class="fa-solid fa-arrow-trend-down text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>

        
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-bold text-slate-900">
                        <span class="text-base font-normal text-slate-400">Rp</span> <?php echo e(number_format($dailyRevenue ?? 0, 0, ',', '.')); ?>

                    </p>
                    <div class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">
                        <i class="fa-solid fa-arrow-up-right-dots mr-1"></i> <?php echo e($dailyCount ?? 0); ?> Transaksi
                    </div>
                </div>
                <div class="p-4 bg-emerald-50 rounded-xl">
                    <i class="fa-solid fa-receipt text-emerald-600 text-2xl"></i>
                </div>
            </div>
        </div>

        
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold text-slate-900">
                        <span class="text-base font-normal text-slate-400">Rp</span> <?php echo e(number_format($monthlyRevenue ?? 0, 0, ',', '.')); ?>

                    </p>
                    <div class="inline-flex items-center px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-medium">
                        <i class="fa-solid fa-calendar-check mr-1"></i> <?php echo e($monthlyCount ?? 0); ?> Transaksi
                    </div>
                </div>
                <!-- <div class="p-4 bg-indigo-50 rounded-xl">
                    <i class="fa-solid fa-calendar-alt text-indigo-600 text-2xl"></i>
                </div>
            </div>
        </div>

        
        <div class="hidden lg:block border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50"></div>
    </div> -->

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('click', function (event) {
            const btn = event.target.closest('.btn-delete-barang');
            if (!btn) return;

            const { formId, barangName } = btn.dataset;
            
            Swal.fire({
                title: 'Hapus Barang?',
                html: `Apakah Anda yakin ingin menghapus <b>"${barangName}"</b>?<br><small class="text-gray-500">Tindakan ini tidak bisa dibatalkan.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Sekarang',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang Memproses',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                    document.getElementById(`form-delete-${formId}`).submit();
                }
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\gudang\resources\views/admin/index.blade.php ENDPATH**/ ?>