

<?php $__env->startSection('title', 'Kasir'); ?>
<?php $__env->startSection('subtitle', 'Sistem Kasir'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Section -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Kasir - Form Cepat</h2>

            <form action="<?php echo e(route('admin.kasir.simpan')); ?>" method="POST" id="kasirForm">
                <?php echo csrf_field(); ?>

                <input type="hidden" name="produk_id" id="form_produk_id">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Pelanggan</label>
                    <input type="text" name="customer_name" id="customer_name" placeholder="Nama pelanggan (opsional)" class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">No. Telepon</label>
                    <input type="text" name="customer_phone" id="customer_phone" placeholder="No. telepon (opsional)" class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="customer_email" id="customer_email" placeholder="Email (opsional)" class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                    <input type="text" name="customer_address" id="customer_address" placeholder="Alamat (opsional)" class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Produk Terpilih</label>
                    <div id="selectedProduct" class="p-3 border border-dashed border-slate-200 rounded-lg text-slate-500">Belum ada produk dipilih</div>
                </div>

                <input type="hidden" name="harga" id="form_harga">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah (Qty)</label>
                    <input type="number" name="qty" id="form_qty" value="1" min="1" class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none">
                    <div id="stokInfo" class="text-xs text-slate-400 mt-1">Stok tersedia: -</div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Uang Pelanggan (Rp)</label>
                    <input type="number" name="uang_pelanggan" id="form_uang" value="0" step="0.01" min="0" class="w-full px-3 py-2 border border-slate-200 rounded-lg outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Total</label>
                    <div id="form_total" class="text-xl font-bold text-blue-600">Rp 0</div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kembalian</label>
                    <div id="form_kembalian" class="text-lg font-semibold text-green-600">Rp 0</div>
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg">Bayar & Simpan</button>
            </form>
        </div>
    </div>

    <!-- Product Menu -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-800">Menu Produk</h2>
                <div class="relative">
                    <input type="text" id="searchProduk" placeholder="Cari produk..." class="pl-10 pr-4 py-2 border border-slate-200 rounded-lg outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                <?php $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="cursor-pointer produk-card p-4 border border-slate-100 rounded-lg text-center" data-id="<?php echo e($b->id); ?>" data-nama="<?php echo e($b->nama_barang); ?>" data-harga="<?php echo e($b->harga_barang); ?>" data-stok="<?php echo e($b->stok); ?>">
                    <div class="w-full h-36 bg-slate-100 rounded-lg mb-3 flex items-center justify-center text-slate-400">
                        <!-- Placeholder image/icon -->
                        <div class="text-center">
                            <i class="fa-solid fa-box-open text-3xl"></i>
                            <div class="text-sm mt-2 font-semibold text-slate-700"><?php echo e($b->nama_barang); ?></div>
                        </div>
                    </div>
                    <div class="text-sm text-slate-500">Stok: <?php echo e($b->stok); ?></div>
                    <div class="text-lg font-bold text-blue-600">Rp <?php echo e(number_format($b->harga_barang,0,',','.')); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Product selection from menu
    document.querySelectorAll('.produk-card').forEach(card => {
        card.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const harga = this.dataset.harga;
            const stok = this.dataset.stok;

            document.getElementById('form_produk_id').value = id;
            document.getElementById('selectedProduct').innerHTML = '<div class="font-semibold">'+nama+'</div><div class="text-xs text-slate-500">Harga: Rp '+(Number(harga).toLocaleString('id-ID'))+'</div>';
            document.getElementById('form_harga').value = harga;
            document.getElementById('form_qty').value = 1;
            document.getElementById('stokInfo').innerText = 'Stok tersedia: ' + stok;
            updateTotal();
        });
    });

    // Search
    document.getElementById('searchProduk').addEventListener('keyup', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.produk-card').forEach(card => {
            const name = card.dataset.nama.toLowerCase();
            card.style.display = name.includes(q) ? '' : 'none';
        });
    });

    function formatRp(v){
        return 'Rp ' + Number(v).toLocaleString('id-ID');
    }

    function updateTotal(){
        const qty = Number(document.getElementById('form_qty').value || 0);
        const harga = Number(document.getElementById('form_harga').value || 0);
        const uang = Number(document.getElementById('form_uang').value || 0);
        const total = qty * harga;
        const kembalian = uang - total;
        document.getElementById('form_total').innerText = formatRp(total);
        document.getElementById('form_kembalian').innerText = formatRp(kembalian >= 0 ? kembalian : 0);
    }

    ['form_qty','form_uang'].forEach(id => {
        document.getElementById(id).addEventListener('input', updateTotal);
    });

    // prevent submit without product
    document.getElementById('kasirForm').addEventListener('submit', function(e){
        if(!document.getElementById('form_produk_id').value){
            e.preventDefault();
            alert('Pilih produk terlebih dahulu dari daftar produk.');
            return false;
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\gudang\resources\views/kasir/index.blade.php ENDPATH**/ ?>