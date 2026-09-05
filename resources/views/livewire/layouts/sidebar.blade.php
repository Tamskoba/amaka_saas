<aside
    class="
        w-72
        bg-white
        border-r
        border-[#EFE2D5]
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
            border-[#EFE2D5]
        "
    >

        <div>

            <h1
                class="
                    text-4xl
                    text-[#4B2E1F]
                    font-['Playfair_Display']
                "
            >
                Amaka
            </h1>

            <p
                class="
                    text-sm
                    italic
                    text-[#6B4A3A]
                "
            >
                Nutrition & équilibre
            </p>

        </div>

    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 p-5 space-y-3">

        <a
            href="/dashboard"
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
            Tableau de bord
        </a>

        <a
            href="/forms"
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
            href="/profile"
            class="
                block
                px-5
                py-4
                rounded-2xl
                hover:bg-[#F8F1EB]
            "
        >
            Mon compte
        </a>

        <a
            href="{{ route('sessions.history') }}"
            class="
                flex
                items-center
                gap-3
                px-4
                py-3
                rounded-xl
                text-gray-700
                hover:bg-[#FDF8F4]
                hover:text-[#4B2E1F]
                transition
            "
        >
            <span>🕘</span>

            <span>
                Historique
            </span>
        </a>        
        
        {{-- ADMIN ACCESS --}}
        @auth
        @if(

            auth()->user()->role === 'admin'
            || auth()->user()->role === 'super_admin'
        )

            <a
                href="{{ route('admin.dashboard') }}"
                class="
                    flex
                    items-center
                    gap-3
                    px-5
                    py-4
                    rounded-2xl
                    hover:bg-[#F8F1EB]
                    transition
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 7h18M3 12h18M3 17h18"
                    />
                </svg>

                <span>
                    Administration
                </span>

            </a>

        @endif
        @endauth
    </nav>

</aside>