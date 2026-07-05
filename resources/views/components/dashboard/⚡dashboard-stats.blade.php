<div
    class="
        grid
        grid-cols-1
        md:grid-cols-3
        gap-6
    "
>

    {{-- COMPLETED --}}
    <div
        class="
            bg-white
            rounded-3xl
            p-6
            shadow-sm
        "
    >
        <div class="text-gray-500 mb-2">
            Terminés
        </div>

        <div
            class="
                text-4xl
                font-bold
                text-green-600
            "
        >
            {{ $completed }}
        </div>
    </div>

    {{-- IN PROGRESS --}}
    <div
        class="
            bg-white
            rounded-3xl
            p-6
            shadow-sm
        "
    >
        <div class="text-gray-500 mb-2">
            En cours
        </div>

        <div
            class="
                text-4xl
                font-bold
                text-orange-500
            "
        >
            {{ $inProgress }}
        </div>
    </div>

    {{-- REMAINING --}}
    <div
        class="
            bg-white
            rounded-3xl
            p-6
            shadow-sm
        "
    >
        <div class="text-gray-500 mb-2">
            Restants
        </div>

        <div
            class="
                text-4xl
                font-bold
                text-[#4338CA]
            "
        >
            {{ $remaining }}
        </div>
    </div>

</div>