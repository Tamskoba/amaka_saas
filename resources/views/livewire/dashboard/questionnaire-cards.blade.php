<div class="space-y-8">

    {{-- =========================================================
         STATISTIQUES INTERACTIVES
    ========================================================== --}}

    <div
        class="gap-5"
        style="
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        "
    >

        {{-- TOTAL --}}
        <button
            type="button"
            wire:click="filterByStatus('all')"
            aria-pressed="{{ $selectedStatus === 'all' ? 'true' : 'false' }}"
            class="text-left bg-white rounded-2xl p-6 shadow-sm border transition-all duration-200 hover:shadow-md hover:-translate-y-1
            {{ $selectedStatus === 'all' ? 'ring-2 ring-[#C9822B] border-[#C9822B]' : 'border-[#EADFD3]' }}"
        >
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-[#6D5245]">
                        Total
                    </p>

                    <p class="text-3xl font-semibold mt-2 text-[#4A2D21]">
                        {{ $totalAssigned }}
                    </p>
                </div>

                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-[#F3E9E4]">
                    <svg class="w-6 h-6 text-[#C9822B]"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-xs text-[#8A7266]">
                Voir tous les questionnaires
            </p>
        </button>


        {{-- A COMMENCER --}}
        <button
            type="button"
            wire:click="filterByStatus('not_started')"
            aria-pressed="{{ $selectedStatus === 'not_started' ? 'true' : 'false' }}"
            class="text-left bg-white rounded-2xl p-6 shadow-sm border transition-all duration-200 hover:shadow-md hover:-translate-y-1
            {{ $selectedStatus === 'not_started' ? 'ring-2 ring-[#C9822B] border-[#C9822B]' : 'border-[#EADFD3]' }}"
        >
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-[#6D5245]">
                        À commencer
                    </p>

                    <p class="text-3xl font-semibold mt-2 text-[#4A2D21]">
                        {{ $notStarted }}
                    </p>
                </div>

                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-[#F3E9E4]">
                    <svg class="w-6 h-6 text-blue-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4m0 4h.01M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"
                        />
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-xs text-[#8A7266]">
                Questionnaires non commencés
            </p>
        </button>


        {{-- EN COURS --}}
        <button
            type="button"
            wire:click="filterByStatus('in_progress')"
            aria-pressed="{{ $selectedStatus === 'in_progress' ? 'true' : 'false' }}"
            class="text-left bg-white rounded-2xl p-6 shadow-sm border transition-all duration-200 hover:shadow-md hover:-translate-y-1
            {{ $selectedStatus === 'in_progress' ? 'ring-2 ring-[#C9822B] border-[#C9822B]' : 'border-[#EADFD3]' }}"
        >
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-[#6D5245]">
                        En cours
                    </p>

                    <p class="text-3xl font-semibold mt-2 text-[#4A2D21]">
                        {{ $inProgress }}
                    </p>
                </div>

                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-[#FFF3E5]">
                    <svg class="w-6 h-6 text-red-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-xs text-[#8A7266]">
                Questionnaires commencés
            </p>
        </button>


        {{-- TERMINES --}}
        <button
            type="button"
            wire:click="filterByStatus('completed')"
            aria-pressed="{{ $selectedStatus === 'completed' ? 'true' : 'false' }}"
            class="text-left bg-white rounded-2xl p-6 shadow-sm border transition-all duration-200 hover:shadow-md hover:-translate-y-1
            {{ $selectedStatus === 'completed' ? 'ring-2 ring-[#C9822B] border-[#C9822B]' : 'border-[#EADFD3]' }}"
        >
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-[#6D5245]">
                        Terminés
                    </p>

                    <p class="text-3xl font-semibold mt-2 text-[#4A2D21]">
                        {{ $completed }}
                    </p>
                </div>

                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-[#E7F4EC]">
                    <svg class="w-6 h-6 text-green-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-xs text-[#8A7266]">
                Questionnaires terminés
            </p>
        </button>

    </div>
    <br>

    {{-- =========================================================
         LISTE DES QUESTIONNAIRES
    ========================================================== --}}

    @if($totalAssigned === 0)

        {{-- Aucun questionnaire attribué --}}

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

        {{-- =====================================================
             AUCUN RESULTAT POUR LE FILTRE
        ====================================================== --}}

        @if($filteredForms->isEmpty())

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
                    Aucun questionnaire dans cette catégorie
                </h3>

                <p
                    class="mt-2"
                    style="color: #6d5245;"
                >
                    Aucun questionnaire ne correspond à ce statut.
                </p>

                <button
                    type="button"
                    wire:click="filterByStatus('all')"
                    class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-semibold text-white transition hover:opacity-90 hover:-translate-y-0.5"
                    style="background-color: #bb7229;"
                >
                    Voir tous les questionnaires
                    <span>→</span>
                </button>

            </div>

        @else

            {{-- =================================================
                 CARTES DES QUESTIONNAIRES
            ================================================== --}}

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                @foreach($filteredForms as $form)

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

                                    <span class="transition-transform duration-200">
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

                                    <span class="transition-transform duration-200">
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

                                    <span class="transition-transform duration-200">
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

                                    <span class="transition-transform duration-200">
                                        →
                                    </span>
                                </a>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    @endif

</div>