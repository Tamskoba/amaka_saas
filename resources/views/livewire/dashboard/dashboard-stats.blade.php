<div
    class="
        grid
        grid-cols-1
        md:grid-cols-3
        gap-6
    "
>

    {{-- TERMINÉS --}}
    <div
        class="
            rounded-[32px]
            p-8
            shadow-[0_10px_40px_rgba(0,0,0,0.04)]
            border
            border-[#F1E4D8]
        "
    >

        <div
            class="
                text-[#6B4A3A]
                mb-3
            "
        >
            Questionnaires terminés
        </div>

        <div
            class="
                text-5xl
                font-bold
                text-[#4B2E1F]
            "
        >
            {{ $completed }}
        </div>

    </div>

    {{-- EN COURS --}}
    <div
        class="
            rounded-[32px]
            p-8
            shadow-[0_10px_40px_rgba(0,0,0,0.04)]
            border
            border-[#F1E4D8]
        "
    >

        <div
            class="
                text-[#6B4A3A]
                mb-3
            "
        >
            En cours
        </div>

        <div
            class="
                text-5xl
                font-bold
                text-[#C87A2A]
            "
        >
            {{ $inProgress }}
        </div>

    </div>

    {{-- RESTANTS --}}
    <div
        class="
            rounded-[32px]
            p-8
            shadow-[0_10px_40px_rgba(0,0,0,0.04)]
            border
            border-[#F1E4D8]
        "
    >

        <div
            class="
                text-[#6B4A3A]
                mb-3
            "
        >
            Restants
        </div>

        <div
            class="
                text-5xl
                font-bold
                text-[#8A5A44]
            "
        >
            {{ $remaining }}
        </div>

    </div>

</div>