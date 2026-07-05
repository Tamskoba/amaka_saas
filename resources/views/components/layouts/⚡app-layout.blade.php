<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <title>{{ $title ?? 'Amaka Nutrition' }}</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @livewireStyles
</head>

<body class="bg-[#F5F7FA] text-gray-800">

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <livewire:layouts.sidebar />

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col">

            {{-- TOPBAR --}}
            <livewire:layouts.topbar />

            {{-- PAGE CONTENT --}}
            <main class="p-6">

                {{ $slot }}

            </main>

        </div>

    </div>

    @livewireScripts

</body>
</html>