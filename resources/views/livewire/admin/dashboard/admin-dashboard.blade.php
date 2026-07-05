

    <div class="space-y-10">

        {{-- HERO --}}
        <section
            class="
                bg-white/70
                backdrop-blur-sm
                border
                border-[#EADFD3]
                rounded-[32px]
                shadow-[0_10px_40px_rgba(74,45,33,0.08)]
                p-6
            "
        >

            <p
                class="
                    text-[#C87A2A]
                    italic
                    mb-3
                "
            >
                Administration SaaS
            </p>

            <h1
                class="
                    text-5xl
                    text-[#4B2E1F]
                    font-['Playfair_Display']
                    mb-5
                "
            >
                Dashboard Administrateur
            </h1>

            <p
                class="
                    text-[#6B4A3A]
                    text-lg
                "
            >
                Gérez les utilisateurs,
                questionnaires et analyses
                micronutritionnelles.
            </p>

        </section>

        {{-- KPIs --}}
        <div
            class="
                grid
                grid-cols-1
                md:grid-cols-2
                xl:grid-cols-4
                gap-6
            "
        >

            {{-- USERS --}}
            <div
                class="
                    bg-white/70
                    backdrop-blur-sm
                    border
                    border-[#EADFD3]
                    rounded-[32px]
                    shadow-[0_10px_40px_rgba(74,45,33,0.08)]
                    p-6
                "
            >

                <div class="text-[#8A5A44] mb-3">
                    Utilisateurs
                </div>

                <div
                    class="
                        text-5xl
                        font-bold
                    "
                >
                    {{ $users }}
                </div>

            </div>

            {{-- FORMS --}}
            <div
                class="
                    bg-white/70
                    backdrop-blur-sm
                    border
                    border-[#EADFD3]
                    rounded-[32px]
                    shadow-[0_10px_40px_rgba(74,45,33,0.08)]
                    p-6
                "
            >

                <div class="text-[#8A5A44] mb-3">
                    Questionnaires
                </div>

                <div
                    class="
                        text-5xl
                        font-bold
                    "
                >
                    {{ $forms }}
                </div>

            </div>

            {{-- RESPONSES --}}
            <div
                class="
                    bg-white/70
                    backdrop-blur-sm
                    border
                    border-[#EADFD3]
                    rounded-[32px]
                    shadow-[0_10px_40px_rgba(74,45,33,0.08)]
                    p-6
                "
            >

                <div class="text-[#8A5A44] mb-3">
                    Réponses
                </div>

                <div
                    class="
                        text-5xl
                        font-bold
                    "
                >
                    {{ $responses }}
                </div>

            </div>

            {{-- COMPLETED --}}
            <div
                class="
                    bg-white/70
                    backdrop-blur-sm
                    border
                    border-[#EADFD3]
                    rounded-[32px]
                    shadow-[0_10px_40px_rgba(74,45,33,0.08)]
                    p-6
                "
            >

                <div class="text-[#8A5A44] mb-3">
                    Terminés
                </div>

                <div
                    class="
                        text-5xl
                        font-bold
                        text-[#1D7A46]
                    "
                >
                    {{ $completed }}
                </div>

            </div>

        </div>

    </div>
