<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $title ?? 'AmakaNutrition' }}
    </title>

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
        min-h-screen
        bg-[#F7F2EE]
        text-[#4B2E1F]
        font-['Inter']
    "
>

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <livewire:admin.layouts.admin-sidebar />

        {{-- CONTENU --}}
        <div
            class="
                flex-1
                flex
                flex-col
            "
        >

            {{-- TOPBAR --}}
            <div
                class="
                    sticky
                    top-0
                    z-20
                    bg-[#F7F2EE]/90
                    backdrop-blur-sm
                    border-b
                    border-[#EADFD3]
                "
            >
                <livewire:admin.layouts.admin-topbar />
            </div>

            {{-- PAGE --}}
            <main
                class="
                    flex-1
                    p-6
                    md:p-10
                "
            >

                <div
                    class="
                        max-w-7xl
                        mx-auto
                    "
                >

                    {{ $slot }}

                </div>

            </main>

        </div>

    </div>

    @livewireScripts

</body>

</html>