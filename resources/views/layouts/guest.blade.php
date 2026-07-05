<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @livewireStyles

</head>

<body
    class="
        min-h-screen
        bg-[#F5EFE9]
        antialiased
    "
>

    {{ $slot }}

    @livewireScripts

</body>

</html>

    <div
        class="
            min-h-screen
            grid
            md:grid-cols-2
        "
    >

        {{-- LEFT SIDE --}}
        <div
            class="
                hidden
                md:flex
                relative
                overflow-hidden
                bg-[#4B2E1F]
                text-white
                p-16
                flex-col
                justify-between
            "
        >

            {{-- BACKGROUND --}}
            <div
                class="
                    absolute
                    inset-0
                    bg-gradient-to-br
                    from-[#4B2E1F]
                    via-[#6B4A3A]
                    to-[#C87A2A]
                    opacity-95
                "
            ></div>

            {{-- DECORATION --}}
            <div
                class="
                    absolute
                    -top-24
                    -right-24
                    w-96
                    h-96
                    rounded-full
                    bg-white/10
                "
            ></div>

            <div
                class="
                    absolute
                    bottom-0
                    left-0
                    w-72
                    h-72
                    rounded-full
                    bg-white/5
                "
            ></div>

            {{-- CONTENT --}}
            <div class="relative z-10">

                <h1
                    class="
                        text-6xl
                        leading-tight
                        font-heading
                        mb-8
                    "
                >
                    Amaka
                    Nutrition
                </h1>

                <p
                    class="
                        text-2xl
                        leading-relaxed
                        max-w-xl
                        text-white/90
                    "
                >
                    Une approche scientifique,
                    humaine et personnalisée
                    de votre bien-être.
                </p>

            </div>

            {{-- FOOTER --}}
            <div
                class="
                    relative
                    z-10
                    text-white/70
                "
            >
                Nutrition • Micronutrition • Équilibre
            </div>

        </div>

        {{-- RIGHT SIDE --}}
        <div
            class="
                flex
                items-center
                justify-center
                p-6
                md:p-16
            "
        >

            <div
                class="
                    w-full
                    max-w-md
                "
            >

                {{-- MOBILE LOGO --}}
                <div class="md:hidden mb-10 text-center">

                    <h1
                        class="
                            text-4xl
                            font-heading
                            text-[#4B2E1F]
                        "
                    >
                        AmakaNutrition
                    </h1>

                </div>

                {{-- CARD --}}
                <div
                    class="
                        bg-white
                        rounded-[32px]
                        shadow-[0_10px_40px_rgba(0,0,0,0.05)]
                        p-8
                        md:p-10
                    "
                >

                    {{ $slot }}

                </div>

            </div>

        </div>

    </div>

</body>
</html>