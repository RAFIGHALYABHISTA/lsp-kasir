

<?php $__env->startSection('title', 'Kelola Return/Kembalian'); ?>
<?php $__env->startSection('subtitle', 'Kelola produk yang dikembalikan pelanggan'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        <span class="text-sm font-medium"><?php echo e(session('success')); ?></span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
        <h2 class="font-bold text-slate-800">Daftar Return/Kembalian</h2>
        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">
            Total: <?php echo e(count($returns)); ?> Return
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                    <th class="px-6 py-4">ID Transaksi</th>
                    <th class="px-6 py-4">Produk</th>
                    <th class="px-6 py-4 text-center">Qty</th>
                    <th class="px-6 py-4 text-center">Total Return</th>
                    <th class="px-6 py-4">Alasan</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50/80 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-slate-700">
                            #TRX-<?php echo e($return->transaksi->id); ?>

                        </div>
                        <div class="text-xs text-slate-400">
                            <?php echo e($return->tanggal_return->format('d M Y H:i')); ?>

                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-800"><?php echo e($return->barang->nama_barang); ?></div>
                        <div class="text-xs text-slate-400">Kode: <?php echo e($return->barang->kode_barang ?? '-'); ?></div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-semibold text-slate-800"><?php echo e($return->qty); ?></span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 text-sm font-bold rounded-full">
                            Rp <?php echo e(number_format($return->total_return, 0, ',', '.')); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-600"><?php echo e($return->alasan ?? '-'); ?></p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?php if($return->status == 'pending'): ?>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">
                                Pending
                            </span>
                        <?php elseif($return->status == 'approved'): ?>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                Disetujui
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">
                                Ditolak
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <?php if($return->status == 'pending'): ?>
                                <form action="<?php echo e(route('admin.returns.approve', $return->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Setujui return ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <button type="submit" class="text-green-600 hover:text-green-700 text-sm" title="Setujui">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                                <form action="<?php echo e(route('admin.returns.reject', $return->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Tolak return ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm" title="Tolak">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <form action="<?php echo e(route('admin.returns.destroy', $return->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Hapus return ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-700 text-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                        <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                        <div>Belum ada return</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\gudang\resources\views/admin/returns.blade.php ENDPATH**/ ?>