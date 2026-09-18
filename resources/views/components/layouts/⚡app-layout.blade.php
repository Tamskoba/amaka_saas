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

<body class="text-gray-800" style="background-color: #F7F1ED;">

    <div class="flex min-h-screen" style="background-color: #F7F1ED;">

        {{-- SIDEBAR --}}
        <livewire:layouts.sidebar />

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col" style="background-color: #F7F1ED;">

            {{-- TOPBAR --}}
            <livewire:layouts.topbar />

            {{-- PAGE CONTENT --}}
            <main class="p-6" style="background-color: #F7F1ED;">

                {{ $slot }}

            </main>

        </div>

    </div>

    @livewireScripts

</body>
</html>