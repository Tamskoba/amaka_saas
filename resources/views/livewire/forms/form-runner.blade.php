<div class="max-w-5xl mx-auto">

    @php
        // La consultation d'un questionnaire terminé ne doit jamais permettre
        // de modifier les réponses. Le mode Modifier reste interactif.
        $isReadOnly = $isCompleted && ! $isEditMode;
    @endphp

    {{-- ============================================================
        EN-TÊTE
    ============================================================ --}}

    <div class="mb-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold text-[#4B2E1F]">
                    {{ $form->title }}
                </h1>

                @if (!empty($form->description))
                    <p class="mt-2 text-sm text-[#6B4A3A]">
                        {{ $form->description }}
                    </p>
                @endif
            </div>

            {{-- Bouton de modification pour un questionnaire terminé --}}
            @if ($isCompleted && ! $isEditMode)

                <a
                    href="{{ $editUrl }}"
                    class="
                        inline-flex
                        w-fit
                        flex-none
                        items-center
                        justify-center
                        self-start
                        rounded-lg
                        bg-[#C87A2A]
                        px-4
                        py-2
                        text-sm
                        font-medium
                        text-white
                        transition
                        hover:bg-[#A95F18]
                        whitespace-nowrap
                    "
                    style="
                        display: inline-flex;
                        width: fit-content;
                        max-width: max-content;
                        flex: 0 0 auto;
                        align-self: center;
                        background-color: #BB7229;
                        padding: 10px 16px;
                    "
                >
                    Modifier mes réponses
                </a>

            @endif

        </div>

    </div>


    {{-- ============================================================
        QUESTIONNAIRE TERMINÉ — MODE CONSULTATION
    ============================================================ --}}

    @if ($isCompleted && ! $isEditMode)

        <div
            class="
                mb-6
                rounded-xl
                border
                border-[#D9EAD3]
                bg-[#F3FAF1]
                px-5
                py-4
            "
        >
            <div class="flex items-start gap-3">

                <div
                    class="
                        mt-0.5
                        flex
                        h-8
                        w-8
                        shrink-0
                        items-center
                        justify-center
                        rounded-full
                        bg-[#D9EAD3]
                        text-[#3F6B35]
                    "
                >
                    ✓
                </div>

                <div>
                    <p class="font-semibold text-[#3F6B35]">
                        Questionnaire terminé
                    </p>

                    <p class="mt-1 text-sm text-[#5F735A]">
                        Vous consultez actuellement vos réponses.
                        Vous pouvez les modifier à tout moment en cliquant
                        sur « Modifier mes réponses ».
                    </p>
                </div>

            </div>
        </div>

    @endif


    {{-- ============================================================
        MODE MODIFICATION
    ============================================================ --}}

    @if ($isCompleted && $isEditMode)

        <div
            class="
                mb-6
                rounded-xl
                border
                border-[#EADFD3]
                bg-[#FFF8F2]
                px-5
                py-4
            "
        >
            <div class="flex items-start gap-3">

                <div
                    class="
                        mt-0.5
                        flex
                        h-8
                        w-8
                        shrink-0
                        items-center
                        justify-center
                        rounded-full
                        bg-[#F3E0CF]
                        text-[#A95F18]
                    "
                >
                    ✎
                </div>

                <div>
                    <p class="font-semibold text-[#4B2E1F]">
                        Modification de vos réponses
                    </p>

                    <p class="mt-1 text-sm text-[#6B4A3A]">
                        Vous pouvez modifier les réponses enregistrées.
                        Vos modifications seront enregistrées à la fin du questionnaire.
                    </p>
                </div>

            </div>
        </div>

    @endif


    {{-- ============================================================
        QUESTIONNAIRE SANS QUESTION
    ============================================================ --}}

    @if (! $question)

        @if (! $isCompleted)

            <div
                class="
                    rounded-xl
                    border
                    border-[#EADFD3]
                    bg-white
                    p-8
                    text-center
                    shadow-sm
                "
            >
                <p class="text-[#6B4A3A]">
                    Aucune question disponible.
                </p>
            </div>

        @else

            <div
                class="
                    rounded-xl
                    border
                    border-[#D9EAD3]
                    bg-[#F3FAF1]
                    p-8
                    text-center
                "
            >
                <p class="font-semibold text-[#3F6B35]">
                    Questionnaire terminé
                </p>

                <p class="mt-2 text-sm text-[#5F735A]">
                    Vos réponses ont bien été enregistrées.
                </p>
            </div>

        @endif

    @else


        {{-- ========================================================
            PROGRESSION
        ======================================================== --}}

        <div class="mb-6">

            <div class="mb-2 flex items-center justify-between">

                <span class="text-sm font-medium text-[#6B4A3A]">
                    Question {{ $currentQuestionIndex + 1 }}
                    sur {{ count($questions) }}
                </span>

                <span class="text-sm font-medium text-[#6B4A3A]">
                    {{ $this->progress }} %
                </span>

            </div>

            <div
                class="
                    h-2
                    w-full
                    overflow-hidden
                    rounded-full
                    bg-[#EADFD3]
                "
            >
                <div
                    class="
                        h-full
                        rounded-full
                        bg-[#C87A2A]
                        transition-all
                        duration-300
                    "
                    style="width: {{ $this->progress }}%"
                ></div>
            </div>

        </div>


        {{-- ========================================================
            CARTE QUESTION
        ======================================================== --}}

        <div
            class="
                rounded-2xl
                border
                border-[#EADFD3]
                p-6
                shadow-sm
                md:p-8
            "
        >

            {{-- Section --}}
            @if (!empty($question['section_title']))

                <div class="mb-3">
                    <span
                        class="
                            inline-flex
                            rounded-full
                            bg-[#F7F2EE]
                            px-3
                            py-1
                            text-xs
                            font-medium
                            text-[#6B4A3A]
                        "
                    >
                        {{ $question['section_title'] }}
                    </span>
                </div>

            @endif


            {{-- ====================================================
                INTITULÉ DE LA QUESTION
            ==================================================== --}}

            <div class="mb-6">

                <h2
                    class="
                        text-lg
                        font-semibold
                        leading-relaxed
                        text-[#4B2E1F]
                        md:text-xl
                    "
                >
                    {{ $question['question_text'] ?? $question['label'] ?? '' }}

                    @if ($question['is_required'] ?? false)
                        <span class="text-red-500">*</span>
                    @endif

                </h2>

            </div>


            {{-- ====================================================
                RADIO
            ==================================================== --}}

            <fieldset
                @disabled($isReadOnly)
                class="min-w-0"
            >

            @if (($question['question_type'] ?? null) === 'radio')

                <div class="space-y-3">

                    @foreach (($question['options'] ?? []) as $option)

                        @php
                            $optionValue =
                                $option['option_value']
                                ?? $option['value']
                                ?? '';

                            $optionLabel =
                                $option['option_label']
                                ?? $option['label']
                                ?? $optionValue;
                        @endphp

                        <label
                            wire:key="radio-{{ $question['id'] }}-{{ md5((string) $optionValue) }}"
                            class="
                                flex
                                cursor-pointer
                                items-center
                                gap-3
                                rounded-xl
                                border
                                border-[#EADFD3]
                                bg-[#FFFDFC]
                                p-4
                                transition
                                hover:border-[#C87A2A]
                                hover:bg-[#FFF8F2]
                            "
                        >
                            <input
                                type="radio"
                                name="question-{{ $question['id'] }}"
                                value="{{ (string) $optionValue }}"
                                wire:model.live="answers.{{ $question['id'] }}"
                                class="
                                    h-4
                                    w-4
                                    border-[#CDBFB4]
                                    text-[#C87A2A]
                                    focus:ring-[#C87A2A]
                                "
                            >

                            <span class="text-sm text-[#6B4A3A]">
                                {{ $optionLabel }}
                            </span>
                        </label>

                    @endforeach

                </div>


                {{-- Fréquence conditionnelle pour les réponses radio --}}
                @if (
                    $this->isTemporalQuestion($question)
                    && $this->shouldShowFrequencyForAnswer(
                        $question,
                        $answers[$question['id']] ?? null
                    )
                )

                    <div class="mt-5">

                        <label
                            class="
                                mb-2
                                block
                                text-sm
                                font-medium
                                text-[#4B2E1F]
                            "
                        >
                            Fréquence des symptômes
                        </label>

                        <select
                            wire:model.live="frequencies.{{ $question['id'] }}"
                            wire:change="clearFrequencyError"
                            class="
                                w-full
                                rounded-lg
                                border
                                border-[#EADFD3]
                                bg-white
                                px-4
                                py-3
                                text-sm
                                text-[#6B4A3A]
                                focus:border-[#C87A2A]
                                focus:ring-[#C87A2A]
                            "
                        >

                            <option value="">
                                Sélectionnez une fréquence
                            </option>

                            <option value="rarement">
                                Rarement (≤ 1 fois/mois)
                            </option>

                            <option value="parfois">
                                Parfois (1–3 fois/semaine)
                            </option>

                            <option value="souvent">
                                Souvent (≥ 4 fois/semaine)
                            </option>

                            <option value="quotidien">
                                Quotidien / quasi quotidien
                            </option>

                        </select>

                    </div>

                @endif


            {{-- ====================================================
                CHECKBOX
            ==================================================== --}}

            @elseif (($question['question_type'] ?? null) === 'checkbox')

                @php
                    $selectedValues = is_array($answers[$question['id']] ?? null)
                        ? array_map('strval', $answers[$question['id']])
                        : [];

                    $aucunValue = null;

                    foreach (($question['options'] ?? []) as $option) {
                        $value = (string) (
                            $option['option_value']
                            ?? $option['value']
                            ?? ''
                        );

                        $label = trim((string) (
                            $option['option_label']
                            ?? $option['label']
                            ?? $value
                        ));

                        if (
                            mb_strtolower($value) === 'aucun'
                            || mb_strtolower($label) === 'aucun'
                        ) {
                            $aucunValue = $value;
                            break;
                        }
                    }
                @endphp

                <div
                    x-data="{
                        selected: @js($selectedValues),
                        aucun: @js($aucunValue),

                        sync(value, checked) {
                            value = String(value);
                            this.selected = this.selected.map(v => String(v));

                            if (
                                this.aucun !== null
                                && value === String(this.aucun)
                            ) {
                                this.selected = checked
                                    ? [String(this.aucun)]
                                    : this.selected.filter(
                                        v => v !== String(this.aucun)
                                    );
                            } else if (checked) {
                                if (this.aucun !== null) {
                                    this.selected = this.selected.filter(
                                        v => v !== String(this.aucun)
                                    );
                                }

                                if (!this.selected.includes(value)) {
                                    this.selected.push(value);
                                }
                            } else {
                                this.selected = this.selected.filter(
                                    v => v !== value
                                );
                            }

                            this.$wire.set(
                                'answers.{{ $question['id'] }}',
                                this.selected,
                                true
                            );
                        }
                    }"
                    class="space-y-3"
                >

                    @foreach (($question['options'] ?? []) as $option)

                        @php
                            $optionValue =
                                $option['option_value']
                                ?? $option['value']
                                ?? '';

                            $optionLabel =
                                $option['option_label']
                                ?? $option['label']
                                ?? $optionValue;
                        @endphp

                        <label
                            class="
                                flex
                                cursor-pointer
                                items-start
                                gap-3
                                rounded-xl
                                border
                                border-[#EADFD3]
                                bg-[#FFFDFC]
                                p-4
                                transition
                                hover:border-[#C87A2A]
                                hover:bg-[#FFF8F2]
                            "
                        >

                            <input
                                type="checkbox"
                                value="{{ (string) $optionValue }}"
                                x-model="selected"
                                @change="sync(@js((string) $optionValue), $event.target.checked)"
                                wire:key="checkbox-{{ $question['id'] }}-{{ md5((string) $optionValue) }}"
                                class="
                                    rounded
                                    border-[#DCCBBB]
                                    text-[#C9822B]
                                    focus:ring-[#C9822B]
                                "
                            >

                            <div class="min-w-0 flex-1">

                                <span class="text-sm text-[#6B4A3A]">
                                    {{ $optionLabel }}
                                </span>

                                {{-- Fréquence individuelle pour chaque option cochée --}}
                                @if (
                                    $this->isTemporalQuestion($question)
                                    && in_array(
                                        (string) $optionValue,
                                        $selectedValues,
                                        true
                                    )
                                    && mb_strtolower(trim((string) $optionLabel)) !== 'aucun'
                                    && mb_strtolower(trim((string) $optionValue)) !== 'aucun'
                                )

                                    <div
                                        class="mt-3"
                                        wire:key="frequency-{{ $question['id'] }}-{{ md5((string) $optionValue) }}"
                                    >

                                        <label
                                            class="
                                                mb-1
                                                block
                                                text-xs
                                                font-medium
                                                text-[#4B2E1F]
                                            "
                                        >
                                            Fréquence de « {{ $optionLabel }} »
                                        </label>

                                        <select
                                            wire:model.live="frequencies.{{ $question['id'] }}.{{ $optionValue }}"
                                            wire:change="clearFrequencyError"
                                            class="
                                                w-full
                                                rounded-lg
                                                border
                                                border-[#EADFD3]
                                                bg-white
                                                px-3
                                                py-2
                                                text-sm
                                                text-[#6B4A3A]
                                                focus:border-[#C87A2A]
                                                focus:ring-[#C87A2A]
                                            "
                                        >

                                            <option value="">
                                                Sélectionnez une fréquence
                                            </option>

                                            <option value="rarement">
                                                Rarement (≤ 1 fois/mois)
                                            </option>

                                            <option value="parfois">
                                                Parfois (1–3 fois/semaine)
                                            </option>

                                            <option value="souvent">
                                                Souvent (≥ 4 fois/semaine)
                                            </option>

                                            <option value="quotidien">
                                                Quotidien / quasi quotidien
                                            </option>

                                        </select>

                                    </div>

                                @endif

                            </div>

                        </label>

                    @endforeach

                </div>


            {{-- ====================================================
                TEXTE
            ==================================================== --}}

            @elseif (($question['question_type'] ?? null) === 'text')

                <div>

                    <label
                        for="answer-{{ $question['id'] }}"
                        class="
                            mb-2
                            block
                            text-sm
                            font-medium
                            text-[#4B2E1F]
                        "
                    >
                        Votre réponse
                    </label>

                    <input
                        id="answer-{{ $question['id'] }}"
                        type="text"
                        wire:model.live.debounce.500ms="answers.{{ $question['id'] }}"
                        placeholder="{{ $question['placeholder'] ?? 'Votre réponse...' }}"
                        class="
                            w-full
                            rounded-lg
                            border
                            border-[#EADFD3]
                            bg-white
                            px-4
                            py-3
                            text-sm
                            text-[#4B2E1F]
                            placeholder-[#A99486]
                            focus:border-[#C87A2A]
                            focus:outline-none
                            focus:ring-2
                            focus:ring-[#C87A2A]/20
                        "
                    >

                </div>


            {{-- ====================================================
                TEXTAREA
            ==================================================== --}}

            @elseif (($question['question_type'] ?? null) === 'textarea')

                <div>

                    <label
                        for="answer-{{ $question['id'] }}"
                        class="
                            mb-2
                            block
                            text-sm
                            font-medium
                            text-[#4B2E1F]
                        "
                    >
                        Votre réponse
                    </label>

                    <textarea
                        id="answer-{{ $question['id'] }}"
                        wire:model.live.debounce.500ms="answers.{{ $question['id'] }}"
                        rows="{{ $question['rows'] ?? 5 }}"
                        placeholder="{{ $question['placeholder'] ?? 'Votre réponse...' }}"
                        class="
                            w-full
                            rounded-lg
                            border
                            border-[#EADFD3]
                            bg-white
                            px-4
                            py-3
                            text-sm
                            text-[#4B2E1F]
                            placeholder-[#A99486]
                            focus:border-[#C87A2A]
                            focus:outline-none
                            focus:ring-2
                            focus:ring-[#C87A2A]/20
                        "
                    ></textarea>

                </div>


            {{-- ====================================================
                DATE
            ==================================================== --}}

            @elseif (($question['question_type'] ?? null) === 'date')

                <div>

                    <label
                        for="answer-{{ $question['id'] }}"
                        class="
                            mb-2
                            block
                            text-sm
                            font-medium
                            text-[#4B2E1F]
                        "
                    >
                        Votre réponse
                    </label>

                    <input
                        id="answer-{{ $question['id'] }}"
                        type="date"
                        wire:model.live="answers.{{ $question['id'] }}"
                        class="
                            w-full
                            rounded-lg
                            border
                            border-[#EADFD3]
                            bg-white
                            px-4
                            py-3
                            text-sm
                            text-[#4B2E1F]
                            focus:border-[#C87A2A]
                            focus:outline-none
                            focus:ring-2
                            focus:ring-[#C87A2A]/20
                        "
                    >

                </div>


            {{-- ====================================================
                SELECT
            ==================================================== --}}

            @elseif (($question['question_type'] ?? null) === 'select')

                <div>

                    <label
                        for="answer-{{ $question['id'] }}"
                        class="
                            mb-2
                            block
                            text-sm
                            font-medium
                            text-[#4B2E1F]
                        "
                    >
                        Votre réponse
                    </label>

                    <select
                        id="answer-{{ $question['id'] }}"
                        wire:model.live="answers.{{ $question['id'] }}"
                        class="
                            w-full
                            rounded-lg
                            border
                            border-[#EADFD3]
                            bg-white
                            px-4
                            py-3
                            text-sm
                            text-[#6B4A3A]
                            focus:border-[#C87A2A]
                            focus:ring-[#C87A2A]
                        "
                    >

                        <option value="">
                            Sélectionnez une réponse
                        </option>

                        @foreach (($question['options'] ?? []) as $option)

                            @php
                                $optionValue =
                                    $option['option_value']
                                    ?? $option['value']
                                    ?? '';

                                $optionLabel =
                                    $option['option_label']
                                    ?? $option['label']
                                    ?? $optionValue;
                            @endphp

                            <option value="{{ $optionValue }}">
                                {{ $optionLabel }}
                            </option>

                        @endforeach

                    </select>

                </div>


            {{-- ====================================================
                NOMBRE
            ==================================================== --}}

            @elseif (($question['question_type'] ?? null) === 'number')

                <div>

                    <label
                        for="answer-{{ $question['id'] }}"
                        class="
                            mb-2
                            block
                            text-sm
                            font-medium
                            text-[#4B2E1F]
                        "
                    >
                        Votre réponse
                    </label>

                    <input
                        id="answer-{{ $question['id'] }}"
                        type="number"
                        wire:model.live.debounce.500ms="answers.{{ $question['id'] }}"
                        min="{{ $question['min'] ?? '' }}"
                        max="{{ $question['max'] ?? '' }}"
                        step="{{ $question['step'] ?? '1' }}"
                        class="
                            w-full
                            rounded-lg
                            border
                            border-[#EADFD3]
                            bg-white
                            px-4
                            py-3
                            text-sm
                            text-[#4B2E1F]
                            focus:border-[#C87A2A]
                            focus:outline-none
                            focus:ring-2
                            focus:ring-[#C87A2A]/20
                        "
                    >

                </div>

            @endif

            </fieldset>

            {{-- ====================================================
                MESSAGE D'ERREUR
            ==================================================== --}}

            @error('answer')

                <div
                    class="
                        mt-4
                        rounded-lg
                        border
                        border-red-200
                        bg-red-50
                        px-4
                        py-3
                        text-sm
                        text-red-700
                    "
                    style="
                        color: red;
                        font-weight: bold;
                    "
                >
                    {{ $message }}
                </div>

            @enderror


            @error('frequency')

                <div
                    class="
                        mt-4
                        rounded-lg
                        border
                        border-red-200
                        bg-red-50
                        px-4
                        py-3
                        text-sm
                        text-red-700
                    "
                    style="
                        color: red;
                        font-weight: bold;
                    "
                >
                    {{ $message }}
                </div>

            @enderror


            {{-- ====================================================
                NAVIGATION
            ==================================================== --}}

            <div
                class="
                    mt-8
                    flex
                    flex-wrap
                    gap-3
                    border-t
                    border-[#EADFD3]
                    pt-6
                    items-center
                    justify-center
                "
            >

                {{-- Bouton précédent --}}
                <div>

                    @if ($currentQuestionIndex > 0)

                        <button
                            type="button"
                            wire:click="previousQuestion"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                rounded-lg
                                border
                                border-[#D8C9BE]
                                bg-white
                                px-5
                                py-2.5
                                text-sm
                                font-medium
                                text-white
                                transition
                                hover:bg-[#F7F2EE]
                            "
                            style="
                                background-color: #BB7229;
                                padding-top: 10px;
                                padding-bottom: 10px;
                            "
                        >
                            ← Précédent
                        </button>

                    @endif

                </div>


                {{-- Bouton suivant / terminer --}}
                <div>

                    @if ($currentQuestionIndex < count($questions) - 1)

                        <button
                            type="button"
                            wire:click="nextQuestion"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                rounded-lg
                                bg-[#C87A2A]
                                px-5
                                py-2.5
                                text-sm
                                font-medium
                                text-white
                                transition
                                hover:bg-[#A95F18]
                            "
                            style="
                                background-color: #BB7229;
                                padding-top: 10px;
                                padding-bottom: 10px;
                            "
                        >
                            Suivant →
                        </button>

                    @else

                        @if ($isReadOnly)

                            <button
                                type="button"
                                disabled
                                aria-disabled="true"
                                class="
                                    inline-flex
                                    cursor-not-allowed
                                    items-center
                                    justify-center
                                    rounded-lg
                                    bg-[#EADFD3]
                                    px-5
                                    py-2.5
                                    text-sm
                                    font-medium
                                    text-[#6B4A3A]
                                    opacity-80
                                "
                                style="
                                    padding-top: 10px;
                                    padding-bottom: 10px;
                                "
                            >
                                Fin du questionnaire
                            </button>

                        @else

                            <button
                                type="button"
                                wire:click="nextQuestion"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    rounded-lg
                                    bg-[#4B2E1F]
                                    px-5
                                    py-2.5
                                    text-sm
                                    font-medium
                                    text-white
                                    transition
                                    hover:bg-[#351F16]
                                "
                                style="
                                    background-color: #BB7229;
                                    padding-top: 10px;
                                    padding-bottom: 10px;
                                "
                            >
                                @if ($isEditMode)
                                    Enregistrer les modifications
                                @else
                                    Terminer le questionnaire
                                @endif
                            </button>

                        @endif

                    @endif

                </div>

            </div>

        </div>

    @endif

</div>