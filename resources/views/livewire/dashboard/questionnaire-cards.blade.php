<div class="space-y-8">

    {{-- =========================================================
         STATISTIQUES
    ========================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Total --}}
        <div
            class="bg-white rounded-2xl p-6 shadow-sm border"
            style="border-color: #eadfd3;"
        >
            <div class="flex items-center justify-between">
                <div>
                    <p
                        class="text-sm font-medium"
                        style="color: #6d5245;"
                    >
                        Total
                    </p>

                    <p
                        class="text-3xl font-semibold mt-2"
                        style="color: #4a2d21;"
                    >
                        {{ $totalAssigned }}
                    </p>
                </div>

                <div
                    class="w-12 h-12 rounded-full flex items-center justify-center"
                    style="background-color: #f3e9e4;"
                >
                    <svg
                        class="w-6 h-6"
                        style="color: #c9822b;"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Terminés --}}
        <div
            class="bg-white rounded-2xl p-6 shadow-sm border"
            style="border-color: #eadfd3;"
        >
            <div class="flex items-center justify-between">
                <div>
                    <p
                        class="text-sm font-medium"
                        style="color: #6d5245;"
                    >
                        Terminés
                    </p>

                    <p
                        class="text-3xl font-semibold mt-2"
                        style="color: #4a2d21;"
                    >
                        {{ $completed }}
                    </p>
                </div>

                <div
                    class="w-12 h-12 rounded-full flex items-center justify-center"
                    style="background-color: #e7f4ec;"
                >
                    <svg
                        class="w-6 h-6 text-green-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>
            </div>
        </div>

        {{-- En cours --}}
        <div
            class="bg-white rounded-2xl p-6 shadow-sm border"
            style="border-color: #eadfd3;"
        >
            <div class="flex items-center justify-between">
                <div>
                    <p
                        class="text-sm font-medium"
                        style="color: #6d5245;"
                    >
                        En cours
                    </p>

                    <p
                        class="text-3xl font-semibold mt-2"
                        style="color: #4a2d21;"
                    >
                        {{ $inProgress }}
                    </p>
                </div>

                <div
                    class="w-12 h-12 rounded-full flex items-center justify-center"
                    style="background-color: #fff3e5;"
                >
                    <svg
                        class="w-6 h-6"
                        style="color: #c9822b;"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>
            </div>
        </div>

    </div>
    <br>


    {{-- =========================================================
         QUESTIONNAIRES
    ========================================================== --}}
    @if(empty($forms))

        <div
            class="bg-white rounded-2xl p-10 text-center border shadow-sm"
            style="border-color: #eadfd3;"
        >
            <div
                class="w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4"
                style="background-color: #f3e9e4;"
            >
                <svg
                    class="w-8 h-8"
                    style="color: #c9822b;"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"
                    />
                </svg>
            </div>

            <h3
                class="text-xl font-semibold"
                style="color: #4a2d21;"
            >
                Aucun questionnaire disponible
            </h3>

            <p
                class="mt-2"
                style="color: #6d5245;"
            >
                Aucun questionnaire ne vous a encore été assigné.
            </p>
        </div>

    @else

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach($forms as $form)

                <div
                    class="
                        bg-white
                        rounded-2xl
                        p-6
                        shadow-sm
                        border
                        min-h-[440px]
                        flex
                        flex-col
                    "
                    style="border-color: #eadfd3;"
                >

                    {{-- =================================================
                         EN-TÊTE + STATUT
                    ================================================== --}}
                    <div class="flex items-start justify-between gap-4">

                        <div class="flex-1">
                            <div class="flex items-center gap-2">

                                @if($form['status'] === 'completed')

                                    <span
                                        class="
                                            inline-flex
                                            items-center
                                            px-3
                                            py-1
                                            rounded-full
                                            text-xs
                                            font-medium
                                        "
                                        style="
                                            background-color: #e7f4ec;
                                            color: #2f7d4a;
                                        "
                                    >
                                        <span
                                            class="w-2 h-2 rounded-full bg-green-500 mr-2"
                                        ></span>

                                        Terminé
                                    </span>

                                @elseif($form['status'] === 'in_progress')

                                    <span
                                        class="
                                            inline-flex
                                            items-center
                                            px-3
                                            py-1
                                            rounded-full
                                            text-xs
                                            font-medium
                                        "
                                        style="
                                            background-color: #fff3e5;
                                            color: #a85f16;
                                        "
                                    >
                                        <span
                                            class="w-2 h-2 rounded-full mr-2"
                                            style="background-color: #c9822b;"
                                        ></span>

                                        En cours
                                    </span>

                                @else

                                    <span
                                        class="
                                            inline-flex
                                            items-center
                                            px-3
                                            py-1
                                            rounded-full
                                            text-xs
                                            font-medium
                                        "
                                        style="
                                            background-color: #f3e9e4;
                                            color: #6d5245;
                                        "
                                    >
                                        <span
                                            class="w-2 h-2 rounded-full mr-2"
                                            style="background-color: #9d8578;"
                                        ></span>

                                        À commencer
                                    </span>

                                @endif

                            </div>
                        </div>

                    </div>


                    {{-- =================================================
                         CONTENU
                    ================================================== --}}
                    <div class="mt-5 flex-1">

                        <h3
                            class="
                                text-xl
                                font-heading
                                font-semibold
                                leading-tight
                            "
                            style="color: #4a2d21;"
                        >
                            {{ $form['title'] }}
                        </h3>

                        @if(!empty($form['description']))

                            <p
                                class="
                                    mt-3
                                    text-sm
                                    leading-relaxed
                                "
                                style="color: #6d5245;"
                            >
                                {{ $form['description'] }}
                            </p>

                        @endif

                    </div>


                    {{-- =================================================
                         PROGRESSION
                    ================================================== --}}
                    <div class="mt-6">

                        <div class="flex items-center justify-between mb-2">

                            <span
                                class="text-sm font-medium"
                                style="color: #6d5245;"
                            >
                                Progression
                            </span>

                            <span
                                class="text-sm font-semibold"
                                style="color: #4a2d21;"
                            >
                                {{ $form['progress'] }}%
                            </span>

                        </div>

                        <div
                            class="w-full h-2 rounded-full overflow-hidden"
                            style="background-color: #f3e9e4;"
                        >
                            <div
                                class="h-full rounded-full transition-all duration-500"
                                style="
                                    width: {{ min(100, max(0, $form['progress'])) }}%;
                                    background-color: #c9822b;
                                "
                            ></div>
                        </div>

                        @if($form['status'] === 'completed' && !empty($form['completed_at']))

                            <p
                                class="mt-2 text-xs"
                                style="color: #8a7266;"
                            >
                                Terminé le
                                {{ \Carbon\Carbon::parse($form['completed_at'])->format('d/m/Y') }}
                            </p>

                        @elseif($form['status'] === 'in_progress')

                            <p
                                class="mt-2 text-xs"
                                style="color: #8a7266;"
                            >
                                Vous pouvez reprendre là où vous vous êtes arrêté.
                            </p>

                        @else

                            <p
                                class="mt-2 text-xs"
                                style="color: #8a7266;"
                            >
                                Questionnaire non commencé
                            </p>

                        @endif

                    </div>


                    {{-- =================================================
                         ACTIONS
                    ================================================== --}}
                    <div class="mt-6 flex items-center justify-center gap-3">

                        {{-- QUESTIONNAIRE TERMINÉ --}}
                        @if($form['status'] === 'completed')

                            {{-- Consulter --}}
                            <a
                                href="{{ route('forms.run', ['form' => $form['id']]) }}"
                                class="
                                    inline-flex
                                    min-h-[48px]
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-xl
                                    px-5
                                    py-3
                                    text-sm
                                    font-semibold
                                    text-white
                                    transition
                                    duration-200
                                    hover:opacity-90
                                    hover:-translate-y-0.5
                                "
                                style="background-color: #bb7229;"
                            >
                                <span>Consulter</span>

                                <span
                                    class="transition-transform duration-200"
                                >
                                    →
                                </span>
                            </a>


                            {{-- Modifier --}}
                            <a
                                href="{{ route('forms.run', [
                                    'form' => $form['id'],
                                    'edit' => 1
                                ]) }}"
                                class="
                                    inline-flex
                                    min-h-[48px]
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-xl
                                    px-5
                                    py-3
                                    text-sm
                                    font-semibold
                                    transition
                                    duration-200
                                    hover:-translate-y-0.5
                                "
                                style="
                                    background-color: #f3e9e4;
                                    color: #4a2d21;
                                "
                            >
                                <span>Modifier</span>

                                <span
                                    class="transition-transform duration-200"
                                >
                                    ✎
                                </span>
                            </a>


                        {{-- QUESTIONNAIRE EN COURS --}}
                        @elseif($form['status'] === 'in_progress')

                            <a
                                href="{{ route('forms.run', [
                                    'form' => $form['id']
                                ]) }}"
                                class="
                                    inline-flex
                                    min-h-[48px]
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-xl
                                    px-6
                                    py-3
                                    text-sm
                                    font-semibold
                                    text-white
                                    transition
                                    duration-200
                                    hover:opacity-90
                                    hover:-translate-y-0.5
                                "
                                style="background-color: #bb7229;"
                            >
                                <span>Continuer</span>

                                <span
                                    class="transition-transform duration-200"
                                >
                                    →
                                </span>
                            </a>


                        {{-- QUESTIONNAIRE NON COMMENCÉ --}}
                        @else

                            <a
                                href="{{ route('forms.run', [
                                    'form' => $form['id']
                                ]) }}"
                                class="
                                    inline-flex
                                    min-h-[48px]
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-xl
                                    px-6
                                    py-3
                                    text-sm
                                    font-semibold
                                    text-white
                                    transition
                                    duration-200
                                    hover:opacity-90
                                    hover:-translate-y-0.5
                                "
                                style="background-color: #bb7229;"
                            >
                                <span>Commencer</span>

                                <span
                                    class="transition-transform duration-200"
                                >
                                    →
                                </span>
                            </a>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>