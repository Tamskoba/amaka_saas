<div
    class="
        min-h-screen
        bg-[#FDF8F4]
        p-6
        md:p-10
    "
>

    <div class="max-w-4xl mx-auto">

        {{-- HEADER --}}
        <div
            class="
                bg-white
                rounded-[40px]
                p-10
                shadow-[0_10px_40px_rgba(0,0,0,0.04)]
                border
                border-[#F1E4D8]
                mb-8
            "
        >

            <p
                class="
                    text-[#C87A2A]
                    italic
                    mb-3
                "
            >
                Questionnaire santé
            </p>

            <h1
                class="
                    text-5xl
                    text-[#4B2E1F]
                    font-bold
                    mb-5
                "
            >
                {{ $form['title'] }}
            </h1>

            <p
                class="
                    text-[#6B4A3A]
                    text-lg
                "
            >
                {{ $form['description'] }}
            </p>

        </div>

        {{-- QUESTION CARD --}}
        <div
            wire:key="question-step-{{ $currentQuestionIndex }}"
            class="
                bg-white
                rounded-[40px]
                p-10
                shadow-[0_10px_40px_rgba(0,0,0,0.04)]
                border
                border-[#F1E4D8]
            "
        >

            @if($currentQuestion)

                {{-- PROGRESS --}}
                <div class="mb-10">

                    <div
                        class="
                            flex
                            justify-between
                            text-sm
                            mb-2
                            text-[#6B4A3A]
                        "
                    >
                        <span>
                            Question
                            {{ $currentQuestionIndex + 1 }}
                            /
                            {{ count($questions) }}
                        </span>

                        <span>
                            {{ $this->progress }}%
                        </span>
                    </div>

                    <div
                        class="
                            h-3
                            bg-[#F1E4D8]
                            rounded-full
                            overflow-hidden
                        "
                    >

                        <div
                            class="
                                h-3
                                bg-[#C87A2A]
                                rounded-full
                            "
                            style="width: {{ $this->progress }}%"
                        ></div>

                    </div>

                </div>
                @error('answer')

                    <div
                        class="
                            mt-4
                            text-red-600
                        "
                    >
                        {{ $message }}
                    </div>

                @enderror
                {{-- QUESTION --}}
                <h2
                    class="
                        text-3xl
                        text-[#4B2E1F]
                        font-semibold
                        mb-8
                    "
                >
                    {{ $currentQuestion['question_text'] }}
                </h2>
                
                {{-- HELP --}}
                @if(!empty($currentQuestion['help_text']))

                    <p
                        class="
                            mb-6
                            text-[#6B4A3A]
                        "
                    >
                        {{ $currentQuestion['help_text'] }}
                    </p>

                @endif

                {{-- TEXT --}}
                @if($currentQuestion['question_type'] === 'text')

                    <input
                        type="text"
                        wire:model="answers.{{ $currentQuestion['id'] }}"
                        placeholder="{{ $currentQuestion['placeholder'] ?? '' }}"
                        class="
                            w-full
                            rounded-2xl
                            border-[#E8D9CC]
                        "
                    >

                @endif

                {{-- TEXTAREA --}}
                @if($currentQuestion['question_type'] === 'textarea')

                    <textarea

                        wire:model="answers.{{ $currentQuestion['id'] }}"

                        rows="5"

                        placeholder="{{ $currentQuestion['placeholder'] ?? '' }}"

                        class="
                            w-full
                            rounded-2xl
                            border-[#E8D9CC]
                        "
                    ></textarea>

                @endif

                {{-- NUMBER --}}
                @if($currentQuestion['question_type'] === 'number')

                    <input
                        type="number"
                        wire:model="answers.{{ $currentQuestion['id'] }}"
                        class="
                            w-full
                            rounded-2xl
                            border-[#E8D9CC]
                        "
                    >

                @endif

                {{-- DATE --}}
                @if($currentQuestion['question_type'] === 'date')

                    <input
                        type="date"
                        wire:model="answers.{{ $currentQuestion['id'] }}"
                        class="
                            w-full
                            rounded-2xl
                            border-[#E8D9CC]
                        "
                    >

                @endif

                {{-- SELECT --}}
                @if($currentQuestion['question_type'] === 'select')

                    <select

                        wire:model="answers.{{ $currentQuestion['id'] }}"

                        class="
                            w-full
                            rounded-2xl
                            border-[#E8D9CC]
                        "
                    >

                        <option value="">
                            Sélectionner...
                        </option>

                        @foreach($currentQuestion['options'] as $option)

                            <option
                                value="{{ $option['option_value'] }}"
                            >
                                {{ $option['option_label'] }}
                            </option>

                        @endforeach

                    </select>

                @endif

                {{-- RADIO --}}
                @if($currentQuestion['question_type'] === 'radio')

                    <div class="space-y-3">

                        @foreach($currentQuestion['options'] as $option)

                            <label
                                class="
                                    flex
                                    items-center
                                    gap-3
                                    p-4
                                    rounded-2xl
                                    border
                                    border-[#F1E4D8]
                                    cursor-pointer
                                "
                            >

                                <input

                                    type="radio"
                                    name="question_{{ $currentQuestion['id'] }}"
                                    value="{{ $option['option_value'] }}"
                                    wire:model.live="answers.{{ $currentQuestion['id'] }}"
                                >

                                <span>
                                    {{ $option['option_label'] }}
                                </span>

                            </label>

                        @endforeach

                    </div>
                @endif

                {{-- CHECKBOX --}}
                @if($currentQuestion['question_type'] === 'checkbox')

                    <div class="space-y-3">

                        @foreach($currentQuestion['options'] as $option)

                            <label
                                class="
                                    flex
                                    items-center
                                    gap-3
                                    p-4
                                    rounded-2xl
                                    border
                                    border-[#F1E4D8]
                                    cursor-pointer
                                "
                            >

                                <input

                                    type="checkbox"

                                    value="{{ $option['option_value'] }}"
                                    wire:model.live="answers.{{ $currentQuestion['id'] }}"
                                >

                                <span>
                                    {{ $option['option_label'] }}
                                </span>

                            </label>

                        @endforeach

                    </div>
                @endif

                {{-- ACTIONS --}}
                <div
                    class="
                        flex
                        justify-between
                        mt-12
                    "
                >

                    <button

                        wire:click="previousQuestion"

                        @disabled($currentQuestionIndex === 0)

                        class="
                            px-6
                            py-3
                            rounded-2xl
                            border
                            border-[#E8D9CC]
                            disabled:opacity-50
                        "
                    >
                        Précédent
                    </button>

                    <button

                        wire:click="nextQuestion"

                        class="
                            px-8
                            py-3
                            rounded-2xl
                            bg-[#4B2E1F]
                            text-black
                        "
                    >

                        @if(
                            $currentQuestionIndex
                            <
                            count($questions)-1
                        )

                            Suivant

                        @else

                            Terminer

                        @endif

                    </button>

                </div>

            @else

                <div class="text-center py-20">

                    <h2
                        class="
                            text-3xl
                            text-[#4B2E1F]
                            mb-4
                        "
                    >
                        Questionnaire terminé
                    </h2>

                    <p
                        class="
                            text-[#6B4A3A]
                        "
                    >
                        Merci pour votre participation.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>