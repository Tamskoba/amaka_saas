<div class="max-w-5xl mx-auto space-y-8">

    {{-- HEADER --}}
    <div>
        <p class="text-[#C87A2A] italic mb-2">
            Import questionnaire
        </p>

        <h1 class="text-4xl md:text-5xl font-['Playfair_Display'] text-[#4B2E1F]">
            Import JSON
        </h1>

        <p class="text-[#6B4A3A] mt-3">
            Importez un ou plusieurs questionnaires à partir de fichiers JSON.
        </p>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-[32px] p-6 md:p-10 border border-[#F1E4D8]">

        {{-- MESSAGE DE SUCCÈS --}}
        @if (session()->has('success'))
            <div
                role="status"
                class="bg-[#E8F6EE] text-[#1D7A46] p-4 rounded-2xl mb-6"
            >
                {{ session('success') }}
            </div>
        @endif

        {{-- RÉSULTAT D'IMPORT OU IMPORT PARTIEL --}}
        @if (session()->has('import_result'))
            <div
                role="status"
                class="bg-[#F8F1EB] text-[#4B2E1F] border border-[#E8D9CC] p-4 rounded-2xl mb-6"
            >
                <p class="font-semibold mb-1">
                    Résultat de l'importation
                </p>

                <p class="whitespace-normal break-words">
                    {{ session('import_result') }}
                </p>
            </div>
        @endif

        {{-- ERREURS DE VALIDATION --}}
        @if ($errors->any())
            <div
                role="alert"
                class="bg-red-50 text-red-700 border border-red-200 p-4 rounded-2xl mb-6"
            >
                <p class="font-semibold mb-2">
                    Impossible de lancer l'importation.
                </p>

                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULAIRE --}}
        <form
            wire:submit="import"
            class="space-y-8"
        >

            {{-- SÉLECTION DES FICHIERS --}}
            <div>
                <label
                    for="files"
                    class="block mb-3 font-medium text-[#4B2E1F]"
                >
                    Fichiers des questionnaires
                </label>

                <input
                    id="files"
                    type="file"
                    wire:model="files"
                    multiple
                    accept=".json,.txt,application/json,text/plain"
                    wire:loading.attr="disabled"
                    wire:target="import"
                    class="block w-full rounded-2xl border border-[#E8D9CC] bg-white p-3 text-[#4B2E1F] file:mr-4 file:rounded-xl file:border-0 file:bg-[#F8F1EB] file:px-4 file:py-2 file:font-medium file:text-[#4B2E1F] hover:file:bg-[#EADFD3] focus:outline-none focus:ring-2 focus:ring-[#C87A2A]"
                >

                <p class="text-sm text-[#6B4A3A] mt-2">
                    Formats acceptés : JSON et TXT. Vous pouvez sélectionner plusieurs fichiers.
                </p>
                <br>
                @error('files')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

                @error('files.*')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- FICHIERS SÉLECTIONNÉS --}}
            @if (count($files) > 0)
                <div class="rounded-2xl border border-[#E8D9CC] bg-[#F8F1EB] p-4">
                    <p class="font-medium text-[#4B2E1F] mb-2">
                        Fichiers sélectionnés : {{ count($files) }}
                    </p>

                    <ul class="space-y-2">
                        @foreach ($files as $file)
                            <li
                                wire:key="import-file-{{ $loop->index }}"
                                class="flex items-center gap-2 text-sm text-[#6B4A3A]"
                            >
                                <svg
                                    class="w-5 h-5 shrink-0 text-[#C87A2A]"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M7 3.75h7l5 5v11.5a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-15a1 1 0 0 1 1-1Z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M14 3.75v5h5M9 14h6M9 17h6"
                                    />
                                </svg>

                                <span class="break-all">
                                    {{ $file->getClientOriginalName() }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- BOUTON D'IMPORT --}}
            <div>
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="import"
                    class="inline-flex items-center justify-center gap-3 bg-[#4B2E1F] hover:bg-[#3D2418] disabled:opacity-60 disabled:cursor-not-allowed text-white font-medium px-8 py-4 rounded-2xl transition-colors"
                    style="
                        background-color: #BB7229;
                        padding-top: 10px;
                        padding-bottom: 10px;
                    "
                    >
                    {{-- Indicateur de chargement --}}
                    <svg
                        wire:loading
                        wire:target="import"
                        class="animate-spin w-5 h-5"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        />
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"
                        />
                    </svg>

                    <span wire:loading.remove wire:target="import">
                        Importer les questionnaires
                    </span>

                    <span wire:loading wire:target="import">
                        Importation en cours...
                    </span>
                </button>
            </div>

        </form>

        {{-- CHARGEMENT DES FICHIERS --}}
        <div
            wire:loading
            wire:target="files"
            class="bg-[#F8F1EB] text-[#4B2E1F] p-4 rounded-2xl mt-6"
        >
            Chargement des fichiers sélectionnés...
        </div>

    </div>

</div>