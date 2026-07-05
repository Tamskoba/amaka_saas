{{-- QUESTIONNAIRES ASSIGNÉS --}}
<div class="space-y-8">

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
            grid
            grid-cols-1
            md:grid-cols-2
            xl:grid-cols-3
            gap-6
        "
    >

        @foreach($forms as $form)

            <div
                class="
                    bg-white
                    border
                    border-[#EADFD3]
                    rounded-[28px]
                    p-6
                    shadow-[0_10px_30px_rgba(74,45,33,0.06)]
                    hover:shadow-[0_15px_40px_rgba(74,45,33,0.12)]
                    transition-all
                    duration-300
                    flex
                    flex-col
                    justify-between
                "
            >

                {{-- TOP --}}
                <div>

                    {{-- STATUS --}}
                    <div class="mb-5">

                        @if($form['status'] === 'completed')

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    rounded-full
                                    bg-green-100
                                    text-green-700
                                    px-4
                                    py-2
                                    text-sm
                                    font-medium
                                "
                            >
                                ✓ Complété
                            </span>

                        @elseif($form['status'] === 'in_progress')

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    rounded-full
                                    bg-amber-100
                                    text-amber-700
                                    px-4
                                    py-2
                                    text-sm
                                    font-medium
                                "
                            >
                                ⏳ En cours
                            </span>

                        @else

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    rounded-full
                                    bg-[#F3ECE4]
                                    text-[#8A5B36]
                                    px-4
                                    py-2
                                    text-sm
                                    font-medium
                                "
                            >
                                🕓 Non commencé
                            </span>

                        @endif

                    </div>

                    {{-- TITLE --}}
                    <h2
                        class="
                            text-2xl
                            font-heading
                            text-[#4A2D21]
                            leading-snug
                            mb-4
                        "
                    >
                        {{$form['title']}}
                    </h2>

                    {{-- DESCRIPTION --}}
                    <p
                        class="
                            text-[#6D5245]
                            leading-relaxed
                            line-clamp-4
                            mb-6
                        "
                    >
                        {{ Str::limit($form['description'], 140) }}
                    </p>

                </div>

                {{-- FOOTER --}}
                <div
                    class="
                        flex
                        items-center
                        justify-between
                        pt-5
                        border-t
                        border-[#F0E6DC]
                    "
                >


                     {{-- BUTTON --}}
                    <a
                        href="{{ route('forms.run', $form['id']) }}"
                        class="..."
                    >
                        Ouvrir le questionnaire
                    </a>

                </div>

            </div>

        @endforeach

    </div>

</div>