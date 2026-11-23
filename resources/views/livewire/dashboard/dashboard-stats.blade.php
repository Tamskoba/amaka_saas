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
            class="text-left bg-white rounded-2xl p-6 shadow-sm border transition-all duration-200 hover:shadow-md hover:-translate-y-1"
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
            class="text-left bg-white rounded-2xl p-6 shadow-sm border transition-all duration-200 hover:shadow-md hover:-translate-y-1"
        >
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-[#6D5245]">
                        À commencer
                    </p>

                    <p class="text-3xl font-semibold mt-2 text-[#4A2D21]">
                        {{ $remaining }}
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
            class="text-left bg-white rounded-2xl p-6 shadow-sm border transition-all duration-200 hover:shadow-md hover:-translate-y-1"
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
            class="text-left bg-white rounded-2xl p-6 shadow-sm border transition-all duration-200 hover:shadow-md hover:-translate-y-1"
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