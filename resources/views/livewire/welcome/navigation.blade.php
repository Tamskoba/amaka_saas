<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Amaka Nutrition</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >

</head>

<body
    class="
        bg-[#FDF8F4]
        text-[#4B2E1F]
        font-['Inter']
    "
>

<div
    class="
        min-h-screen
        flex
        flex-col
    "
>

    {{-- NAVBAR --}}
    <header
        class="
            flex
            justify-between
            items-center
            px-10
            py-6
        "
    >

        <div>

            <h1
                class="
                    text-4xl
                    font-['Playfair_Display']
                "
            >
                Amaka
            </h1>

            <p class="text-[#8A5A44]">
                Nutrition & Équilibre
            </p>

        </div>

        <a
            href="{{ route('login') }}"
            class="
                px-6
                py-3
                rounded-2xl
                bg-[#C87A2A]
                hover:bg-[#B56F22]
                text-white
                font-semibold
                transition
            "
        >
            Se connecter
        </a>

    </header>

    {{-- HERO --}}
    <section
        class="
            flex-1
            flex
            items-center
            justify-center
            px-8
        "
    >

        <div
            class="
                max-w-3xl
                text-center
            "
        >

            <h2
                class="
                    text-6xl
                    font-['Playfair_Display']
                    leading-tight
                    mb-8
                "
            >
                Votre santé commence par une meilleure compréhension de votre corps.
            </h2>

            <p
                class="
                    text-xl
                    text-[#6B4A3A]
                    mb-10
                "
            >
                Répondez à vos questionnaires de santé, obtenez une analyse personnalisée et bénéficiez d'un accompagnement basé sur la micronutrition.
            </p>

            <a
                href="{{ route('login') }}"
                class="
                    inline-flex
                    items-center
                    px-8
                    py-4
                    rounded-2xl
                    bg-[#4B2E1F]
                    hover:bg-[#3A2418]
                    text-black
                    font-semibold
                    shadow-lg
                    transition
                "
            >
                Commencer
            </a>

        </div>

    </section>

</div>

</body>

</html>