<div
    class="
        max-w-5xl
        mx-auto
        space-y-8
    "
>

    {{-- HEADER --}}
    <div>

        <p
            class="
                text-[#C87A2A]
                italic
                mb-2
            "
        >
            Import Questionnaire
        </p>

        <h1
            class="
                text-5xl
                font-['Playfair_Display']
                text-[#4B2E1F]
            "
        >
            Import JSON
        </h1>

    </div>

    {{-- CARD --}}
    <div
        class="
            bg-white
            rounded-[32px]
            p-10
            border
            border-[#F1E4D8]
        "
    >

        @if(session('success'))

            <div
                class="
                    bg-[#E8F6EE]
                    text-[#1D7A46]
                    p-4
                    rounded-2xl
                    mb-6
                "
            >
                {{ session('success') }}
            </div>

        @endif

        {{-- FORM --}}
        <form
            wire:submit="import"
            class="space-y-8"
        >

            <div>

                <label
                    class="
                        block
                        mb-3
                        font-medium
                    "
                >
                    JSON questionnaire
                </label>

            <div>

                <label
                    class="
                        block
                        mb-3
                        font-medium
                    "
                >
                    Fichiers JSON
                </label>

                <input
                    type="file"
                    wire:model="files"
                    multiple
                    accept=".json"
                    class="
                        w-full
                        rounded-2xl
                        border-[#E8D9CC]
                    "
                >

            </div>

            </div>

            <button
                type="submit"
                class="
                    bg-[#4B2E1F]
                    hover:bg-[#3D2418]
                    text-black
                    px-8
                    py-4
                    rounded-2xl
                "
            >
                Importer questionnaire
            </button>

        </form>
        
        <div wire:loading>

            <div
                class="
                    bg-[#F8F1EB]
                    p-4
                    rounded-2xl
                    mt-4
                "
            >
                Importation en cours...
            </div>

        </div>
    </div>

</div>