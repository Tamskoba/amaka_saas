<x-layouts.app>

    <div class="space-y-10">

        {{-- HERO --}}
        <section
            class="
                relative
                overflow-hidden
                rounded-[40px]
                bg-white
                shadow-[0_10px_40px_rgba(0,0,0,0.04)]
                p-10
                md:p-14
            "
        >

            {{-- DECORATION --}}
            <div
                class="
                    absolute
                    top-0
                    right-0
                    w-96
                    h-96
                    bg-gradient-to-bl
                    from-[#F3E3D2]
                    to-transparent
                    rounded-full
                "
            ></div>

            <div class="relative z-10 max-w-2xl">

                <p
                    class="
                        text-[#C87A2A]
                        italic
                        mb-3
                        text-lg
                    "
                >
                    @auth

                    Bonjour {{ auth()->user()->first_name }}
                    @endauth
                    <br>
                    Votre espace bien-être personnalisé
                </p>

                <h1
                    class="
                        text-5xl
                        leading-tight
                        text-[#4B2E1F]
                        mb-6
                        font-['Playfair_Display']
                    "
                >
                    Une approche scientifique
                    et humaine de votre santé.
                </h1>

                <p
                    class="
                        text-[#6B4A3A]
                        text-lg
                        leading-relaxed
                    "
                >
                    Répondez à vos questionnaires,
                    suivez vos analyses et obtenez
                    des recommandations adaptées.
                </p>

                <button
                    class="
                        mt-8
                        bg-[#C87A2A]
                        hover:bg-[#B46D25]
                        text-white
                        px-8
                        py-4
                        rounded-2xl
                        transition
                    "
                >
                    Continuer mes questionnaires
                </button>

            </div>

        </section>

        <livewire:dashboard.questionnaire-cards />

        {{-- STATS --}}
        <livewire:dashboard.dashboard-stats />

        {{-- RECENT ACTIVITY --}}
        <livewire:dashboard.recent-activity />
    </div>

</x-layouts.app>