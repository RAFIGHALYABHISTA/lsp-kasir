<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - Sistem Kasir</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="application/json" id="flash-messages">
    {
        "success": <?php echo json_encode(session('success'), 15, 512) ?>,
        "error": <?php echo json_encode(session('error'), 15, 512) ?>,
        "warning": <?php echo json_encode(session('warning'), 15, 512) ?>,
        "info": <?php echo json_encode(session('info'), 15, 512) ?>
    }
    </script>
    <style>
        :root {
            --sidebar-width: 260px;
            --bg-dark: #111827;
            --bg-light-dark: #1f2937;
            --accent-color: #3b82f6;
            --text-gray: #9ca3af;
            --text-white: #ffffff;
        }

        body {
            margin: 0 !important;
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            display: flex !important;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--bg-dark);
            color: var(--text-white);
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 25px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--bg-light-dark);
        }

        .logo-icon {
            width: 35px;
            height: 35px;
            background: var(--accent-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
        }

        .logo-text {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            flex-grow: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .menu-label {
            padding: 0 25px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #4b5563;
            margin-bottom: 15px;
            display: block;
        }

        .menu-item {
            list-style: none;
            margin: 4px 15px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text-gray);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .menu-link i {
            width: 25px;
            font-size: 18px;
        }

        .menu-link:hover {
            background-color: var(--bg-light-dark);
            color: var(--text-white);
        }

        .menu-link.active {
            background-color: var(--accent-color);
            color: var(--text-white);
        }

        .sidebar-footer {
            padding: 20px;
            background-color: #0f172a;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #4b5563;
        }

        .user-info {
            font-size: 13px;
        }

        .user-name {
            display: block;
            font-weight: 600;
        }

        .user-role {
            color: var(--text-gray);
            font-size: 11px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
        }

        .content-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .logo-text, .menu-link span, .menu-label, .user-info { display: none; }
            .main-content { margin-left: 70px; width: calc(100% - 70px); }
            .menu-link i { margin: 0; width: auto; }
            .menu-link { justify-content: center; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">G</div>
            <span class="logo-text">CASHIER APP</span>
        </div>

        <nav class="sidebar-menu">
            <span class="menu-label">Main Menu</span>
            <li class="menu-item">
                <a href="<?php echo e(route('admin.index')); ?>" class="menu-link <?php echo e(request()->routeIs('admin.index') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?php echo e(route('admin.inventory')); ?>" class="menu-link <?php echo e(request()->routeIs('admin.inventory') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-box-archive"></i>
                    <span>Inventory</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?php echo e(route('admin.kasir')); ?>" class="menu-link <?php echo e(request()->routeIs('admin.kasir') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Kasir</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?php echo e(route('admin.customers')); ?>" class="menu-link <?php echo e(request()->routeIs('admin.customers*') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-users"></i>
                    <span>Customer</span>
                </a>
            </li>

            <span class="menu-label" style="margin-top: 25px;">Reports & Stats</span>
            <li class="menu-item">
                <a href="<?php echo e(route('admin.laporan')); ?>" class="menu-link <?php echo e(request()->routeIs('admin.laporan') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <span class="menu-label" style="margin-top: 25px;">Settings</span>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="fa-solid fa-gear"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        </nav>

        <div class="sidebar-footer">
            <img src="https://ui-avatars.com/api/?name=<?php echo e(Auth::user()->name); ?>&background=3b82f6&color=fff" alt="Avatar" class="user-avatar">
            <div class="user-info">
                <span class="user-name"><?php echo e(Auth::user()->name); ?></span>
                <span class="user-role">Administrator</span>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin-left: auto;">
                <?php echo csrf_field(); ?>
                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <div class="content-header">
            <h1 class="page-title"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
            <p class="page-subtitle"><?php echo $__env->yieldContent('subtitle', 'Kelola sistem gudang Anda'); ?></p>
        </div>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

</body>
</html><?php /**PATH D:\laragon\www\gudang\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>