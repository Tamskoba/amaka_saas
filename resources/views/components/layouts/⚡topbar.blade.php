<header
    class="
        bg-background/80
        backdrop-blur-md
        border-b
        border-[#EFE2D5]
        px-10
        h-24
        flex
        items-center
        justify-between
    "
>

    <div>

        <h2
            class="
                text-3xl
                font-heading
                text-primary
            "
        >
            Bonjour {{ auth()->user()->first_name }}
        </h2>

        <p
            class="
                text-secondary
                mt-1
            "
        >
            Prenez soin de votre équilibre intérieur.
        </p>

    </div>

    <div class="flex items-center gap-5">

        <input
            type="text"
            placeholder="Recherche..."
            class="
                bg-white
                border
                border-[#E8D8C7]
                rounded-2xl
                px-5
                py-3
                w-72
                focus:outline-none
                focus:ring-2
                focus:ring-accent
            "
        >

        <button
            class="
                relative
                w-12
                h-12
                rounded-full
                bg-white
                shadow-soft
            "
        >

            🔔

            <span
                class="
                    absolute
                    -top-1
                    -right-1
                    w-5
                    h-5
                    rounded-full
                    bg-accent
                    text-white
                    text-xs
                    flex
                    items-center
                    justify-center
                "
            >
                3
            </span>

        </button>

    </div>

</header>