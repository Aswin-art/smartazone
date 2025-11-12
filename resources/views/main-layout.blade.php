<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartAzone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/rellax@1.12.1/rellax.min.js"></script>
</head>

<body class="min-h-screen relative overflow-x-hidden bg-black/90">
    <!-- Content Layer with Container - Linktree Style -->
    <div class="relative z-10 min-h-screen md:flex md:items-center md:justify-center md:p-8 md:py-12">
        <!-- Content Container - Full on Mobile, Rounded Card on Desktop -->
        <div class="w-full md:max-w-lg md:rounded-3xl md:shadow-2xl md:overflow-hidden">
            @yield('content')
        </div>
    </div>
</body>

</html>
