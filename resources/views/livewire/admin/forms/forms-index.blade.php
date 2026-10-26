<div class="space-y-8">

    {{-- NOTIFICATIONS D'IMPORT ET D'ACTIONS --}}
    @if (session()->has('success'))
        <div
            role="status"
            class="rounded-2xl border border-green-200 bg-green-50 px-6 py-4 text-green-800"
        >
            <p class="font-semibold">Opération réussie</p>
            <p class="mt-1">{{ session('success') }}</p>
        </div>
    @endif

    @if (session()->has('import_result'))
        <div
            role="alert"
            class="rounded-2xl border border-[#EADFD3] bg-[#F7F2EE] px-6 py-4 text-[#4B2E1F]"
        >
            <p class="font-semibold">Résultat de l'importation</p>
            <p class="mt-1 break-words">{{ session('import_result') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div
            role="alert"
            class="rounded-2xl border border-red-200 bg-red-50 px-6 py-4 text-red-800"
        >
            <p class="font-semibold">Une erreur est survenue</p>
            <p class="mt-1">{{ session('error') }}</p>
        </div>
    @endif

    {{-- ERREURS DE VALIDATION --}}
    @if ($errors->any())
        <div
            role="alert"
            class="rounded-2xl border border-red-200 bg-red-50 px-6 py-4 text-red-800"
        >
            <p class="font-semibold">Vérifie les informations saisies</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <p class="mb-2 italic text-[#C87A2A]">
                Administration
            </p>

            <h1 class="font-['Playfair_Display'] text-4xl text-[#4B2E1F] md:text-5xl">
                Questionnaires
            </h1>
        </div>

        {{-- ACTIONS --}}
        <div class="flex flex-wrap items-center gap-3">

            <a
                href="{{ route('admin.forms.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-[#4B2E1F] px-5 py-3 font-semibold text-white transition hover:bg-[#3D2418]"
                style="
                    background-color: #BB7229;
                    padding-top: 10px;
                    padding-bottom: 10px;
                "
                >
                Nouveau questionnaire
            </a>

            <a
                href="{{ route('admin.forms.import') }}"
                class="inline-flex items-center justify-center rounded-2xl border border-[#EADFD3] bg-white px-5 py-3 font-semibold text-white transition hover:bg-[#F8F1EB]"
                style="
                    background-color: #BB7229;
                    padding-top: 10px;
                    padding-bottom: 10px;
                "                                
                >
                Import JSON
            </a>

            <a
                href="{{ route('admin.trash.index') }}"
                class="inline-flex items-center justify-center rounded-2xl border border-[#EADFD3] px-5 py-3 font-semibold text-white transition hover:bg-[#F8F1EB]"
                style="
                    background-color: #BB7229;
                    padding-top: 10px;
                    padding-bottom: 10px;
                "            
                >
                Corbeille
            </a>

        </div>
    </div>

    {{-- TABLE --}}
    <div
        class="overflow-hidden rounded-[32px] border border-[#EADFD3] bg-white/70 p-4 shadow-[0_10px_40px_rgba(74,45,33,0.08)] backdrop-blur-sm md:p-6"
    >
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] overflow-hidden rounded-3xl bg-white">

                <thead class="bg-[#F7F2EE] text-[#4B2E1F]">
                    <tr>
                        <th class="p-6 text-left">Titre</th>
                        <th class="p-6 text-left">Statut</th>
                        <th class="p-6 text-left">Date</th>
                        <th class="p-6 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($forms as $form)
                        <tr class="border-t border-[#F1E4D8]">

                            {{-- TITRE ET DESCRIPTION --}}
                            <td class="p-6">

                                <div
                                    x-data="{
                                        editing: false,
                                        title: @js($form->title)
                                    }"
                                >
                                    {{-- AFFICHAGE DU TITRE --}}
                                    <div
                                        x-show="!editing"
                                        @click="editing = true"
                                        class="cursor-pointer font-semibold text-[#4B2E1F] transition hover:text-[#C87A2A]"
                                    >
                                        {{ $form->title }}
                                    </div>

                                    {{-- MODIFICATION DU TITRE --}}
                                    <input
                                        x-cloak
                                        x-show="editing"
                                        x-model="title"
                                        x-ref="input"
                                        @click.outside="editing = false"
                                        @keydown.escape.window="editing = false"
                                        @keydown.enter.prevent="
                                            $wire.updateTitle({{ $form->id }}, title);
                                            editing = false;
                                        "
                                        x-init="$watch('editing', value => {
                                            if (value) {
                                                $nextTick(() => $refs.input.focus())
                                            }
                                        })"
                                        type="text"
                                        aria-label="Modifier le titre"
                                        class="w-full rounded-xl border border-[#E8D9CC] focus:border-[#C87A2A] focus:ring-[#C87A2A]"
                                    >
                                </div>

                                {{-- DESCRIPTION --}}
                                <div
                                    class="mt-2 text-sm text-[#8A5A44]"
                                    x-data="{
                                        editingDescription: false,
                                        description: @js($form->description ?? '')
                                    }"
                                >
                                    {{-- AFFICHAGE --}}
                                    <div
                                        x-cloak
                                        x-show="!editingDescription"
                                        @click="editingDescription = true"
                                        class="cursor-pointer whitespace-pre-line transition hover:text-[#C87A2A]"
                                    >
                                        <template x-if="description">
                                            <span x-text="description"></span>
                                        </template>

                                        <template x-if="!description">
                                            <span class="italic opacity-60">
                                                Ajouter une description...
                                            </span>
                                        </template>
                                    </div>

                                    {{-- MODIFICATION --}}
                                    <textarea
                                        x-cloak
                                        x-show="editingDescription"
                                        x-model="description"
                                        x-ref="textarea"
                                        rows="3"
                                        @click.outside="editingDescription = false"
                                        @keydown.escape.window="editingDescription = false"
                                        @keydown.ctrl.enter.prevent="
                                            $wire.updateDescription({{ $form->id }}, description);
                                            editingDescription = false;
                                        "
                                        x-init="$watch('editingDescription', value => {
                                            if (value) {
                                                $nextTick(() => {
                                                    $refs.textarea.focus();
                                                    $refs.textarea.style.height = 'auto';
                                                    $refs.textarea.style.height =
                                                        $refs.textarea.scrollHeight + 'px';
                                                })
                                            }
                                        })"
                                        @input="
                                            $el.style.height = 'auto';
                                            $el.style.height = $el.scrollHeight + 'px';
                                        "
                                        aria-label="Modifier la description"
                                        class="w-full resize-none overflow-hidden rounded-2xl border border-[#E8D9CC] text-sm focus:border-[#C87A2A] focus:ring-[#C87A2A]"
                                    ></textarea>

                                    <p
                                        x-cloak
                                        x-show="editingDescription"
                                        class="mt-1 text-xs opacity-70"
                                    >
                                        Ctrl + Entrée pour enregistrer
                                    </p>
                                </div>

                            </td>

                            {{-- STATUT --}}
                            <td class="p-6">
                                <button
                                    type="button"
                                    wire:click="toggleStatus({{ $form->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="toggleStatus({{ $form->id }})"
                                    class="inline-flex items-center gap-2 rounded-full border px-4 py-2 transition disabled:opacity-50"
                                    @class([
                                        'bg-green-50 text-green-700 border-green-200' => $form->is_active,
                                        'bg-gray-100 text-gray-600 border-gray-200' => ! $form->is_active,
                                    ])
                                >
                                    <span
                                        @class([
                                            'h-2 w-2 rounded-full bg-green-500' => $form->is_active,
                                            'h-2 w-2 rounded-full bg-gray-400' => ! $form->is_active,
                                        ])
                                    ></span>

                                    {{ $form->is_active ? 'Actif' : 'Inactif' }}
                                </button>
                            </td>

                            {{-- DATE --}}
                            <td class="p-6 text-sm text-[#8A5A44]">
                                {{ $form->created_at?->format('d/m/Y') ?? '—' }}
                            </td>

                            {{-- ACTIONS --}}
                            <td class="p-6">
                                <div class="flex items-center gap-3">

                                    <a
                                        href="{{ route('admin.forms.edit', $form->id) }}"
                                        class="inline-flex items-center justify-center rounded-xl bg-[#F6EEE7] px-4 py-2 text-[#4B2E1F] transition hover:bg-[#EFE2D5]"
                                    >
                                        Modifier
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="deleteForm({{ $form->id }})"
                                        wire:confirm="Supprimer ce questionnaire ?"
                                        class="inline-flex items-center justify-center rounded-xl bg-red-100 px-3 py-2 text-red-700 transition hover:bg-red-200"
                                    >
                                        Supprimer
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="4"
                                class="px-6 py-12 text-center text-[#8A5A44]"
                            >
                                <p class="font-semibold text-[#4B2E1F]">
                                    Aucun questionnaire
                                </p>

                                <p class="mt-2">
                                    Crée un questionnaire ou utilise l'import JSON.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="p-4 md:p-6">
            {{ $forms->links() }}
        </div>
    </div>

</div>