{{-- QUESTIONNAIRES ASSIGNÉS --}}
<div class="space-y-8"
    style="
        background-color: #F7F1ED;
    " 
>

    {{-- HEADER --}}
    <div
        class="
            flex
            flex-col
            lg:flex-row
            lg:items-center
            lg:justify-between
            gap-4
        "
    >

        <div>

            <p
                class="
                    text-[#C9822B]
                    italic
                    mb-2
                "
            >
                Tableau de bord
            </p>

            <h1
                class="
                    text-4xl
                    font-heading
                    text-[#4A2D21]
                    mb-2
                "
            >
                Mes questionnaires
            </h1>

            <p class="text-[#6D5245]">
                Retrouvez les questionnaires qui vous ont été assignés.
            </p>

        </div>

        {{-- SEARCH 
        <div class="w-full lg:w-[320px]">

            <input
                type="text"
                placeholder="Rechercher un questionnaire..."
                class="
                    w-full
                    rounded-2xl
                    border
                    border-[#E6D9CC]
                    bg-white
                    px-5
                    py-4
                    text-[#4A2D21]
                    placeholder:text-[#B7A69A]
                    focus:ring-2
                    focus:ring-[#C9822B]
                    focus:border-transparent
                    outline-none
                "
            >

        </div>
        --}}
    </div>

    {{-- GRID --}}
    <div
        class="

        "
    >

        {{-- =====================================================
             À FAIRE MAINTENANT
        ====================================================== --}}
        <br>
        <section>

            <livewire:dashboard.questionnaire-cards />

        </section>
    </div>

</div>