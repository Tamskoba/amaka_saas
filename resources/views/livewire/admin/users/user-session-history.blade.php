<div class="min-h-screen bg-[#FDF8F4] p-6 md:p-10">

    <div class="max-w-6xl mx-auto">

        {{-- RETOUR --}}
        <a
            href="{{ route('admin.users.index') }}"
            class="
                inline-flex
                items-center
                gap-2
                text-sm
                text-gray-500
                hover:text-gray-800
                mb-6
            "
        >
            ← Retour aux utilisateurs
        </a>


        {{-- CLIENTE --}}
        <div class="mb-10">

            <h1 class="text-3xl md:text-4xl font-bold text-[#4B2E1F]">
                Historique des sessions de {{ $user->first_name }} {{ $user->last_name }}
            </h1>

            <p class="mt-2 text-gray-600">
                
            </p>
<!-- 
            <p class="text-sm text-gray-500">
                {{ $user->email }}
            </p> -->

        </div>


        {{-- SESSIONS --}}
        @if ($sessions->isEmpty())

            <div class="bg-white rounded-3xl shadow-sm p-10 text-center">

                <div class="text-5xl mb-4">
                    📋
                </div>

                <h2 class="text-xl font-semibold text-[#4B2E1F]">
                    Aucune session
                </h2>

                <p class="text-gray-500 mt-2">
                    Cette cliente n'a encore aucune session.
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

                        {{-- SESSION --}}
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

                                    <h2
                                        class="
                                            text-xl
                                            md:text-2xl
                                            font-bold
                                            text-[#4B2E1F]
                                        "
                                    >
                                        Session #{{ $session->session_number }}
                                    </h2>


                                    @if ($session->status === 'completed')

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
                                            ✓ Terminée
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


                            <div class="text-right">

                                <div class="text-3xl font-bold text-[#4338CA]">
                                    {{ $session->completed_forms_count }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    questionnaire(s)
                                </div>

                            </div>

                        </div>


                        {{-- QUESTIONNAIRES --}}
                        <div
                            class="
                                border-t
                                border-gray-100
                                bg-gray-50
                                p-6
                                md:p-8
                            "
                        >

                            <div class="space-y-3">

                                @forelse (
                                    $session->responseSets
                                    as $responseSet
                                )

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

                                            <h3
                                                class="
                                                    font-semibold
                                                    text-[#4B2E1F]
                                                "
                                            >
                                                {{ $responseSet->form?->title ?? 'Questionnaire' }}
                                            </h3>

                                            <p class="text-sm text-gray-500 mt-1">

                                                Progression :
                                                {{ $responseSet->progress }} %

                                            </p>

                                            @if ($responseSet->completed_at)

                                                <p class="text-xs text-gray-400 mt-1">

                                                    Terminé le
                                                    {{ $responseSet->completed_at->format('d/m/Y à H:i') }}

                                                </p>

                                            @endif

                                        </div>


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

                                    </div>

                                @empty

                                    <p class="text-gray-500">
                                        Aucun questionnaire dans cette session.
                                    </p>

                                @endforelse

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>