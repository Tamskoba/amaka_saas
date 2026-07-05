<div
    class="
        max-w-4xl
        mx-auto
        space-y-8
    "
>

    <div>

        <p
            class="
                text-[#C87A2A]
                italic
                mb-2
            "
        >
            Administration
        </p>

        <h1
            class="
                text-5xl
                font-['Playfair_Display']
                text-[#4B2E1F]
            "
        >
            Nouveau questionnaire
        </h1>

    </div>

    <div
        class="
            bg-white
            rounded-[32px]
            p-10
            border
            border-[#F1E4D8]
        "
    >

        <form
            wire:submit="save"
            class="space-y-8"
        >

            {{-- TITLE --}}
            <div>

                <label
                    class="
                        block
                        mb-3
                        font-medium
                    "
                >
                    Titre
                </label>

                <input
                    type="text"
                    wire:model="title"
                    class="
                        w-full
                        rounded-2xl
                        border-[#E8D9CC]
                        focus:border-[#C87A2A]
                        focus:ring-[#C87A2A]
                    "
                >

            </div>

            {{-- DESCRIPTION --}}
            <div>

                <label
                    class="
                        block
                        mb-3
                        font-medium
                    "
                >
                    Description
                </label>

                <textarea
                    wire:model="description"
                    rows="6"
                    class="
                        w-full
                        rounded-2xl
                        border-[#E8D9CC]
                        focus:border-[#C87A2A]
                        focus:ring-[#C87A2A]
                    "
                ></textarea>

            </div>

            {{-- ACTIVE --}}
            <div class="flex items-center gap-3">

                <input
                    type="checkbox"
                    wire:model="is_active"
                >

                <span>
                    Questionnaire actif
                </span>

            </div>

            {{-- ACTION --}}
            <button
                type="submit"
                class="
                    bg-[#4B2E1F]
                    hover:bg-[#3D2418]
                    text-black
                    px-8
                    py-4
                    rounded-2xl
                    transition
                "
            >
                Créer le questionnaire
            </button>

        </form>

    </div>

</div>