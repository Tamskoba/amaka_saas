<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Administration — Amaka Nutrition</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @livewireStyles

</head>

<body
    class="
        min-h-screen
        antialiased
    "
    style="
        background:#F7F2EE;
        color:#4B2E1F;
    "
>

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside
            class="
                shadow-[4px_0_30px_rgba(75,46,31,0.08)]
                z-20
            "
        >
            <livewire:admin.layouts.sidebar />
        </aside>

        {{-- CONTENU PRINCIPAL --}}
        <div
            class="
                flex-1
                flex
                flex-col
                min-h-screen
            "
        >

            {{-- TOPBAR --}}
            <header
                class="
                    sticky
                    top-0
                    z-10
                    bg-[#F7F2EE]/90
                    backdrop-blur-md
                    border-b
                    border-[#EADFD3]
                "
            >
                <livewire:admin.layouts.admin-topbar />
            </header>

            {{-- PAGE --}}
            <main
                class="
                    flex-1
                    p-6
                    lg:p-10
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