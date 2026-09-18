<x-layouts.app>

    <div class="space-y-8"
        style="
            background-color: #F7F1ED;
        " 
    >

        {{-- =====================================================
             HEADER
        ====================================================== --}}
        <header>
            <p class="text-sm text-[#6B5145]">
                Votre espace AmakaNutrition
            </p>

            <h1 class="
                mt-1
                font-['Playfair_Display']
                text-3xl
                text-[#3B2923]
                md:text-4xl
            ">
                Bonjour
                @auth
                    {{ auth()->user()->first_name }}
                @endauth
                👋
            </h1>
        </header>
        <br>

        {{-- =====================================================
             PROGRESSION
        ====================================================== --}}
<!--         <section
            class="
                relative
                overflow-hidden
                rounded-[24px]
                bg-[#513328]
                p-7
                text-white
                shadow-[0_12px_35px_rgba(81,51,40,0.15)]
                md:p-8
            "
        >

            {{-- Décoration --}}
            <div
                class="
                    absolute
                    -right-16
                    -top-20
                    h-56
                    w-56
                    rounded-full
                    bg-[#F2E5DF]
                    opacity-10
                "
            ></div>

            <div class="relative z-10">

                <div class="
                    flex
                    flex-col
                    gap-6
                    md:flex-row
                    md:items-end
                    md:justify-between
                ">

                    <div>

                        <p class="
                            text-xs
                            font-semibold
                            uppercase
                            tracking-[0.18em]
                            text-[#E6A45A]
                        ">
                            Votre parcours
                        </p>

                        <h2 class="
                            mt-2
                            font-['Playfair_Display']
                            text-3xl
                            md:text-4xl
                        ">
                            Continuez votre parcours
                        </h2>

                        <p class="
                            mt-2
                            text-sm
                            text-white/70
                        ">
                            2 questionnaires terminés sur 10
                        </p>

                    </div>


                    <button
                        type="button"
                        class="
                            amaka-btn-primary
                            !rounded-xl
                            !px-5
                            !py-3
                            whitespace-nowrap
                        "
                    >
                        Continuer →
                    </button>

                </div>


                {{-- PROGRESSION --}}
                <div class="mt-7">

                    <div class="
                        h-2
                        overflow-hidden
                        rounded-full
                        bg-white/15
                    ">
                        <div
                            class="
                                h-full
                                rounded-full
                                bg-[#D58224]
                            "
                            style="width: 20%"
                        ></div>
                    </div>

                    <div class="
                        mt-2
                        flex
                        justify-between
                        text-xs
                        text-white/50
                    ">
                        <span>Votre progression</span>
                        <span>20 %</span>
                    </div>

                </div>

            </div>

        </section> -->


        {{-- =====================================================
             STATS
        ====================================================== --}}
        <livewire:dashboard.dashboard-stats />


        {{-- =====================================================
             À FAIRE MAINTENANT
        ====================================================== --}}
        <section>

            <div class="mb-4">

                <p class="
                    text-xs
                    font-semibold
                    uppercase
                    tracking-[0.18em]
                    text-[#D58224]
                ">
                    Prochaine étape
                </p>

                <h2 class="
                    mt-1
                    font-['Playfair_Display']
                    text-2xl
                    text-[#3B2923]
                ">
                    À faire maintenant
                </h2>

            </div>


            <livewire:dashboard.questionnaire-cards />

        </section>


        {{-- =====================================================
             ACTIVITÉ RÉCENTE
        ====================================================== --}}
        <section>

            <div class="
                mb-4
                flex
                items-end
                justify-between
            ">

                <div>

                    <p class="
                        text-xs
                        font-semibold
                        uppercase
                        tracking-[0.18em]
                        text-[#D58224]
                    ">
                        Vos résultats
                    </p>

                    <h2 class="
                        mt-1
                        font-['Playfair_Display']
                        text-2xl
                        text-[#3B2923]
                    ">
                        Dernière activité
                    </h2>

                </div>

            </div>


            <livewire:dashboard.recent-activity />

        </section>

    </div>

</x-layouts.app>