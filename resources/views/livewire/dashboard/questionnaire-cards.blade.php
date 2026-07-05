<div class="space-y-10">

    {{-- HEADER --}}
    <div
        class="
            flex
            items-center
            justify-between
        "
    >

        <div>

            <h2
                class="
                    text-4xl
                    text-[#4B2E1F]
                    font-['Playfair_Display']
                    font-semibold
                "
            >
                Vos questionnaires
            </h2>

            <p
                class="
                    text-[#6B4A3A]
                    mt-3
                    text-lg
                "
            >
                Suivez votre progression santé personnalisée.
            </p>

        </div>

    </div>

    {{-- GRID --}}
    <div
        class="
            grid
            grid-cols-1
            xl:grid-cols-2
            gap-8
        "
    >

        @foreach($forms as $form)

            <div
                class="
                    bg-white
                    rounded-[32px]
                    p-8
                    border
                    border-[#EADFD3]
                    shadow-[0_10px_40px_rgba(75,46,31,0.06)]
                    hover:shadow-[0_20px_60px_rgba(75,46,31,0.12)]
                    transition-all
                    duration-300
                "
            >

                {{-- HEADER --}}
                <div
                    class="
                        flex
                        justify-between
                        items-start
                        mb-6
                    "
                >

                    <div class="pr-4">

                        <h3
                            class="
                                text-2xl
                                text-[#4B2E1F]
                                mb-3
                                font-semibold
                            "
                        >
                            {{ $form['title'] }}
                        </h3>

                        <p
                            class="
                                text-[#6B4A3A]
                                leading-relaxed
                            "
                        >
                            {{ $form['description'] }}
                        </p>

                    </div>

                    {{-- STATUS --}}
                    @if($form['status'] === 'completed')

                        <span
                            class="
                                bg-[#E8F6EE]
                                text-[#1D7A46]
                                px-4
                                py-2
                                rounded-full
                                text-sm
                                font-medium
                                whitespace-nowrap
                            "
                        >
                            ✓ Terminé
                        </span>

                    @elseif($form['status'] === 'in_progress')

                        <span
                            class="
                                bg-[#FFF5E8]
                                text-[#C87A2A]
                                px-4
                                py-2
                                rounded-full
                                text-sm
                                font-medium
                                whitespace-nowrap
                            "
                        >
                            ⏳ En cours
                        </span>

                    @else

                        <span
                            class="
                                bg-[#F4F1EE]
                                text-[#6B4A3A]
                                px-4
                                py-2
                                rounded-full
                                text-sm
                                font-medium
                                whitespace-nowrap
                            "
                        >
                            ○ À commencer
                        </span>

                    @endif

                </div>

                {{-- PROGRESSION --}}
                <div class="mb-8">

                    <div
                        class="
                            flex
                            justify-between
                            mb-3
                        "
                    >

                        <span
                            class="
                                text-sm
                                text-[#6B4A3A]
                            "
                        >
                            Progression
                        </span>

                        <span
                            class="
                                text-sm
                                font-semibold
                                text-[#4B2E1F]
                            "
                        >
                            {{ $form['progress'] }}%
                        </span>

                    </div>

                    <div
                        class="
                            w-full
                            h-3
                            bg-[#F3E7DA]
                            rounded-full
                            overflow-hidden
                        "
                    >

                        <div
                            class="
                                h-full
                                bg-[#C87A2A]
                                rounded-full
                                transition-all
                                duration-500
                            "
                            style="
                                width: {{ $form['progress'] }}%
                            "
                        ></div>

                    </div>

                </div>

                {{-- ACTION --}}
                <a
                    href="{{ route('forms.run', $form['id']) }}"
                    class="
                        flex
                        items-center
                        justify-center
                        gap-2
                        w-full
                        py-4
                        rounded-2xl
                        bg-[#C87A2A]
                        hover:bg-[#B87426]
                        text-white
                        font-semibold
                        transition-all
                        duration-200
                        shadow-sm
                    "
                >

                    @if($form['progress'] > 0)

                        Continuer →

                    @else

                        Commencer →

                    @endif

                </a>

            </div>

        @endforeach

    </div>

</div>