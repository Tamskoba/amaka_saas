<div class="space-y-8">

    {{-- HEADER --}}
    <div
        class="
            flex
            items-center
            justify-between
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
                Questionnaires
            </h1>

        </div>

        <a
            href="{{ route('admin.forms.create') }}"
            class="
                bg-[#4B2E1F]
                hover:bg-[#3D2418]
                text-black
                px-6
                py-4
                rounded-2xl
                transition
            "
        >
            Nouveau questionnaire
        </a>
        <br>
        <a
            href="{{ route('admin.forms.import') }}"
            class="
                block
                px-5
                py-4
                rounded-2xl
                hover:bg-[#F8F1EB]
            "
        >
            Import JSON
        </a>

        <a
            href="{{ route('admin.trash.index') }}"
        >
            Corbeille
        </a>

    </div>

    {{-- TABLE --}}
    <div
        class="
            bg-white/70
            backdrop-blur-sm
            border
            border-[#EADFD3]
            rounded-[32px]
            shadow-[0_10px_40px_rgba(74,45,33,0.08)]
            p-6
        "
    >

        <table
            class="
                w-full
                bg-white
                rounded-3xl
                overflow-hidden
            "
        >

            <thead
                class="
                    bg-[#F7F2EE]
                    text-[#4B2E1F]
                "
            >

                <tr>

                    <th class="p-6">
                        Titre
                    </th>

                    <th class="p-6">
                        Statut
                    </th>

                    <th class="p-6">
                        Date
                    </th>

                    <th class="p-6">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>
                @foreach($forms as $form)

                    <tr
                        class="
                            border-t
                            border-[#F1E4D8]
                        "
                    >

                        <td class="p-6">

                            <div
                                class="
                                    font-semibold
                                    text-[#4B2E1F]
                                "
                            >

                                <div
                                    x-data="{

                                        editing: false,

                                        title: '{{ addslashes($form->title) }}'

                                    }"
                                >

                                    {{-- DISPLAY --}}
                                    <div
                                        x-show="!editing"
                                        @click="editing = true"

                                        class="
                                            font-semibold
                                            text-[#4B2E1F]
                                            cursor-pointer
                                            hover:text-[#C87A2A]
                                            transition
                                        "
                                    >

                                        {{ $form->title }}

                                    </div>

                                    {{-- INPUT --}}
                                    <input
                                        x-show="editing"

                                        x-model="title"

                                        x-ref="input"

                                        @click.away="editing = false"

                                        @keydown.escape.window="editing = false"

                                        @keydown.enter.prevent="

                                            $wire.updateTitle(

                                                {{ $form->id }},

                                                title

                                            );

                                            editing = false;

                                        "

                                        x-init="$watch('editing', value => {

                                            if(value) {

                                                setTimeout(() => {

                                                    $refs.input.focus()

                                                }, 50)

                                            }

                                        })"

                                        type="text"

                                        class="
                                            w-full
                                            rounded-xl
                                            border-[#E8D9CC]
                                            focus:border-[#C87A2A]
                                            focus:ring-[#C87A2A]
                                        "
                                    >

                                </div>

                            </div>

                            <div
                                class="
                                    text-sm
                                    text-[#8A5A44]
                                "
                            >

                                <div
                                    x-data="{

                                        editingDescription: false,

                                        description: `{{ addslashes($form->description ?? '') }}`

                                    }"
                                >

                                    {{-- DISPLAY --}}
                                    <div

                                        x-show="!editingDescription"

                                        @click="editingDescription = true"

                                        class="
                                            text-sm
                                            text-[#8A5A44]
                                            cursor-pointer
                                            hover:text-[#C87A2A]
                                            transition
                                            whitespace-pre-line
                                        "
                                    >

                                        <template x-if="description">

                                            <span x-text="description"></span>

                                        </template>

                                        <template x-if="!description">

                                            <span class="italic opacity-50">

                                                Ajouter une description...

                                            </span>

                                        </template>

                                    </div>

                                    {{-- TEXTAREA --}}
                                    <textarea

                                        x-show="editingDescription"

                                        x-model="description"

                                        x-ref="textarea"

                                        rows="4"

                                        @click.away="editingDescription = false"

                                        @keydown.escape.window="editingDescription = false"

                                        @keydown.enter.prevent="

                                            $wire.updateDescription(

                                                {{ $form->id }},

                                                description

                                            );

                                            editingDescription = false;

                                        "

                                        x-init="$watch('editingDescription', value => {

                                            if(value) {

                                                setTimeout(() => {

                                                    $refs.textarea.focus()

                                                    $refs.textarea.style.height = 'auto'

                                                    $refs.textarea.style.height =

                                                        $refs.textarea.scrollHeight + 'px'

                                                }, 50)

                                            }

                                        })"

                                        @input="

                                            $el.style.height = 'auto';

                                            $el.style.height = $el.scrollHeight + 'px';

                                        "

                                        class="
                                            w-full
                                            rounded-2xl
                                            border-[#E8D9CC]
                                            focus:border-[#C87A2A]
                                            focus:ring-[#C87A2A]
                                            resize-none
                                            overflow-hidden
                                            text-sm
                                        "
                                    ></textarea>

                                </div>

                            </div>

                        </td>

                        <td class="p-6">

                            <button

                                wire:click="toggleStatus({{ $form->id }})"

                                class="
                                    inline-flex
                                    items-center
                                    gap-2
                                    px-4
                                    py-2
                                    rounded-full
                                    transition
                                "

                                @class([

                                    'bg-green-50 text-green-700 border border-green-200' => $form->is_active,

                                    'bg-gray-100 text-gray-600 border border-gray-200' => ! $form->is_active,

                                ])

                            >

                                <span
                                    class="
                                        w-2
                                        h-2
                                        rounded-full
                                    "

                                    @class([

                                        'bg-green-500' => $form->is_active,

                                        'bg-gray-400' => ! $form->is_active,

                                    ])
                                ></span>

                                {{ $form->is_active ? 'Actif' : 'Inactif' }}

                            </button>

                        </td>

                        <td class="p-6">

                            {{ $form->created_at->format('d/m/Y') }}

                        </td>

                        <td class="p-6">

                            <div class="flex gap-3">

                                <a
                                    href="{{ route('admin.forms.edit', $form->id) }}"
                                    class="
                                        px-4
                                        py-2
                                        rounded-xl
                                        bg-[#F6EEE7]
                                        hover:bg-[#EFE2D5]
                                    "
                                >
                                    Modifier
                                </a>
                                <button
                                    wire:click="deleteForm({{ $form['id'] }})"
                                    wire:confirm="Supprimer ce questionnaire ?"
                                    class="
                                        px-3
                                        py-1
                                        rounded-lg
                                        bg-red-100
                                        text-red-600
                                    "
                                >
                                    Supprimer
                                </button>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        <div class="p-6">

            {{ $forms->links() }}

        </div>

    </div>

</div>