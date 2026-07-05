<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $title ?? 'AmakaNutrition' }}</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @livewireStyles

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-background text-primary font-body">

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <livewire:layouts.sidebar />

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col">

            {{-- TOPBAR --}}
            <livewire:layouts.topbar />

            {{-- CONTENT --}}
            <main class="p-8">

                {{ $slot }}

            </main>

        </div>

    </div>

    @livewireScripts

</body>
</html>