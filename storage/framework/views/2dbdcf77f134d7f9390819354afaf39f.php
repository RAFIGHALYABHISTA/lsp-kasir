<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Aplikasi Kasir'); ?> - Sistem Kasir</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50">
    <!-- Flash Messages Container -->
    <script type="application/json" id="flash-messages">
    {
        "success": <?php echo json_encode(session('success'), 15, 512) ?>,
        "error": <?php echo json_encode(session('error'), 15, 512) ?>,
        "warning": <?php echo json_encode(session('warning'), 15, 512) ?>,
        "info": <?php echo json_encode(session('info'), 15, 512) ?>
    }
    </script>

    <div class="min-h-screen flex flex-col">
        <main class="flex-1">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\laragon\www\gudang\resources\views/layouts/app.blade.php ENDPATH**/ ?>