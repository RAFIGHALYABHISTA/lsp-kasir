

<?php $__env->startSection('title', 'Kasir'); ?>
<?php $__env->startSection('subtitle', 'Sistem Kasir'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Product Grid -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-800">Daftar Produk</h2>
                <div class="relative">
                    <input type="text" placeholder="Cari produk..."
                           class="pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                <?php $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white border border-slate-200 rounded-xl p-4 hover:border-blue-500 hover:shadow-md transition-all group">
                    <div class="text-right mb-2">
                        <span class="px-2 py-1 rounded text-xs font-medium <?php echo e($b->stok < 10 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'); ?>">
                            Stok: <?php echo e($b->stok); ?>

                        </span>
                    </div>

                    <div class="text-center mb-4">
                        <div class="w-12 h-12 bg-slate-100 rounded-lg mx-auto mb-2 flex items-center justify-center text-slate-400">
                            <i class="fa-solid fa-box text-lg"></i>
                        </div>
                        <h3 class="font-semibold text-slate-800 text-sm mb-1"><?php echo e($b->nama_barang); ?></h3>
                        <p class="text-blue-600 font-bold">Rp <?php echo e(number_format($b->harga_barang, 0, ',', '.')); ?></p>
                    </div>

                    <form action="<?php echo e(route('admin.kasir.tambah')); ?>" method="POST" class="form-tambah-keranjang">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="produk_id" value="<?php echo e($b->id); ?>">
                        <input type="hidden" name="qty" value="1">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 rounded-lg transition-all">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah
                        </button>
                    </form>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Cart -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-800">Keranjang</h2>
                <span class="bg-blue-100 text-blue-600 text-sm px-3 py-1 rounded-full font-medium"><?php echo e(count($keranjang)); ?> item</span>
            </div>

            <div class="space-y-3 mb-6 max-h-96 overflow-y-auto">
                <?php $__empty_1 = true; $__currentLoopData = $keranjang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produk_id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                    <div class="flex-1">
                        <h4 class="font-medium text-slate-800 text-sm"><?php echo e($item['nama']); ?></h4>
                        <p class="text-slate-500 text-xs">Rp <?php echo e(number_format($item['harga'], 0, ',', '.')); ?></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <form action="<?php echo e(route('admin.kasir.tambah')); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="produk_id" value="<?php echo e($produk_id); ?>">
                            <input type="hidden" name="qty" value="-1">
                            <button type="submit" class="w-8 h-8 bg-slate-200 hover:bg-slate-300 rounded text-slate-600 text-sm font-bold">-</button>
                        </form>
                        <span class="w-8 text-center font-medium"><?php echo e($item['qty']); ?></span>
                        <form action="<?php echo e(route('admin.kasir.tambah')); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="produk_id" value="<?php echo e($produk_id); ?>">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="w-8 h-8 bg-slate-200 hover:bg-slate-300 rounded text-slate-600 text-sm font-bold">+</button>
                        </form>
                    </div>
                    <form action="<?php echo e(route('admin.kasir.hapus', $produk_id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-8 h-8 bg-red-100 hover:bg-red-200 rounded text-red-600 text-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-8 text-slate-400">
                    <i class="fa-solid fa-shopping-cart text-3xl mb-2"></i>
                    <p>Keranjang kosong</p>
                </div>
                <?php endif; ?>
            </div>

            <?php if(count($keranjang) > 0): ?>
            <div class="border-t border-slate-200 pt-4">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-medium text-slate-700">Total:</span>
                    <span class="text-xl font-bold text-blue-600">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                </div>

                    <form action="<?php echo e(route('admin.kasir.simpan')); ?>" method="POST" id="formBayar">
                        <?php echo csrf_field(); ?>
                        <div class="mb-4">
                            <label for="customer_id" class="block text-sm font-medium text-slate-700 mb-2">Customer (Opsional)</label>
                            <select name="customer_id" id="customer_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none">
                                <option value="">Pilih Customer</option>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($c->id); ?>"><?php echo e($c->nama); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg shadow-lg shadow-green-500/30 transition-all">
                            <i class="fa-solid fa-credit-card mr-2"></i> Bayar Sekarang
                        </button>
                    </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Loading untuk tambah ke keranjang
        const formsTambah = document.querySelectorAll('.form-tambah-keranjang');
        formsTambah.forEach(form => {
            form.addEventListener('submit', () => {
                notify.loading('Menambahkan ke keranjang...', 'Mohon tunggu');
            });
        });

        // Loading untuk pembayaran
        const formBayar = document.getElementById('formBayar');
        if (formBayar) {
            formBayar.addEventListener('submit', () => {
                notify.loading('Memproses pembayaran...', 'Mohon tunggu');
            });
        }

        // Loading untuk update qty (+ dan -)
        const updateForms = document.querySelectorAll('form[action*="tambah"]');
        updateForms.forEach(form => {
            // Skip form tambah barang dari produk grid
            if (!form.classList.contains('form-tambah-keranjang')) {
                form.addEventListener('submit', () => {
                    notify.loading('Memperbarui keranjang...', 'Mohon tunggu');
                });
            }
        });

        // Confirm delete dengan sweet alert
        const deleteForms = document.querySelectorAll('form[method="POST"] button[type="submit"][class*="red"]');
        deleteForms.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const form = btn.closest('form');
                if (form && form.querySelector('input[name="_method"][value="DELETE"]')) {
                    e.preventDefault();
                    notify.confirm('Hapus Produk?', 'Produk akan dihapus dari keranjang').then((result) => {
                        if (result.isConfirmed) {
                            notify.loading('Menghapus...', 'Mohon tunggu');
                            form.submit();
                        }
                    });
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\gudang\resources\views/kasir/index.blade.php ENDPATH**/ ?>