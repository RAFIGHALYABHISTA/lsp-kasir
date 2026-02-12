

<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-[#f4f7f6] px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
                Aplikasi Kasir
            </h2>
            <p class="text-gray-500 text-sm mt-1">Silakan masuk ke akun Anda</p>
        </div>

        <div class="bg-white p-8 border border-gray-200 rounded-lg shadow-sm">
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-5">
                    <label for="username" class="block text-xs font-semibold text-gray-600 uppercase mb-2">
                        Username
                    </label>
                    <input id="username" name="username" type="text" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded text-gray-900 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition-all"
                        placeholder="Contoh: admin123"
                        value="<?php echo e(old('username')); ?>">
                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-xs font-semibold text-gray-600 uppercase mb-2">
                        Password
                    </label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded text-gray-900 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition-all"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center mb-6">
                    <input id="remember" name="remember" type="checkbox" 
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat perangkat ini</label>
                </div>

                <button type="submit"
                    class="w-full bg-[#2563eb] hover:bg-[#1d4ed8] text-white font-semibold py-2.5 rounded text-sm transition-colors duration-200">
                    Masuk
                </button>
            </form>
        </div>

        <!-- <div class="text-center mt-6">
            <p class="text-xs text-gray-400">&copy; <?php echo e(date('Y')); ?> PT LAGUNAFRO. v1.0.0</p>
        </div> -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\gudang\resources\views/auth/login.blade.php ENDPATH**/ ?>