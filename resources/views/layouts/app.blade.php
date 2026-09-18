<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $title ?? 'AmakaNutrition' }}</title>

    {{-- VITE --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    {{-- GOOGLE FONTS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

    @livewireStyles

</head>

<body
    class="
        text-[#4B2E1F]
        font-['Inter']
    "
    style="background-color: #F7F1ED;"    
>

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <livewire:layouts.sidebar />

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col">

            {{-- TOPBAR --}}
            <livewire:layouts.topbar />

            {{-- PAGE --}}
            <main
                class="
                    flex-1
                    p-6
                    md:p-10
                "
            >

                {{ $slot }}

            </main>

        </div>

    </div>

    @livewireScripts

</body>
</html>