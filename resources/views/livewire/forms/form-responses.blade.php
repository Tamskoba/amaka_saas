<div
    class="
        min-h-screen
        bg-[#FDF8F4]
        p-6
        md:p-10
    "
>

    <div class="max-w-4xl mx-auto">

        {{-- ============================================================
            HEADER
        ============================================================ --}}

        <div
            class="
                bg-white
                rounded-[40px]
                p-8
                md:p-10
                shadow-[0_10px_40px_rgba(0,0,0,0.04)]
                border
                border-[#F1E4D8]
                mb-8
            "
        >

            <p
                class="
                    text-[#C87A2A]
                    italic
                    mb-3
                "
            >
                Mes réponses
            </p>

            <h1
                class="
                    text-3xl
                    md:text-4xl
                    font-bold
                    text-[#4B2E1F]
                    mb-4
                "
            >
                {{ $form->title }}
            </h1>

            @if($responseSet)

                <div
                    class="
                        inline-flex
                        items-center
                        gap-2
                        px-4
                        py-2
                        rounded-full
                        bg-green-50
                        text-green-700
                        text-sm
                        font-medium
                    "
                >
                    <span>✓</span>
                    Questionnaire terminé
                </div>

            @endif

        </div>


        {{-- ============================================================
            AUCUNE REPONSE
        ============================================================ --}}

        @if(! $responseSet)

            <div
                class="
                    bg-white
                    rounded-[40px]
                    p-10
                    text-center
                    border
                    border-[#F1E4D8]
                    shadow-sm
                "
            >

                <h2
                    class="
                        text-2xl
                        font-semibold
                        text-[#4B2E1F]
                        mb-4
                    "
                >
                    Aucune réponse disponible
                </h2>

                <p
                    class="
                        text-[#6B4A3A]
                        mb-8
                    "
                >
                    Vous n'avez pas encore terminé ce questionnaire.
                </p>

                <a
                    href="{{ route('forms.run', $form->id) }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        px-7
                        py-3
                        rounded-2xl
                        bg-[#C87A2A]
                        text-white
                        font-medium
                        hover:bg-[#B87424]
                        transition
                    "
                >
                    Commencer le questionnaire
                </a>

            </div>

        @else

            {{-- ========================================================
                REPONSES
            ======================================================== --}}

            <div class="space-y-6">

                @foreach($responseSet->answers as $answer)

                    <div
                        class="
                            bg-white
                            rounded-[30px]
                            p-7
                            md:p-8
                            border
                            border-[#F1E4D8]
                            shadow-sm
                        "
                    >

                        {{-- QUESTION --}}

                        <h2
                            class="
                                text-lg
                                md:text-xl
                                font-semibold
                                text-[#4B2E1F]
                                mb-5
                            "
                        >
                            {{ $answer->question->question_text ?? 'Question' }}
                        </h2>


                        {{-- REPONSE --}}

                        <div
                            class="
                                text-[#6B4A3A]
                                leading-relaxed
                            "
                        >

                            @php
                                $value = $answer->answer_value;

                                $decodedValue = null;

                                if (is_string($value)) {

                                    $decoded = json_decode(
                                        $value,
                                        true
                                    );

                                    if (json_last_error() === JSON_ERROR_NONE) {
                                        $decodedValue = $decoded;
                                    }
                                }
                            @endphp


                            {{-- REPONSE MULTIPLE --}}

                            @if(is_array($decodedValue))

                                <div class="flex flex-wrap gap-2">

                                    @foreach($decodedValue as $item)

                                        <span
                                            class="
                                                inline-flex
                                                px-4
                                                py-2
                                                rounded-full
                                                bg-[#FDF8F4]
                                                border
                                                border-[#E8D9CC]
                                                text-[#4B2E1F]
                                            "
                                        >
                                            {{ $item }}
                                        </span>

                                    @endforeach

                                </div>


                            {{-- REPONSE SIMPLE --}}

                            @else

                                <div
                                    class="
                                        px-5
                                        py-4
                                        rounded-2xl
                                        bg-[#FDF8F4]
                                        border
                                        border-[#E8D9CC]
                                    "
                                >
                                    {{ $value }}
                                </div>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- ========================================================
                ACTIONS
            ======================================================== --}}

            <div
                class="
                    flex
                    flex-col
                    sm:flex-row
                    justify-between
                    gap-4
                    mt-8
                "
            >
                <a href="{{ route('forms.run', ['form' => $form->id, 'edit' => 1]) }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        px-7
                        py-3.5
                        rounded-2xl
                        border
                        border-[#E8D9CC]
                        bg-white
                        text-[#4B2E1F]
                        font-medium
                        hover:bg-[#FDF8F4]
                        transition
                    "
                >
                    Modifier mes réponses
                </a>

                <a
                    href="{{ route('forms.index') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        px-7
                        py-3
                        rounded-2xl
                        border
                        border-[#E8D9CC]
                        bg-white
                        text-[#4B2E1F]
                        font-medium
                        hover:bg-[#FDF8F4]
                        transition
                    "
                >
                    ← Retour à mes questionnaires
                </a>

                <a
                    href="{{ route('dashboard') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        px-7
                        py-3
                        rounded-2xl
                        bg-[#4B2E1F]
                        text-white
                        font-medium
                        hover:bg-[#633D2A]
                        transition
                    "
                >
                    Retour au tableau de bord
                </a>

            </div>

        @endif

    </div>

</div>