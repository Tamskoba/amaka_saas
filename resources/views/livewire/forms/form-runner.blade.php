<div class="min-h-screen bg-[#F7F2EE] px-4 py-6 sm:px-6 lg:px-8">

    <div class="mx-auto w-full max-w-4xl">

        {{-- ========================================================= --}}
        {{-- EN-TÊTE DU QUESTIONNAIRE                                  --}}
        {{-- ========================================================= --}}

        <div class="mb-8">

            {{-- Petit label --}}
            <div class="mb-3 flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-[#C87A2A]"></span>

                <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#A96220]">
                    Parcours santé
                </span>
            </div>

            {{-- Titre --}}
            <h1 class="text-2xl font-bold leading-tight text-[#4A2D21] sm:text-3xl lg:text-4xl">
                {{ $form->title }}
            </h1>

            {{-- Description --}}
            @if($form->description)
                <p class="mt-3 max-w-3xl text-sm leading-6 text-[#6B554B] sm:text-base">
                    {{ $form->description }}
                </p>
            @endif

        </div>
        <br>

        {{-- ========================================================= --}}
        {{-- QUESTIONNAIRE TERMINÉ                                     --}}
        {{-- ========================================================= --}}

        @if($isCompleted && ! $isEditMode)

            <div class="overflow-hidden rounded-[28px] border border-[#EADFD3] bg-white shadow-[0_18px_50px_rgba(74,45,33,0.08)]">

                {{-- Bandeau supérieur --}}
                <div class="h-2 bg-[#C87A2A]"></div>

                <div class="px-6 py-10 text-center sm:px-10 sm:py-14">

                    {{-- Icône --}}
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#E8F3EA]">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#3F7D55] text-2xl font-bold text-white">
                            ✓
                        </div>
                    </div>

                    <h2 class="mt-6 text-2xl font-bold text-[#4A2D21] sm:text-3xl">
                        Questionnaire terminé
                    </h2>

                    <p class="mx-auto mt-3 max-w-xl text-base leading-7 text-[#6B554B]">
                        Toutes vos réponses ont été enregistrées avec succès.
                        Vous pouvez maintenant consulter ou modifier vos réponses.
                    </p>

                    <div class="mx-auto mt-8 max-w-xl rounded-2xl border border-[#EADFD3] bg-[#FFF7EF] px-5 py-4 text-sm leading-6 text-[#6B554B]">
                        <span class="font-semibold text-[#4A2D21]">
                            Vos réponses sont enregistrées.
                        </span>
                        Vous pouvez revenir à ce questionnaire depuis votre espace personnel.
                    </div>

                    {{-- Actions --}}
                    <div class="mt-9 grid grid-cols-1 gap-3 sm:grid-cols-2">

                        @if(Route::has('forms.responses'))
                            <a
                                href="{{ route('forms.responses', $form->id) }}"
                                class="inline-flex min-h-[50px] items-center justify-center rounded-2xl border-2 border-[#C87A2A] px-5 py-3 text-sm font-bold text-[#A96220] transition hover:bg-[#FFF7EF]"
                            >
                                Consulter mes réponses
                            </a>
                        @endif

                        <a
                            href="{{ route('forms.run', $form->id) }}?edit=1"
                            class="inline-flex min-h-[50px] items-center justify-center rounded-2xl bg-[#C87A2A] px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#A96220] hover:shadow-md"
                        >
                            Modifier mes réponses
                        </a>

                        <a
                            href="{{ route('forms.index') }}"
                            class="inline-flex min-h-[50px] items-center justify-center rounded-2xl border-2 border-[#EADFD3] bg-white px-5 py-3 text-sm font-bold text-[#6B554B] transition hover:border-[#C87A2A] hover:bg-[#FFF7EF] sm:col-span-2"
                        >
                            Retour à mes questionnaires
                        </a>

                    </div>

                </div>

            </div>


        @else

            {{-- ===================================================== --}}
            {{-- AUCUNE QUESTION                                       --}}
            {{-- ===================================================== --}}

            @if(! $question)

                <div class="rounded-[28px] border border-[#EADFD3] bg-white p-8 text-center shadow-sm">
                    <p class="text-[#6B554B]">
                        Aucune question disponible.
                    </p>
                </div>


            @else

                {{-- ================================================= --}}
                {{-- BLOC DE PROGRESSION                                --}}
                {{-- ================================================= --}}

                <div class="mb-6 rounded-2xl border border-[#EADFD3] bg-white px-5 py-4 shadow-sm sm:px-6"
                      style="
                            border: 1px solid #efc0a9;
                        "        
                >

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#A96220]">
                                Votre progression
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#4A2D21]">
                                Question {{ $currentQuestionIndex + 1 }}
                                <span class="font-normal text-[#8A7469]">
                                    sur {{ count($questions) }}
                                </span>
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-[#C87A2A]">
                                {{ $this->progress }}%
                            </span>

                            <span class="text-xs text-[#8A7469]">
                                complété
                            </span>
                        </div>

                    </div>

                    {{-- Barre de progression --}}
                    <div class="mt-4 h-3 w-full overflow-hidden rounded-full bg-[#F1E8DF]">
                        <div
                            class="h-full rounded-full bg-gradient-to-r from-[#A96220] to-[#C87A2A] transition-all duration-500"
                            style="width: {{ $this->progress }}%"
                        ></div>
                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- CARTE PRINCIPALE DE LA QUESTION                   --}}
                {{-- ================================================= --}}

                <div
                    wire:key="question-card-{{ $question['id'] }}"
                    class="overflow-hidden rounded-[28px] border border-[#EADFD3] bg-white shadow-[0_18px_50px_rgba(74,45,33,0.07)]"
                    style="
                        background-color: #F3E9E4;
                        border: 1px solid #efc0a9;
                        border-radius: 10px;
                        padding-bottom: 10px;
                    "
                    >

                    {{-- Bandeau décoratif --}}
                    <div class="h-2 bg-gradient-to-r from-[#C87A2A] via-[#D99755] to-[#EADFD3]"></div>

                    <div class="px-5 py-7 sm:px-8 sm:py-9 lg:px-10">

                        {{-- En-tête de question --}}
                        <div class="mb-8">

                            <div class="mb-4 flex items-center gap-3">

                                <span class="inline-flex h-9 min-w-[36px] items-center justify-center rounded-xl bg-[#F3E9E4] px-3 text-sm font-bold text-[#A96220]">
                                    {{ $currentQuestionIndex + 1 }}
                                </span>

                                <span class="text-xs font-bold uppercase tracking-[0.14em] text-[#8A7469]">
                                    Question
                                </span>

                                @if($question['is_required'] ?? false)
                                    <span class="rounded-full bg-[#FFF0E8] px-2.5 py-1 text-[11px] font-bold text-[#A96220]">
                                        Obligatoire
                                    </span>
                                @else
                                    <span class="rounded-full bg-[#F7F2EE] px-2.5 py-1 text-[11px] font-medium text-[#8A7469]">
                                        Facultative
                                    </span>
                                @endif

                            </div>

                            <h2 class="max-w-3xl text-xl font-bold leading-relaxed text-[#4A2D21] sm:text-2xl">
                                {{ $question['question_text'] ?? '' }}

                                @if($question['is_required'] ?? false)
                                    <span class="ml-1 text-[#C87A2A]" aria-label="obligatoire">*</span>
                                @endif
                            </h2>

                            @if(!empty($question['help_text']))
                                <div class="mt-5 flex gap-3 rounded-2xl border border-[#EADFD3] bg-[#FFF7EF] px-4 py-4">

                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#C87A2A] text-xs font-bold text-white">
                                        i
                                    </div>

                                    <p class="text-sm leading-6 text-[#6B554B]">
                                        {{ $question['help_text'] }}
                                    </p>

                                </div>
                            @endif

                        </div>


                        {{-- ================================================= --}}
                        {{-- RÉPONSES RADIO                                    --}}
                        {{-- ================================================= --}}

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
                                            class="group flex cursor-pointer items-center gap-4 rounded-2xl border border-[#EADFD3] bg-white px-4 py-4 transition hover:border-[#C87A2A] hover:bg-[#FFF7EF] sm:px-5"
                                        >

                                            <input
                                                type="radio"
                                                wire:model.live="answers.{{ $question['id'] }}"
                                                value="{{ $optionValue }}"
                                                class="h-5 w-5 border-[#CDB9AC] text-[#C87A2A] focus:ring-2 focus:ring-[#C87A2A] focus:ring-offset-0"
                                            >

                                            <span class="flex-1 text-sm font-medium leading-6 text-[#4A2D21] sm:text-base">
                                                {{ $optionLabel }}
                                            </span>

                                            <span class="text-[#D8C5B8] transition group-hover:text-[#C87A2A]">
                                                →
                                            </span>

                                        </label>

                                    @endif

                                @endforeach

                            </div>


                            {{-- Fréquence --}}
                            @if($this->isTemporalQuestion($question))

                                <div class="mt-6 rounded-2xl border border-[#EADFD3] bg-[#FFF7EF] p-5">

                                    <div class="mb-3">
                                        <p class="text-sm font-bold text-[#4A2D21]">
                                            À quelle fréquence cela se produit-il ?
                                            <span class="text-[#C87A2A]">*</span>
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-[#8A7469]">
                                            Sélectionnez la fréquence qui correspond le mieux à votre situation.
                                        </p>
                                    </div>

                                    <select
                                        wire:model="frequencies.{{ $question['id'] }}"
                                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3.5 text-sm text-[#4A2D21] outline-none transition focus:border-[#C87A2A] focus:ring-2 focus:ring-[#C87A2A]/20"
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


                        {{-- ================================================= --}}
                        {{-- RÉPONSES CHECKBOX                                 --}}
                        {{-- ================================================= --}}

                        @elseif(($question['question_type'] ?? null) === 'checkbox')

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
                                            class="group flex cursor-pointer items-center gap-4 rounded-2xl border border-[#EADFD3] bg-white px-4 py-4 transition hover:border-[#C87A2A] hover:bg-[#FFF7EF] sm:px-5"
                                        >

                                            <input
                                                type="checkbox"
                                                wire:model.live="answers.{{ $question['id'] }}"
                                                value="{{ $optionValue }}"
                                                class="h-5 w-5 rounded border-[#CDB9AC] text-[#C87A2A] focus:ring-2 focus:ring-[#C87A2A] focus:ring-offset-0"
                                            >

                                            <span class="flex-1 text-sm font-medium leading-6 text-[#4A2D21] sm:text-base">
                                                {{ $optionLabel }}
                                            </span>

                                            <span class="text-[#D8C5B8] transition group-hover:text-[#C87A2A]">
                                                +
                                            </span>

                                        </label>

                                    @endif

                                @endforeach

                            </div>


                        {{-- ================================================= --}}
                        {{-- CHAMP TEXTE                                       --}}
                        {{-- ================================================= --}}

                        @elseif(($question['question_type'] ?? null) === 'text')

                            <div>
                                <label class="mb-2 block text-sm font-bold text-[#4A2D21]">
                                    Votre réponse
                                </label>

                                <input
                                    type="text"
                                    wire:model="answers.{{ $question['id'] }}"
                                    placeholder="{{ $question['placeholder'] ?? 'Saisissez votre réponse...' }}"
                                    class="w-full rounded-2xl border border-[#EADFD3] bg-[#FFFCFA] px-4 py-4 text-sm text-[#4A2D21] outline-none transition placeholder:text-[#B09A8D] focus:border-[#C87A2A] focus:ring-4 focus:ring-[#C87A2A]/10"
                                >
                            </div>


                        {{-- ================================================= --}}
                        {{-- ZONE TEXTE                                        --}}
                        {{-- ================================================= --}}

                        @elseif(($question['question_type'] ?? null) === 'textarea')

                            <div>
                                <label class="mb-2 block text-sm font-bold text-[#4A2D21]">
                                    Votre réponse
                                </label>

                                <textarea
                                    wire:model="answers.{{ $question['id'] }}"
                                    rows="6"
                                    placeholder="{{ $question['placeholder'] ?? 'Écrivez votre réponse ici...' }}"
                                    class="w-full resize-y rounded-2xl border border-[#EADFD3] bg-[#FFFCFA] px-4 py-4 text-sm leading-6 text-[#4A2D21] outline-none transition placeholder:text-[#B09A8D] focus:border-[#C87A2A] focus:ring-4 focus:ring-[#C87A2A]/10"
                                ></textarea>
                            </div>


                        {{-- ================================================= --}}
                        {{-- DATE                                               --}}
                        {{-- ================================================= --}}

                        @elseif(($question['question_type'] ?? null) === 'date')

                            <div>
                                <label class="mb-2 block text-sm font-bold text-[#4A2D21]">
                                    Sélectionnez une date
                                </label>

                                <input
                                    type="date"
                                    wire:model="answers.{{ $question['id'] }}"
                                    class="w-full rounded-2xl border border-[#EADFD3] bg-[#FFFCFA] px-4 py-4 text-sm text-[#4A2D21] outline-none transition focus:border-[#C87A2A] focus:ring-4 focus:ring-[#C87A2A]/10"
                                >
                            </div>


                        {{-- ================================================= --}}
                        {{-- SELECT                                             --}}
                        {{-- ================================================= --}}

                        @elseif(($question['question_type'] ?? null) === 'select')

                            <div>
                                <label class="mb-2 block text-sm font-bold text-[#4A2D21]">
                                    Sélectionnez une réponse
                                </label>

                                <select
                                    wire:model.live="answers.{{ $question['id'] }}"
                                    class="w-full rounded-2xl border border-[#EADFD3] bg-[#FFFCFA] px-4 py-4 text-sm text-[#4A2D21] outline-none transition focus:border-[#C87A2A] focus:ring-4 focus:ring-[#C87A2A]/10"
                                >
                                    <option value="">
                                        Sélectionnez une réponse
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
                                            <option value="{{ $optionValue }}">
                                                {{ $optionLabel }}
                                            </option>
                                        @endif

                                    @endforeach
                                </select>
                            </div>


                        {{-- ================================================= --}}
                        {{-- NOMBRE                                             --}}
                        {{-- ================================================= --}}

                        @elseif(($question['question_type'] ?? null) === 'number')

                            <div>
                                <label class="mb-2 block text-sm font-bold text-[#4A2D21]">
                                    Votre réponse
                                </label>

                                <input
                                    type="number"
                                    wire:model="answers.{{ $question['id'] }}"
                                    placeholder="{{ $question['placeholder'] ?? 'Saisissez un nombre...' }}"
                                    class="w-full rounded-2xl border border-[#EADFD3] bg-[#FFFCFA] px-4 py-4 text-sm text-[#4A2D21] outline-none transition placeholder:text-[#B09A8D] focus:border-[#C87A2A] focus:ring-4 focus:ring-[#C87A2A]/10"
                                >
                            </div>

                        @endif


                        {{-- ================================================= --}}
                        {{-- MESSAGE D'ERREUR                                   --}}
                        {{-- ================================================= --}}

                        @error('answer')
                            <div class="
                                    mt-6 
                                    flex 
                                    items-start 
                                    gap-3 
                                    rounded-2xl 
                                    border
                                  border-red-200 
                                  bg-red-50 
                                    px-4 
                                    py-4 
                                    text-sm 
                                    leading-6 
                                    text-red-700
                                    "
                                style="
                                    color: red;
                                "
                            >
                                <span class="font-bold">!</span>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror


                        {{-- ================================================= --}}
                        {{-- NAVIGATION                                         --}}
                        {{-- ================================================= --}}

                        <div class="mt-10 flex flex-col-reverse gap-3 border-t border-[#F0E5DE] pt-6 sm:flex-row sm:items-center sm:justify-between">

                            {{-- Bouton précédent --}}
                            <button
                                type="button"
                                wire:click="previousQuestion"
                                wire:loading.attr="disabled"
                                @disabled($currentQuestionIndex === 0)
                                class="inline-flex min-h-[50px] w-full items-center justify-center rounded-2xl border-2 border-[#EADFD3] bg-white px-6 py-3 text-sm font-bold text-white transition hover:border-[#000000] hover:bg-[#FFF7EF] disabled:cursor-not-allowed disabled:opacity-40 sm:w-auto"
                                style="background-color: #bb7229;"
                            >
                                <span class="mr-2 text-lg">←</span>
                                Précédent
                            </button>

                            {{-- Bouton suivant / terminer --}}
                            <button
                                type="button"
                                wire:click="nextQuestion"
                                wire:loading.attr="disabled"
                                class="inline-flex min-h-[50px] w-full items-center justify-center rounded-2xl bg-[#bb7229] px-7 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#bb7229] hover:shadow-md disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto"
                                style="background-color: #bb7229;"
                                >

                                @if($currentQuestionIndex >= count($questions) - 1)

                                    @if($isEditMode)
                                        Enregistrer les modifications
                                    @else
                                        Terminer le questionnaire
                                    @endif

                                @else

                                    Suivant
                                    <span class="ml-2 text-lg">→</span>

                                @endif

                            </button>

                        </div>

                    </div>

                </div>

            @endif

        @endif

    </div>

</div>