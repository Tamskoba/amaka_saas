<div class="min-h-screen bg-[#FDF8F4] p-6 md:p-10">

    {{-- HEADER --}}
    <div class="max-w-6xl mx-auto mb-10">

        <a
            href="{{ url()->previous() }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800 mb-6"
        >
            ← Retour
        </a>

        <h1 class="text-3xl md:text-4xl font-bold text-[#4B2E1F]">
            Mon historique de sessions
        </h1>

        <p class="mt-2 text-gray-600">
            Retrouvez vos questionnaires et vos réponses pour chaque session.
        </p>

    </div>


    {{-- CONTENU --}}
    <div class="max-w-6xl mx-auto">

        @if ($sessions->isEmpty())

            <div class="bg-white rounded-3xl shadow-sm p-10 text-center">

                <div class="text-5xl mb-4">
                    📋
                </div>

                <h2 class="text-xl font-semibold text-[#4B2E1F]">
                    Aucune session
                </h2>

                <p class="text-gray-500 mt-2">
                    Vous n'avez encore aucune session de questionnaire.
                </p>

            </div>

        @else

            <div class="space-y-6">

                @foreach ($sessions as $session)

                    <div
                        class="
                            bg-white
                            rounded-3xl
                            shadow-sm
                            border
                            border-gray-100
                            overflow-hidden
                        "
                    >

                        {{-- EN-TÊTE SESSION --}}
                        <div
                            class="
                                p-6
                                md:p-8
                                flex
                                flex-col
                                md:flex-row
                                md:items-center
                                md:justify-between
                                gap-5
                            "
                        >

                            <div>

                                <div class="flex items-center gap-3 mb-2">

                                    <h2 class="text-xl md:text-2xl font-bold text-[#4B2E1F]">
                                        Session #{{ $session->session_number }}
                                    </h2>

                                    @if ($session->status === 'completed')

                                        <span
                                            class="
                                                px-3
                                                py-1
                                                rounded-full
                                                text-sm
                                                font-medium
                                                bg-green-100
                                                text-green-700
                                            "
                                        >
                                            ✓ Terminée
                                        </span>

                                    @else

                                        <span
                                            class="
                                                px-3
                                                py-1
                                                rounded-full
                                                text-sm
                                                font-medium
                                                bg-orange-100
                                                text-orange-700
                                            "
                                        >
                                            En cours
                                        </span>

                                    @endif

                                </div>

                                <div class="text-sm text-gray-500">

                                    Créée le
                                    {{ $session->created_at?->format('d/m/Y à H:i') }}

                                    @if ($session->completed_at)
                                        <br>
                                        Terminée le
                                        {{ $session->completed_at->format('d/m/Y à H:i') }}
                                    @endif

                                </div>

                            </div>


                            <div class="text-left md:text-right">

                                <div class="text-3xl font-bold text-[#4338CA]">
                                    {{ $session->completed_forms_count }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    questionnaire(s) complété(s)
                                </div>

                            </div>

                        </div>


                        {{-- QUESTIONNAIRES --}}
                        <div class="border-t border-gray-100 bg-gray-50 p-6 md:p-8">

                            <h3
                                class="
                                    text-sm
                                    font-semibold
                                    uppercase
                                    tracking-wide
                                    text-gray-500
                                    mb-4
                                "
                            >
                                Questionnaires de cette session
                            </h3>


                            @if ($session->responseSets->isEmpty())

                                <p class="text-gray-500">
                                    Aucun questionnaire commencé.
                                </p>

                            @else

                                <div class="space-y-3">

                                    @foreach ($session->responseSets as $responseSet)

                                        <div
                                            class="
                                                bg-white
                                                rounded-2xl
                                                p-5
                                                border
                                                border-gray-100
                                                flex
                                                flex-col
                                                md:flex-row
                                                md:items-center
                                                md:justify-between
                                                gap-4
                                            "
                                        >

                                            <div>

                                                <h4 class="font-semibold text-[#4B2E1F]">
                                                    {{ $responseSet->form?->title ?? 'Questionnaire' }}
                                                </h4>

                                                <p class="text-sm text-gray-500 mt-1">
                                                    Progression :
                                                    {{ $responseSet->progress }} %
                                                </p>

                                            </div>


                                            <div class="flex items-center gap-3">

                                                @if ($responseSet->status === 'completed')

                                                    <span
                                                        class="
                                                            px-3
                                                            py-1
                                                            rounded-full
                                                            text-sm
                                                            bg-green-100
                                                            text-green-700
                                                        "
                                                    >
                                                        ✓ Terminé
                                                    </span>

                                                @else

                                                    <span
                                                        class="
                                                            px-3
                                                            py-1
                                                            rounded-full
                                                            text-sm
                                                            bg-orange-100
                                                            text-orange-700
                                                        "
                                                    >
                                                        En cours
                                                    </span>

                                                @endif


                                                @if ($responseSet->form)

                                                    <a
                                                        href="{{ route('forms.run', $responseSet->form->id) }}"
                                                        class="
                                                            px-4
                                                            py-2
                                                            rounded-xl
                                                            bg-[#4B2E1F]
                                                            text-white
                                                            text-sm
                                                            hover:opacity-90
                                                        "
                                                    >
                                                        Voir
                                                    </a>

                                                @endif

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>