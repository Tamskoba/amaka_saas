<div class="max-w-4xl mx-auto">

    <h1
        class="
            text-2xl
            font-semibold
            mb-6
        "
    >
        Questionnaires de
        {{ $user->first_name }}
        {{ $user->last_name }}
    </h1>

    @if(session('success'))

        <div
            class="
                mb-4
                p-4
                rounded-lg
                bg-green-100
                text-green-700
            "
        >
            {{ session('success') }}
        </div>

    @endif

    <div
        class="
            bg-white
            border
            rounded-xl
            p-6
        "
    >

        <div class="space-y-4">

            @foreach($forms as $form)

                <label
                    class="
                        flex
                        items-center
                        gap-3
                    "
                >

                    <input
                        type="checkbox"
                        value="{{ $form->id }}"
                        wire:model="selectedForms"
                    >

                    <span>
                        {{ $form->title }}
                    </span>

                </label>

            @endforeach

        </div>

        <div class="mt-8">

            <button
                wire:click="save"
                class="
                    px-5
                    py-3
                    rounded-lg
                    bg-[#C87A2A]
                    text-black
                "
            >
                Enregistrer
            </button>

        </div>

    </div>

</div>