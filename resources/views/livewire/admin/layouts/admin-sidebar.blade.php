<aside
    class="
        w-80
       bg-[#4B2E1F]
        border-r
        border-[#EFE2D5]
        hidden
        lg:flex
        flex-col
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
            border-[#EFE2D5]
        "
    >

        <div>

            <h1
                class="
                    text-4xl
                    font-['Playfair_Display']
                    text-[#4B2E1F]
                "
            >
                Amaka
            </h1>

            <p class="text-[#8A5A44]">
                Administration
            </p>

        </div>

    </div>

    {{-- NAV --}}
    <nav class="p-5 space-y-3 flex-1">

        <a
            href="{{ route('admin.dashboard') }}"
            class="
                block
                px-5
                py-4
                rounded-2xl
                bg-[#F6EEE7]
                text-[#4B2E1F]
                font-medium
            "
        >
            Dashboard
        </a>

        <a
            href="{{ route('admin.users.index') }}"
            class="
                block
                px-5
                py-4
                rounded-2xl
                hover:bg-[#F8F1EB]
            "
        >
            Utilisateurs
        </a>

        <a
            href="#"
            class="
                block
                px-5
                py-4
                rounded-2xl
                hover:bg-[#F8F1EB]
            "
        >
            Questionnaires
        </a>

        <a
            href="#"
            class="
                block
                px-5
                py-4
                rounded-2xl
                hover:bg-[#F8F1EB]
            "
        >
            Analyses IA
        </a>

        <a
            href="#"
            class="
                block
                px-5
                py-4
                rounded-2xl
                hover:bg-[#F8F1EB]
            "
        >
            Rapports PDF
        </a>

    </nav>

</aside>