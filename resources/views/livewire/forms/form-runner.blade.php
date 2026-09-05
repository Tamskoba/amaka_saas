<div class="max-w-4xl mx-auto py-8 px-4">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-semibold text-[#4A2D21]">
            {{ $form->title }}
        </h1>

        @if($form->description)
            <p class="mt-2 text-[#6B554B]">
                {{ $form->description }}
            </p>
        @endif
    </div>


    {{-- QUESTIONNAIRE TERMINE --}}
    @if($isCompleted && ! $isEditMode)

        <div class="bg-white rounded-3xl border border-[#EADFD3] shadow-sm p-8 md:p-12 text-center">

            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-green-700 text-3xl">
                ✓
            </div>

            <h2 class="text-2xl md:text-3xl font-semibold text-[#4A2D21]">
                Questionnaire terminé
            </h2>

            <p class="mt-3 text-[#6B554B] text-lg">
                ✓ Toutes vos réponses ont été enregistrées.
            </p>

            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">

                @if(Route::has('forms.responses'))
                    <a
                        href="{{ route('forms.responses', $form->id) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-[#C87A2A] px-6 py-3 font-medium text-[#C87A2A] hover:bg-[#FFF7EF]"
                    >
                        Consulter mes réponses
                    </a>
                @endif

                <a
                    href="{{ route('forms.run', $form->id) }}?edit=1"
                    class="inline-flex items-center justify-center rounded-xl bg-[#C87A2A] px-6 py-3 font-medium text-white hover:bg-[#A96220]"
                >
                    Modifier mes réponses
                </a>

                <a
                    href="{{ route('forms.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-[#C87A2A] px-6 py-3 font-medium text-[#C87A2A] hover:bg-[#FFF7EF]"
                >
                    Retour à mes questionnaires
                </a>

            </div>
        </div>


    @else

        {{-- AUCUNE QUESTION --}}
        @if(! $question)

            <div class="bg-white rounded-3xl border border-[#EADFD3] p-8 text-center">
                <p class="text-[#6B554B]">
                    Aucune question disponible.
                </p>
            </div>

        @else

            {{-- PROGRESSION --}}
            <div class="mb-8">

                <div class="flex justify-between items-center mb-2">

                    <span class="text-sm font-medium text-[#6B554B]">
                        Question {{ $currentQuestionIndex + 1 }}
                        sur {{ count($questions) }}
                    </span>

                    <span class="text-sm font-semibold text-[#C87A2A]">
                        {{ $this->progress }}%
                    </span>

                </div>

                <div class="w-full h-2 rounded-full bg-[#F1E8DF] overflow-hidden">

                    <div
                        class="h-full bg-[#C87A2A] rounded-full transition-all duration-300"
                        style="width: {{ $this->progress }}%"
                    ></div>

                </div>
            </div>


            {{-- QUESTION --}}
            <div
                wire:key="question-card-{{ $question['id'] }}"
                class="bg-white rounded-3xl border border-[#EADFD3] shadow-sm p-6 md:p-10"
            >

                {{-- TEXTE --}}
                <div class="mb-8">

                    <h2 class="text-xl md:text-2xl font-semibold text-[#4A2D21]">

                        {{ $question['question_text'] ?? '' }}

                        @if($question['is_required'] ?? false)
                            <span class="text-red-500">*</span>
                        @endif

                    </h2>

                    @if(!empty($question['help_text']))
                        <p class="mt-2 text-sm text-[#7A665D]">
                            {{ $question['help_text'] }}
                        </p>
                    @endif

                </div>


                {{-- RADIO --}}
                @if(($question['question_type'] ?? null) === 'radio')

                    <div class="space-y-3">

                        @foreach($question['options'] ?? [] as $option)

                            @php
                                $optionValue =
                                    $option['option_value']
                                    ?? $option['value']
                                    ?? null;

                                $optionLabel =
                                    $option['option_label']
                                    ?? $option['label']
                                    ?? $optionValue
                                    ?? '';
                            @endphp

                            @if($optionValue !== null)

                                <label
                                    wire:key="radio-{{ $question['id'] }}-{{ $optionValue }}"
                                    class="flex items-center gap-3 cursor-pointer rounded-xl border border-transparent p-3 hover:bg-[#FFF7EF]"
                                >

                                    <input
                                        type="radio"
                                        wire:model.live="answers.{{ $question['id'] }}"
                                        value="{{ $optionValue }}"
                                        class="h-4 w-4 text-[#C87A2A] focus:ring-[#C87A2A]"
                                    >

                                    <span class="text-[#4A2D21]">
                                        {{ $optionLabel }}
                                    </span>

                                </label>

                            @endif

                        @endforeach

                    </div>


                    {{-- FREQUENCE --}}
                    @if($this->isTemporalQuestion($question))

                        <div class="mt-6 rounded-2xl bg-[#FFF7EF] border border-[#EADFD3] p-5">

                            <label class="block mb-2 font-medium text-[#4A2D21]">
                                À quelle fréquence cela se produit-il ?
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                wire:model="frequencies.{{ $question['id'] }}"
                                class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 focus:ring-2 focus:ring-[#C87A2A]"
                            >

                                <option value="">
                                    Sélectionnez une fréquence
                                </option>

                                <option value="jamais">
                                    Jamais
                                </option>

                                <option value="rarement">
                                    Rarement
                                </option>

                                <option value="parfois">
                                    Parfois
                                </option>

                                <option value="souvent">
                                    Souvent
                                </option>

                                <option value="quotidiennement">
                                    Quotidiennement
                                </option>

                            </select>

                            @error('frequency')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    @endif

                @endif


                {{-- CHECKBOX --}}
                @if(($question['question_type'] ?? null) === 'checkbox')

                    <div class="space-y-3">

                        @foreach($question['options'] ?? [] as $option)

                            @php
                                $optionValue =
                                    $option['option_value']
                                    ?? $option['value']
                                    ?? null;

                                $optionLabel =
                                    $option['option_label']
                                    ?? $option['label']
                                    ?? $optionValue
                                    ?? '';
                            @endphp

                            @if($optionValue !== null)

                                <label
                                    wire:key="checkbox-{{ $question['id'] }}-{{ $optionValue }}"
                                    class="flex items-center gap-3 cursor-pointer rounded-xl border border-transparent p-3 hover:bg-[#FFF7EF]"
                                >

                                    <input
                                        type="checkbox"
                                        wire:model.live="answers.{{ $question['id'] }}"
                                        value="{{ $optionValue }}"
                                        class="h-4 w-4 rounded text-[#C87A2A] focus:ring-[#C87A2A]"
                                    >

                                    <span class="text-[#4A2D21]">
                                        {{ $optionLabel }}
                                    </span>

                                </label>

                            @endif

                        @endforeach

                    </div>

                @endif


                {{-- TEXT --}}
                @if(($question['question_type'] ?? null) === 'text')

                    <input
                        type="text"
                        wire:model="answers.{{ $question['id'] }}"
                        placeholder="{{ $question['placeholder'] ?? '' }}"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 text-[#4A2D21] focus:ring-2 focus:ring-[#C87A2A]"
                    >

                @endif


                {{-- TEXTAREA --}}
                @if(($question['question_type'] ?? null) === 'textarea')

                    <textarea
                        wire:model="answers.{{ $question['id'] }}"
                        rows="5"
                        placeholder="{{ $question['placeholder'] ?? '' }}"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 text-[#4A2D21] focus:ring-2 focus:ring-[#C87A2A]"
                    ></textarea>

                @endif


                {{-- DATE --}}
                @if(($question['question_type'] ?? null) === 'date')

                    <input
                        type="date"
                        wire:model="answers.{{ $question['id'] }}"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 text-[#4A2D21] focus:ring-2 focus:ring-[#C87A2A]"
                    >

                @endif


                {{-- SELECT --}}
                @if(($question['question_type'] ?? null) === 'select')

                    <select
                        wire:model.live="answers.{{ $question['id'] }}"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 text-[#4A2D21] focus:ring-2 focus:ring-[#C87A2A]"
                    >

                        <option value="">
                            Sélectionnez...
                        </option>

                        @foreach($question['options'] ?? [] as $option)

                            @php
                                $optionValue =
                                    $option['option_value']
                                    ?? $option['value']
                                    ?? null;

                                $optionLabel =
                                    $option['option_label']
                                    ?? $option['label']
                                    ?? $optionValue
                                    ?? '';
                            @endphp

                            @if($optionValue !== null)

                                <option
                                    value="{{ $optionValue }}"
                                >
                                    {{ $optionLabel }}
                                </option>

                            @endif

                        @endforeach

                    </select>

                @endif


                {{-- NUMBER --}}
                @if(($question['question_type'] ?? null) === 'number')

                    <input
                        type="number"
                        wire:model="answers.{{ $question['id'] }}"
                        placeholder="{{ $question['placeholder'] ?? '' }}"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 text-[#4A2D21] focus:ring-2 focus:ring-[#C87A2A]"
                    >

                @endif


                {{-- ERREUR --}}
                @error('answer')

                    <div class="mt-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        {{ $message }}
                    </div>

                @enderror


                {{-- NAVIGATION --}}
                <div class="mt-10 flex items-center justify-between gap-4">

                    <button
                        type="button"
                        wire:click="previousQuestion"
                        wire:loading.attr="disabled"
                        @disabled($currentQuestionIndex === 0)
                        class="inline-flex items-center justify-center rounded-xl border border-[#C87A2A] px-6 py-3 font-medium text-[#C87A2A] hover:bg-[#FFF7EF] disabled:opacity-40 disabled:cursor-not-allowed"
                    >
                        ← Précédent
                    </button>


                    <button
                        type="button"
                        wire:click="nextQuestion"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center rounded-xl bg-[#C87A2A] px-6 py-3 font-medium text-black hover:bg-[#A96220] disabled:opacity-50"
                    >

                        @if(
                            $currentQuestionIndex >= count($questions) - 1
                        )

                            @if($isEditMode)
                                Enregistrer les modifications
                            @else
                                Terminer le questionnaire
                            @endif

                        @else

                            Suivant →

                        @endif

                    </button>

                </div>

            </div>

        @endif

    @endif

</div>