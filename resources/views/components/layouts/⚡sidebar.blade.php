<aside
    class="
        w-72
        bg-white/90
        backdrop-blur-md
        border-r
        border-[#E9DCCB]
        hidden
        md:flex
        flex-col
        min-h-screen
    "
>

    {{-- LOGO --}}
    <div
        class="
            h-24
            flex
            items-center
            px-8
            border-b
            border-[#F3E7DA]
        "
    >

        <div>

            <h1
                class="
                    text-[#4B2E1F]
                    font-semibold
                "
            >
                Amaka
            </h1>

            <p
                class="
                    text-sm
                    text-secondary
                    italic
                "
            >
                Nutrition & équilibre
            </p>

        </div>

    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 px-4 py-8 space-y-2">

        <a
            href="/dashboard"
            class="
                flex
                items-center
                gap-3
                px-5
                py-4
                rounded-2xl
                bg-[#F6EEE7]
                text-primary
                font-medium
            "
        >
            Tableau de bord
        </a>

        <a
            href="/forms"
            class="
                flex
                items-center
                gap-3
                px-5
                py-4
                rounded-2xl
                hover:bg-[#F8F1EB]
            "
        >
            Questionnaires
        </a>

        <a
            href="/notifications"
            class="
                flex
                items-center
                gap-3
                px-5
                py-4
                rounded-2xl
                hover:bg-[#F8F1EB]
            "
        >
            Notifications
        </a>

        <a
            href="/profile"
            class="
                flex
                items-center
                gap-3
                px-5
                py-4
                rounded-2xl
                hover:bg-[#F8F1EB]
            "
        >
            Mon compte
        </a>

    </nav>

</aside>