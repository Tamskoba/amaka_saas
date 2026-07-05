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

            <p
                class="
                    text-[#C87A2A]
                    italic
                    mb-2
                "
            >
                Builder Questionnaire
            </p>

            <h1
                class="
                    text-5xl
                    font-['Playfair_Display']
                    text-[#4B2E1F]
                "
            >

                {{ $form->title }}

            </h1>

        </div>

        <button
            wire:click="addSection"
            class="
                bg-[#4B2E1F]
                hover:bg-[#3D2418]
                text-black
                px-6
                py-4
                rounded-2xl
            "
        >
            Ajouter section
        </button>

    </div>

    {{-- SECTIONS --}}
    <div class="space-y-8">

        @foreach($sections as $section)

            <div
                wire:key="section-{{ $section['id'] }}"
                class="
                    bg-white
                    rounded-[32px]
                    border
                    border-[#F1E4D8]
                    p-8
                    shadow-[0_10px_40px_rgba(0,0,0,0.04)]
                "
            >

                {{-- SECTION HEADER --}}
                <div
                    class="flex items-center gap-2 mb-8"
                >
                    @if(count($section['questions']) === 0)

                        <button
                            wire:click="deleteSection({{ $section['id'] }})"
                            class="
                                px-3
                                py-2
                                rounded-xl
                                bg-red-50
                                text-red-600
                                hover:bg-red-100
                                transition
                            "
                        >
                            🗑 Supprimer
                        </button>

                    @endif

                    <button
                        class="
                            px-5
                            py-3
                            rounded-2xl
                            bg-[#F6EEE7]
                        "
                    >
                        Modifier
                    </button>
                  <div>

                        <h2
                            class="
                                text-3xl
                                text-[#4B2E1F]
                                mb-2
                            "
                        >

                            <div
                                x-data="{

                                    editingTitle: false,

                                    title: `{{ addslashes($section['title']) }}`

                                }"
                            >

                                {{-- DISPLAY --}}
                                <div

                                    x-show="!editingTitle"

                                    @click="editingTitle = true"

                                    class="
                                        text-3xl
                                        text-[#4B2E1F]
                                        mb-2
                                        cursor-pointer
                                        hover:text-[#C87A2A]
                                        transition
                                    "
                                >

                                    <span x-text="title"></span>

                                </div>

                                {{-- INPUT --}}
                                <input

                                    x-show="editingTitle"

                                    x-model="title"

                                    x-ref="titleInput"

                                    @click.away="editingTitle = false"

                                    @keydown.escape.window="editingTitle = false"

                                    @keydown.enter.prevent="

                                        $wire.updateSectionTitle(

                                            {{ $section['id'] }},

                                            title

                                        );

                                        editingTitle = false;

                                    "

                                    x-init="$watch('editingTitle', value => {

                                        if(value) {

                                            setTimeout(() => {

                                                $refs.titleInput.focus()

                                            }, 50)

                                        }

                                    })"

                                    type="text"

                                    class="
                                        w-full
                                        rounded-2xl
                                        border-[#E8D9CC]
                                        text-3xl
                                        text-[#4B2E1F]
                                        focus:border-[#C87A2A]
                                        focus:ring-[#C87A2A]
                                    "
                                >

                            </div>

                        </h2>

                        {{-- DESCRIPTION SECTION --}}
                        <div
                            x-data="{

                                editingDescription: false,

                                description: `{{ addslashes($section['description'] ?? '') }}`

                            }"

                            class="mt-3"
                        >

                            {{-- DISPLAY --}}
                            <div

                                x-show="!editingDescription"

                                @click="editingDescription = true"

                                class="
                                    text-[#8A5A44]
                                    cursor-pointer
                                    hover:text-[#C87A2A]
                                    transition
                                    whitespace-pre-line
                                    leading-relaxed
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

                                rows="3"

                                @click.away="

                                    $wire.updateSectionDescription(

                                        {{ $section['id'] }},

                                        description

                                    );

                                    editingDescription = false;

                                "

                                @keydown.escape.window="editingDescription = false"

                                @keydown.enter.prevent="

                                    if(!$event.shiftKey) {

                                        $wire.updateSectionDescription(

                                            {{ $section['id'] }},

                                            description

                                        );

                                        editingDescription = false;

                                    }

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
                                    text-[#8A5A44]
                                    leading-relaxed
                                "
                            ></textarea>

                        </div>

                        <p class="text-[#8A5A44]">

                            Section questionnaire

                        </p>

                    </div>



                </div>

                {{-- QUESTIONS --}}
                <div class="space-y-5">

                    @foreach($section['questions'] as $question)

                        <div
                            wire:key="question-{{ $question['id'] }}"
                            class="
                                border
                                border-[#F1E4D8]
                                rounded-2xl
                                p-6
                            "
                        >

                            <div
                                class="
                                    flex
                                    items-start
                                "
                            >
                                <button
                                    x-on:click="
                                        if(confirm('Supprimer cette question ?')) {
                                            $wire.deleteQuestion({{ $question['id'] }})
                                        }
                                    "
                                    class="
                                        shrink-0
                                        w-9
                                        h-9
                                        flex
                                        items-center
                                        justify-center
                                        rounded-xl
                                        bg-red-50
                                        text-red-600
                                        hover:bg-red-100
                                        transition
                                    "
                                    title="Supprimer la question"
                                >
                                    🗑
                                </button>
                                <div>

                                    <div
                                        class="
                                            text-lg
                                            font-medium
                                            text-[#4B2E1F]
                                            mb-2
                                        "
                                    >

                                        <div
                                            x-data="{

                                                editing: false,

                                                text: `{{ addslashes($question['question_text']) }}`

                                            }"
                                        >

                                            {{-- DISPLAY --}}
                                            <div

                                                x-show="!editing"

                                                @click="editing = true"

                                                class="
                                                    text-lg
                                                    font-medium
                                                    text-[#4B2E1F]
                                                    mb-2
                                                    cursor-pointer
                                                    hover:text-[#C87A2A]
                                                    transition
                                                "
                                            >

                                                <span x-text="text"></span>

                                            </div>

                                            {{-- INPUT --}}
                                            <input

                                                x-show="editing"

                                                x-model="text"

                                                x-ref="input"

                                                @click.away="

                                                    $wire.updateQuestionText(

                                                        {{ $question['id'] }},

                                                        text

                                                    );

                                                    editing = false;

                                                "

                                                @keydown.escape.window="editing = false"

                                                @keydown.enter.prevent="

                                                    $wire.updateQuestionText(

                                                        {{ $question['id'] }},

                                                        text

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
                                                    rounded-2xl
                                                    border-[#E8D9CC]
                                                    focus:border-[#C87A2A]
                                                    focus:ring-[#C87A2A]
                                                    text-lg
                                                "
                                            >

                                        </div>

                                    </div>

                                    
                                    <div
                                        x-data="{

                                            editing: false,

                                            help: `{{ addslashes($question['help_text'] ?? '') }}`

                                        }"

                                        class="mt-2"
                                    >

                                        {{-- DISPLAY --}}
                                        <div

                                            x-show="!editing"

                                            @click="editing = true"

                                            class="
                                                text-sm
                                                text-[#8A5A44]
                                                cursor-pointer
                                                hover:text-[#C87A2A]
                                                transition
                                            "
                                        >

                                            <template x-if="help">

                                                <span x-text="help"></span>

                                            </template>

                                            <template x-if="!help">

                                                <span class="italic opacity-50">

                                                    Ajouter aide utilisateur...

                                                </span>

                                            </template>

                                        </div>

                                        {{-- INPUT --}}
                                        <input

                                            x-show="editing"

                                            x-model="help"

                                            x-ref="helpInput"

                                            @click.away="

                                                $wire.updateQuestionHelp(

                                                    {{ $question['id'] }},

                                                    help

                                                );

                                                editing = false;

                                            "

                                            @keydown.enter.prevent="

                                                $wire.updateQuestionHelp(

                                                    {{ $question['id'] }},

                                                    help

                                                );

                                                editing = false;

                                            "

                                            type="text"

                                            class="
                                                w-full
                                                rounded-xl
                                                border-[#E8D9CC]
                                                text-sm
                                            "
                                        >

                                    </div>

                                    <select
                                        wire:key="question-type-{{ $question['id'] }}"
                                        wire:change="updateQuestionType(

                                            {{ $question['id'] }},

                                            $event.target.value

                                        )"

                                        class="
                                            rounded-xl
                                            border-[#E8D9CC]
                                            text-sm
                                        "
                                    >
                                        @foreach($this->questionTypes as $value => $label)

                                            <option
                                                value="{{ $value }}"
                                                {{ $question['question_type'] == $value ? 'selected' : '' }}
                                            >
                                                {{ $label }}
                                            </option>

                                        @endforeach

                                    </select>
                                    <button
                                        wire:click="toggleRequired({{ $question['id'] }})"

                                        class="
                                            inline-flex
                                            items-center
                                            gap-2
                                            rounded-full
                                            px-3
                                            py-1
                                            text-xs
                                            font-medium
                                            transition
                                        "

                                        @class([

                                            'bg-[#FFF4E8] text-[#C87A2A]' => $question['is_required'],

                                            'bg-[#F3F4F6] text-gray-500' => ! $question['is_required'],

                                        ])
                                    >

                                        <span
                                            class="
                                                w-2
                                                h-2
                                                rounded-full
                                            "

                                            @class([

                                                'bg-[#C87A2A]' => $question['is_required'],

                                                'bg-gray-400' => ! $question['is_required'],

                                            ])
                                        ></span>

                                        {{ $question['is_required']
                                            ? 'Obligatoire'
                                            : 'Facultative'
                                        }}

                                    </button>
                                    @if(
                                        in_array(
                                            $question['question_type'],
                                            ['radio','checkbox','select']
                                        )
                                    )

                                    <div class="mt-4 space-y-2">

                                        @foreach($question['options'] as $option)

                                            <div
                                                wire:key="option-{{ $option['id'] }}"
                                                class="flex items-center gap-2"
                                            >

                                                {{-- Texte réponse --}}
                                                <input

                                                    type="text"

                                                    value="{{ $option['option_label'] }}"

                                                    wire:change="
                                                        updateOptionLabel(
                                                            {{ $option['id'] }},
                                                            $event.target.value
                                                        )
                                                    "

                                                    class="
                                                        flex-1
                                                        rounded-xl
                                                        border-[#E8D9CC]
                                                    "
                                                >

                                                {{-- Score --}}
                                                <input

                                                    type="number"

                                                    value="{{ $option['option_score'] }}"

                                                    wire:change="
                                                        updateOptionScore(
                                                            {{ $option['id'] }},
                                                            $event.target.value
                                                        )
                                                    "

                                                    class="
                                                        w-24
                                                        rounded-xl
                                                        border-[#E8D9CC]
                                                    "
                                                >

                                                {{-- Delete --}}
                                                <button

                                                    wire:click="
                                                        deleteOption(
                                                            {{ $option['id'] }}
                                                        )
                                                    "

                                                    class="
                                                        w-8
                                                        h-8
                                                        rounded-lg
                                                        text-red-500
                                                        hover:bg-red-50
                                                    "
                                                >
                                                    🗑
                                                </button>

                                            </div>

                                        @endforeach

                                    </div>

                                    @endif
                                    @if(
                                        in_array(
                                            $question['question_type'],
                                            ['radio','checkbox','select']
                                        )
                                    )

                                    <button

                                        wire:click="
                                            addOption(
                                                {{ $question['id'] }}
                                            )
                                        "

                                        class="
                                            mt-3
                                            px-3
                                            py-2
                                            rounded-xl
                                            bg-[#F8F1EB]
                                            hover:bg-[#F1E4D8]
                                            transition
                                        "
                                    >
                                        + Ajouter une réponse
                                    </button>

                                    @endif
                                </div>

                                <button
                                    class="
                                        px-4
                                        py-2
                                        rounded-xl
                                        bg-[#F8F1EB]
                                    "
                                >
                                    Modifier
                                </button>

                            </div>

                        </div>

                    @endforeach

                </div>

                {{-- ADD QUESTION --}}
                <div class="mt-6">

                    <button
                        wire:click="addQuestion({{ $section['id'] }})"
                        class="
                            px-4
                            py-2
                            rounded-xl
                            bg-[#4B2E1F]
                            text-black
                            hover:bg-[#3D2418]
                            transition
                        "
                    >
                        + Ajouter une question
                    </button>

                </div>

            </div>

        @endforeach

    </div>

</div>