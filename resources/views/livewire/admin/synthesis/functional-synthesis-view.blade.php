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
        <div class="rounded-2xl border border-[#EADFD3] bg-white p-5 shadow-sm md:p-6">

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
            <div class="rounded-2xl border border-[#EADFD3] bg-white p-5 shadow-sm md:p-6">

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
                                'border-[#4B2E1F] bg-[#4B2E1F] text-white' => $presentationMode === 'questionnaire',
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
                                'border-[#4B2E1F] bg-[#4B2E1F] text-white' => $presentationMode === 'theme',
                                'border-[#EADFD3] bg-white text-[#4B2E1F] hover:bg-[#F7F2EE]' => $presentationMode !== 'theme',
                            ])
                        >
                            Par grands thèmes
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
                @else

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