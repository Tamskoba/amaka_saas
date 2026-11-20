<div class="min-h-screen bg-[#F7F2EE] p-4 md:p-8">

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- En-tête --}}
        <div>
            <p class="text-sm font-medium uppercase tracking-wide text-[#8A5A44]">
                Parcours santé
            </p>

            <h1 class="mt-2 text-3xl font-semibold text-[#4B2E1F]">
                Synthèse fonctionnelle
            </h1>
        </div>

        {{-- Identité de l'utilisateur --}}
        <div class="rounded-2xl border border-[#EADFD3] bg-white p-6 shadow-sm md:p-6">

            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

                {{-- Identité --}}
                <div>
                    <p class="text-sm text-[#8A5A44]">
                        Dossier de l'utilisateur
                    </p>

                    <h2 class="mt-1 text-2xl font-semibold text-[#4B2E1F]">
                        {{ trim(($selectedUser->first_name ?? '') . ' ' . ($selectedUser->last_name ?? '')) ?: 'Nom non renseigné' }}
                    </h2>

                    <p class="mt-1 text-xs text-[#8A5A44]">
                        Rôle : {{ ucfirst($selectedUser->role) }}
                    </p>
                </div>

                {{-- Sélection de la session --}}
                <div class="w-full md:max-w-sm">

                    <label
                        for="selectedSessionId"
                        class="mb-2 block text-sm font-medium text-[#4B2E1F]"
                    >
                        Session à consulter
                    </label>

                    <select
                        id="selectedSessionId"
                        wire:model.live="selectedSessionId"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 text-sm text-[#4B2E1F] focus:border-[#C87A2A] focus:ring-[#C87A2A]"
                    >
                        <option value="">Choisir une session</option>

                        @foreach ($sessions as $session)
                            <option value="{{ $session->id }}">
                                Session {{ $session->session_number }}
                                — {{ $session->status === 'active' ? 'Active' : 'Terminée' }}

                                @if ($session->status === 'active')
                                    (session active)
                                @endif
                            </option>
                        @endforeach

                    </select>

                </div>

            </div>

        </div>

        {{-- Message de confirmation --}}
        @if (session()->has('success'))

            <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                {{ session('success') }}
            </div>

        @endif

        {{-- Vérification de la session --}}
        @if (!$selectedSessionId)

            <div class="rounded-2xl border border-[#EADFD3] bg-white p-6 text-center">

                <h2 class="font-semibold text-[#4B2E1F]">
                    Aucune session disponible
                </h2>

                <p class="mt-2 text-sm text-[#6B4A3A]">
                    Cet utilisateur ne possède aucune session à consulter.
                </p>

            </div>

        @else

            {{-- Actualisation de la synthèse --}}
            @if ($canGenerate)

                <div class="flex justify-center">

                    <button
                        type="button"
                        wire:click="generate"
                        wire:loading.attr="disabled"
                        wire:target="generate"
                        class="rounded-xl bg-[#C87A2A] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#A96320] disabled:opacity-50"
                        style="
                            background-color: #BB7229;
                            padding-top: 10px;
                            padding-bottom: 10px;
                        "
                    >
                        <span wire:loading.remove wire:target="generate">
                            Générer / actualiser la synthèse
                        </span>

                        <span wire:loading wire:target="generate">
                            Actualisation en cours...
                        </span>

                    </button>

                </div>

            @endif

            {{-- Modes de présentation --}}
            <div class="rounded-2xl border border-[#EADFD3] bg-white p-6 shadow-sm md:p-6">

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                    <div>
                        <h2 class="text-lg font-semibold text-[#4B2E1F]">
                            Réponses de la session
                        </h2>

                        <p class="mt-1 text-sm text-[#6B4A3A]">
                            Choisis le mode de présentation.
                        </p>
                    </div>

                    {{-- Boutons de sélection du mode --}}
                    <div class="flex flex-wrap gap-2">

                        <button
                            type="button"
                            wire:click="$set('presentationMode', 'questionnaire')"
                            @class([
                                'rounded-xl border px-4 py-2 text-sm font-medium transition',
                                'border-[#DCCABC] bg-[#F7F2EE] text-[#6B4A3A]' => $presentationMode === 'questionnaire',
                                'border-[#EADFD3] bg-white text-[#4B2E1F] hover:bg-[#F7F2EE]' => $presentationMode !== 'questionnaire',
                            ])
                        >
                            Par questionnaire
                        </button>

                        <button
                            type="button"
                            wire:click="$set('presentationMode', 'theme')"
                            @class([
                                'rounded-xl border px-4 py-2 text-sm font-medium transition',
                                'border-[#DCCABC] bg-[#F7F2EE] text-[#6B4A3A]' => $presentationMode === 'theme',
                                'border-[#EADFD3] bg-white text-[#4B2E1F] hover:bg-[#F7F2EE]' => $presentationMode !== 'theme',
                            ])
                        >
                            Par grands thèmes
                        </button>

                        <button
                            type="button"
                            wire:click="$set('presentationMode', 'detailed')"
                            @class([
                                'rounded-xl border px-4 py-2 text-sm font-medium transition',
                                'border-[#DCCABC] bg-[#F7F2EE] text-[#6B4A3A]' => $presentationMode === 'detailed',
                                'border-[#EADFD3] bg-white text-[#4B2E1F] hover:bg-[#F7F2EE]' => $presentationMode !== 'detailed',
                            ])
                        >
                            Détaillé
                        </button>

                    </div>

                </div>

                {{-- MODE 1 : PAR QUESTIONNAIRE --}}
                @if ($presentationMode === 'questionnaire')

                    <div class="mt-6 space-y-5">

                        @forelse ($synthesisData['questionnaires'] ?? [] as $questionnaire)

                            <section class="overflow-hidden rounded-2xl border border-[#EADFD3]">

                                {{-- En-tête du questionnaire --}}
                                <div class="bg-[#F7F2EE] p-5">

                                    <h3 class="text-lg font-semibold text-[#4B2E1F]">
                                        {{ $questionnaire['title'] }}
                                    </h3>

                                    <div class="mt-3 flex flex-wrap gap-4 text-sm text-[#6B4A3A]">

                                        <span>
                                            Statut :
                                            <strong>
                                                {{ $questionnaire['status'] }}
                                            </strong>
                                        </span>

                                        <span>
                                            Progression :
                                            <strong>
                                                {{ $questionnaire['progress'] }} %
                                            </strong>
                                        </span>

                                    </div>

                                    {{-- Barre de progression --}}
                                    <div class="mt-3 h-2 overflow-hidden rounded-full bg-[#EADFD3]">

                                        <div
                                            class="h-full rounded-full bg-[#C87A2A]"
                                            style="width: {{ min(100, max(0, $questionnaire['progress'])) }}%"
                                        ></div>

                                    </div>

                                </div>

                                {{-- Sections et réponses --}}
                                <div class="space-y-5 p-5">

                                    @forelse ($questionnaire['sections'] as $sectionTitle => $questions)

                                        <div>

                                            <h4 class="border-b border-[#EADFD3] pb-2 font-semibold text-[#6B4A3A]">
                                                {{ $sectionTitle }}
                                            </h4>

                                            <div class="mt-3 space-y-3">

                                                @foreach ($questions as $item)

                                                    <article class="rounded-xl bg-[#FDFBF9] p-4">

                                                        <p class="text-sm font-medium text-[#4B2E1F]">
                                                            {{ $item['question'] }}
                                                        </p>

                                                        <p class="mt-2 whitespace-pre-line text-sm text-[#6B4A3A]">
                                                            <strong>Réponse :</strong>
                                                            {{ $item['answer'] }}
                                                        </p>

                                                    </article>

                                                @endforeach

                                            </div>

                                        </div>

                                    @empty

                                        <p class="text-sm italic text-[#8A5A44]">
                                            Aucune réponse enregistrée dans ce questionnaire.
                                        </p>

                                    @endforelse

                                </div>

                            </section>

                        @empty

                            <p class="mt-6 rounded-xl bg-[#F7F2EE] p-5 text-sm text-[#6B4A3A]">
                                Aucune réponse enregistrée pour cette session.
                            </p>

                        @endforelse

                    </div>

                {{-- MODE 2 : PAR GRANDS THÈMES --}}
                @elseif ($presentationMode === 'theme')

                    <div class="mt-6 space-y-5">

                        @forelse ($synthesisData['themes'] ?? [] as $themeName => $items)

                            <section class="overflow-hidden rounded-2xl border border-[#EADFD3]">

                                {{-- En-tête du thème --}}
                                <div class="bg-[#4B2E1F] px-5 py-4">

                                    <h3 class="text-lg font-semibold text-white">
                                        {{ $themeName }}
                                    </h3>

                                </div>

                                {{-- Réponses du thème --}}
                                <div class="space-y-4 p-5">

                                    @foreach ($items as $item)

                                        <article class="rounded-xl border border-[#EADFD3] bg-[#FDFBF9] p-4">

                                            <p class="font-medium text-[#4B2E1F]">
                                                {{ $item['question'] }}
                                            </p>

                                            <p class="mt-2 whitespace-pre-line text-sm text-[#6B4A3A]">
                                                <strong>Réponse :</strong>
                                                {{ $item['answer'] }}
                                            </p>

                                            {{-- Traçabilité de la réponse --}}
                                            <div class="mt-4 rounded-lg bg-[#F7F2EE] p-3 text-xs text-[#6B4A3A]">

                                                <p>
                                                    <strong>Questionnaire d’origine :</strong>
                                                    {{ $item['questionnaire'] }}
                                                </p>

                                                <p class="mt-1">
                                                    <strong>Section d’origine :</strong>
                                                    {{ $item['section'] }}
                                                </p>

                                                <p class="mt-1">
                                                    <strong>Statut :</strong>
                                                    {{ $item['status'] }}
                                                </p>

                                            </div>

                                        </article>

                                    @endforeach

                                </div>

                            </section>

                        @empty

                            <p class="mt-6 rounded-xl bg-[#F7F2EE] p-5 text-sm text-[#6B4A3A]">
                                Aucune réponse enregistrée pour cette session.
                            </p>

                        @endforelse

                    </div>

                {{-- MODE 3 : SYNTHÈSE FONCTIONNELLE DÉTAILLÉE --}}
                @else

                    <div class="mt-6 space-y-5">

                    {{-- Options d'affichage et export PDF --}}
                    <div class="rounded-xl border border-[#EADFD3] bg-white p-5">

                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                            <div class="space-y-3">

                                <div>
                                    <p class="text-sm font-semibold text-[#4B2E1F]">
                                        Options d'affichage
                                    </p>

                                    <p class="mt-1 text-xs text-[#8A5A44]">
                                        Personnaliser les informations affichées sous chaque réponse.
                                    </p>
                                </div>

                                <label class="inline-flex cursor-pointer items-center gap-3">

                                    <input
                                        type="checkbox"
                                        wire:model.live="showDetailedMetadata"
                                        class="h-5 w-5 rounded border-[#C87A2A] text-[#4B2E1F] focus:ring-[#C87A2A]"
                                    >

                                    <span class="text-sm font-medium text-[#4B2E1F]">
                                        Afficher les informations de traçabilité
                                    </span>

                                </label>

                            </div>

                            {{-- Export PDF --}}
                            <div class="shrink-0">

                                <button
                                    type="button"
                                    wire:click="exportDetailedPdf"
                                    wire:loading.attr="disabled"
                                    wire:target="exportDetailedPdf"
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#4B2E1F] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#6B4A3A] disabled:cursor-not-allowed disabled:opacity-50"
                                    style="
                                        background-color: #BB7229;
                                        padding-top: 10px;
                                        padding-bottom: 10px;
                                    "
                                >
                                    <span wire:loading.remove wire:target="exportDetailedPdf">
                                        Exporter en PDF
                                    </span>

                                    <span wire:loading wire:target="exportDetailedPdf">
                                        Préparation du PDF...
                                    </span>
                                </button>

                            </div>

                        </div>

                    </div>

                        {{-- En-tête --}}
                        <div class="rounded-2xl bg-[#4B2E1F] p-6 text-white">

                            <p class="text-sm font-medium uppercase tracking-wide text-[#EADFD3]">
                                Parcours santé
                            </p>

                            <h3 class="mt-2 text-2xl font-semibold">
                                {{ $detailedSynthesis['title'] ?? 'Synthèse fonctionnelle détaillée' }}
                            </h3>

                            <p class="mt-2 text-sm text-[#F7F2EE]">
                                Regroupement structuré des informations déclarées dans les questionnaires.
                            </p>

                        </div>

                        {{-- Les 20 rubriques --}}
                        @forelse ($detailedSynthesis['rubrics'] ?? [] as $rubric)

                            <section class="overflow-hidden rounded-2xl border border-[#EADFD3] bg-white">

                                {{-- Titre de la rubrique --}}
                                <div class="border-b border-[#EADFD3] bg-[#F7F2EE] p-5">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-[#8A5A44]">
                                        Rubrique {{ $rubric['number'] }}
                                    </p>

                                    <h4 class="mt-1 text-lg font-semibold text-[#4B2E1F]">
                                        {{ $rubric['title'] }}
                                    </h4>

                                </div>

                                <div class="space-y-4 p-5">

                                    @if (!empty($rubric['has_data']))

                                        @foreach ($rubric['items'] as $item)

                                            <article class="rounded-xl border border-[#EADFD3] bg-[#FDFBF9] p-4">

                                                {{-- Question --}}
                                                <p class="font-medium text-[#4B2E1F]">
                                                    {{ $item['question'] }}
                                                </p>

                                                {{-- Réponse --}}
                                                <div class="mt-3 rounded-lg bg-white p-3">

                                                    @if ($showDetailedMetadata)
                                                        <p class="text-xs font-semibold uppercase tracking-wide text-[#8A5A44]">
                                                            Réponse déclarée
                                                        </p>
                                                    @endif

                                                    <p class="mt-1 whitespace-pre-line text-sm text-[#4B2E1F]">
                                                        {{ $item['answer'] }}
                                                    </p>

                                                </div>

                                                {{-- Traçabilité --}}
                                                @if ($showDetailedMetadata)
                                                    <div class="mt-3 space-y-1 rounded-lg bg-[#F7F2EE] p-3 text-xs text-[#6B4A3A]">
                                                        <p><strong>Questionnaire :</strong> {{ $item['questionnaire'] }}</p>
                                                        <p><strong>Section d'origine :</strong> {{ $item['section'] }}</p>
                                                        <p><strong>Clé technique :</strong> {{ $item['question_key'] }}</p>
                                                        <p>
                                                            <strong>Statut :</strong> {{ $item['status'] }}
                                                            — Progression : {{ $item['progress'] }} %
                                                        </p>
                                                    </div>
                                                @endif

                                            </article>

                                        @endforeach

                                    @else

                                        <div class="rounded-xl border border-dashed border-[#DCCABC] bg-[#FDFBF9] p-5">

                                            <p class="text-sm italic text-[#8A5A44]">
                                                {{ $rubric['empty_message'] ?? 'Aucune information disponible dans les questionnaires' }}
                                            </p>

                                        </div>

                                    @endif

                                </div>

                            </section>

                        @empty

                            <div class="rounded-xl bg-[#F7F2EE] p-5 text-sm text-[#6B4A3A]">
                                Aucune rubrique disponible pour cette synthèse.
                            </div>

                        @endforelse

                    </div>

                @endif    


                {{-- Mention de prudence --}}
                <p class="mt-6 border-t border-[#EADFD3] pt-4 text-xs leading-5 text-[#8A5A44]">

                    Cette synthèse restitue les réponses déclarées.
                    Le regroupement par thème repose actuellement sur le champ
                    « scoring_group » des questions.
                    Il ne constitue ni une interprétation clinique automatique
                    ni un diagnostic.

                </p>

            </div>

        @endif

    </div>

</div>