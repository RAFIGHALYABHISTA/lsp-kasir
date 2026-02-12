<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Kasir') - Sistem Kasir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Flash Messages Container -->
    <script type="application/json" id="flash-messages">
    {
        "success": @json(session('success')),
        "error": @json(session('error')),
        "warning": @json(session('warning')),
        "info": @json(session('info'))
    }
    </script>

    <div class="min-h-screen flex flex-col">
        <main class="flex-1">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>