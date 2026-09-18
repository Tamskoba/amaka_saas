<div>
    {{-- =========================================================
         GRID DES QUESTIONNAIRES
    ========================================================== --}}
    <div class="
            grid
            grid-cols-1
            md:grid-cols-3
            gap-6
        "
    >

        @foreach($forms as $form)

            {{-- =================================================
                 CARD QUESTIONNAIRE
            ================================================== --}}
            <article
                class="
                    amaka-questionnaire-card
                    group
                    flex
                    h-full
                    min-h-[440px]
                    flex-col
                    overflow-hidden
                    rounded-[24px]
                    p-6
                    shadow-[0_8px_25px_rgba(81,51,40,0.12)]
                    transition-all
                    duration-300
                    hover:-translate-y-1
                    hover:border-[#B96818]
                    hover:shadow-[0_14px_35px_rgba(81,51,40,0.18)]
                "
                style="
                    background-color: #F3E9E4;
                    border: 1px solid #efc0a9;
                    border-radius: 10px;
                "
            >

                {{-- =============================================
                     EN-TÊTE
                ============================================== --}}
                <div class="flex min-h-[48px] items-start justify-between gap-4">

                    {{-- ICÔNE --}}
                    @if($form['status'] === 'completed')

                        <div
                            class="
                                flex
                                h-12
                                w-12
                                shrink-0
                                items-center
                                justify-center
                                rounded-2xl
                                bg-[#EDF2EA]
                                text-xl
                                font-semibold
                                text-[#53654C]
                            "
                        >
                            ✓
                        </div>

                    @elseif($form['status'] === 'in_progress')

                        <div
                            class="
                                flex
                                h-12
                                w-12
                                shrink-0
                                items-center
                                justify-center
                                rounded-2xl
                                bg-[#FFF0DD]
                                text-xl
                                font-semibold
                                text-[#B96818]
                            "
                        >
                            ◐
                        </div>

                    @else

                        <div
                            class="
                                flex
                                h-12
                                w-12
                                shrink-0
                                items-center
                                justify-center
                                rounded-2xl
                                bg-[#F2E5DF]
                                text-xl
                                font-semibold
                                text-[#513328]
                            "
                        >
                            +
                        </div>

                    @endif

                    {{-- BADGE --}}
                    @if($form['status'] === 'completed')

                        <span
                            class="
                                amaka-badge
                                whitespace-nowrap
                                bg-[#EDF2EA]
                                text-[#53654C]
                            "
                        >
                            ✓ Terminé
                        </span>

                    @elseif($form['status'] === 'in_progress')

                        <span
                            class="
                                amaka-badge
                                whitespace-nowrap
                                bg-[#FFF0DD]
                                text-[#B96818]
                            "
                        >
                            En cours
                        </span>

                    @else

                        <span
                            class="
                                amaka-badge
                                whitespace-nowrap
                                bg-[#F7ECE6]
                                text-[#513328]
                            "
                        >
                            À commencer
                        </span>

                    @endif

                </div>


                {{-- =================================================
                     CONTENU
                ================================================== --}}
                <div class="mt-6">

                    {{-- TITRE --}}
                    <h3
                        class="
                            min-h-[56px]
                            line-clamp-2
                            font-['Playfair_Display']
                            text-xl
                            font-semibold
                            leading-snug
                            text-[#3B2923]
                        "
                    >
                        {{ $form['title'] }}
                    </h3>

                    {{-- DESCRIPTION --}}
                    <p
                        class="
                            mt-3
                            min-h-[84px]
                            line-clamp-3
                            text-sm
                            leading-relaxed
                            text-[#6B5145]
                        "
                    >
                        {{ $form['description'] }}
                    </p>

                </div>


                {{-- =================================================
                     ZONE BASSE : PROGRESSION + ACTION
                ================================================== --}}
                <div class="mt-auto">

                    {{-- =============================================
                         PROGRESSION
                    ============================================== --}}
                    <div class="mt-6">

                        <div class="mb-2 flex items-center justify-between">

                            <span
                                class="
                                    text-xs
                                    font-medium
                                    text-[#76594B]
                                "
                            >
                                Progression
                            </span>

                            <span
                                class="
                                    text-sm
                                    font-semibold
                                    text-[#3B2923]
                                "
                            >
                                {{ $form['progress'] }}%
                            </span>

                        </div>

                        {{-- BARRE DE PROGRESSION --}}
                        <div
                            class="
                                h-2
                                w-full
                                overflow-hidden
                                rounded-full
                                bg-[#C8AA99]
                            "
                        >
                            <div
                                class="
                                    h-full
                                    rounded-full
                                    bg-[#B96818]
                                    transition-all
                                    duration-500
                                "
                                style="width: {{ $form['progress'] }}%"
                            ></div>
                        </div>

                    </div>


                    {{-- =============================================
                         ACTION
                    ============================================== --}}
                    <div class="mt-6">

                        @if($form['status'] === 'completed')

                            <a
                                href="{{ route('forms.run', $form['id']) }}"
                                class="
                                    flex
                                    min-h-[48px]
                                    w-full
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-xl
                                    px-4
                                    py-3
                                    text-center
                                    text-sm
                                    font-semibold
                                    text-white
                                    shadow-[0_4px_10px_rgba(81,51,40,0.18)]
                                    transition-all
                                    duration-200
                                    hover:bg-[#3B2923]
                                "
                                style="background-color: #bb7229;"
                            >
                                <span>Voir le questionnaire</span>

                                <span
                                    class="
                                        transition-transform
                                        duration-200
                                        group-hover:translate-x-1
                                    "
                                >
                                    →
                                </span>
                            </a>

                        @elseif($form['status'] === 'in_progress')

                            <a
                                href="{{ route('forms.run', $form['id']) }}"
                                class="
                                    flex
                                    min-h-[48px]
                                    w-full
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-xl
                                    px-4
                                    py-3
                                    text-center
                                    text-sm
                                    font-semibold
                                    text-white
                                    shadow-[0_4px_10px_rgba(185,104,24,0.20)]
                                    transition-all
                                    duration-200
                                    hover:bg-[#9F5713]
                                "
                                style="background-color: #bb7229;"
                            >
                                <span>Continuer</span>

                                <span
                                    class="
                                        transition-transform
                                        duration-200
                                        group-hover:translate-x-1
                                    "
                                >
                                    →
                                </span>
                            </a>

                        @else

                            <a
                                href="{{ route('forms.run', $form['id']) }}"
                                class="
                                    flex
                                    min-h-[48px]
                                    w-full
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-xl
                                    px-4
                                    py-3
                                    text-center
                                    text-sm
                                    font-semibold
                                    text-white
                                    shadow-[0_4px_10px_rgba(81,51,40,0.18)]
                                    transition-all
                                    duration-200
                                    hover:bg-[#3B2923]
                                "
                                style="background-color: #bb7229;"
                            >
                                <span>Commencer</span>

                                <span
                                    class="
                                        transition-transform
                                        duration-200
                                        group-hover:translate-x-1
                                    "
                                >
                                    →
                                </span>
                            </a>

                        @endif

                    </div>

                </div>

            </article>

        @endforeach

    </div>
</div>