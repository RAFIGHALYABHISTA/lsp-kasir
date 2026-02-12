

<?php $__env->startSection('title', 'Manajemen Refund'); ?>
<?php $__env->startSection('subtitle', 'Kelola permintaan refund customer'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        <span class="text-sm font-medium"><?php echo e(session('success')); ?></span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-white">
        <h2 class="font-bold text-slate-800">Daftar Permintaan Refund (<?php echo e(count($refunds)); ?>)</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                    <th class="px-6 py-4">Invoice & Customer</th>
                    <th class="px-6 py-4">Jumlah Refund</th>
                    <th class="px-6 py-4">Alasan</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $refunds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $refund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50/80 transition-colors group">
                    <td class="px-6 py-4">
                        <h4 class="font-semibold text-slate-800">#INV-<?php echo e(str_pad($refund->transaksi->id, 6, '0', STR_PAD_LEFT)); ?></h4>
                        <p class="text-xs text-slate-400 mt-1"><?php echo e($refund->transaksi->customer?->nama ?? 'Guest'); ?></p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-slate-800">Rp <?php echo e(number_format($refund->jumlah_refund, 0, ',', '.')); ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-600"><?php echo e($refund->alasan ?? '-'); ?></p>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($refund->status === 'pending'): ?>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">Pending</span>
                        <?php elseif($refund->status === 'approved'): ?>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">Disetujui</span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Ditolak</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        <?php echo e($refund->tanggal_refund->format('d/m/Y H:i')); ?>

                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <?php if($refund->status === 'pending'): ?>
                                <form action="<?php echo e(route('admin.refunds.approve', $refund->id)); ?>" method="POST" class="inline" @submit.prevent="approveRefund($el)" x-data="{ approveRefund(form) { if(confirm('Setujui refund ini?')) { Swal.fire({ title: 'Memproses...', text: 'Mohon tunggu', didOpen: () => Swal.showLoading(), allowOutsideClick: false, allowEscapeKey: false }); form.submit(); } } }">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <button type="submit" class="text-emerald-600 hover:text-emerald-700 text-sm">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                                <form action="<?php echo e(route('admin.refunds.reject', $refund->id)); ?>" method="POST" class="inline" @submit.prevent="rejectRefund($el)" x-data="{ rejectRefund(form) { if(confirm('Tolak refund ini?')) { Swal.fire({ title: 'Memproses...', text: 'Mohon tunggu', didOpen: () => Swal.showLoading(), allowOutsideClick: false, allowEscapeKey: false }); form.submit(); } } }">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <button type="submit" class="text-orange-600 hover:text-orange-700 text-sm">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <form action="<?php echo e(route('admin.refunds.destroy', $refund->id)); ?>" method="POST" class="inline" @submit.prevent="deleteRefund($el)" x-data="{ deleteRefund(form) { if(confirm('Hapus record refund ini?')) { form.submit(); } } }">
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
                    <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                        Belum ada permintaan refund
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\gudang\resources\views/admin/refunds.blade.php ENDPATH**/ ?>