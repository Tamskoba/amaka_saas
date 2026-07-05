<header
    class="
        h-24
        bg-[#F7F2EE]/90
        backdrop-blur-md
        border-b
        border-[#EADFD3]
        px-10
        flex
        items-center
        justify-between
        sticky
        top-0
        z-20
    "
>

    <div>

        <h2
            class="
                text-3xl
                font-['Playfair_Display']
                text-[#4B2E1F]
                font-semibold
            "
        >
            Dashboard Administrateur
        </h2>

        <p
            class="
                text-[#6B4A3A]
                text-sm
                mt-1
            "
        >
            Gestion complète AmakaNutrition
        </p>

    </div>

    <div
        class="
            flex
            items-center
            gap-5
        "
    >

        {{-- PROFIL --}}
        <div
            class="
                text-right
            "
        >

            <div
                class="
                    font-semibold
                    text-[#4B2E1F]
                "
            >
                @auth
                    {{ auth()->user()->first_name }}
                    {{ auth()->user()->last_name }}
                @endauth
            </div>

            <div
                class="
                    text-sm
                    text-[#6B4A3A]
                "
            >
                Administrateur
            </div>

        </div>

        {{-- AVATAR --}}
        <div
            class="
                h-12
                w-12
                rounded-full
                bg-[#C87A2A]
                text-black
                flex
                items-center
                justify-center
                font-semibold
                shadow-md
            "
        >
            @auth
                {{ strtoupper(substr(auth()->user()->first_name,0,1)) }}
            @endauth
        </div>

        {{-- BOUTON DECONNEXION --}}
        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="
                    flex
                    items-center
                    gap-2
                    px-6
                    py-3
                    rounded-2xl
                    bg-[#4B2E1F]
                    hover:bg-[#3A2418]
                    text-red
                    font-semibold
                    shadow-lg
                    transition-all
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
                        d="M17 16l4-4m0 0l-4-4m4 4H9m4 8H7a2 2 0 01-2-2V6a2 2 0 012-2h6"
                    />
                </svg>

                Déconnexion
            </button>

        </form>

    </div>

</header>