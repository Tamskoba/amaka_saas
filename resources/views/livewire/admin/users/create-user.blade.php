<div class="max-w-5xl mx-auto space-y-8">

    {{-- ================================================================ --}}
    {{-- TITRE --}}
    {{-- ================================================================ --}}

    <div>

        <h1 class="text-2xl font-semibold text-[#4B2E1F]">
            Nouvel utilisateur
        </h1>

        <p class="mt-1 text-sm text-[#6B4A3A]">
            Créez le compte, assignez les questionnaires puis choisissez
            le mode de notification.
        </p>

    </div>


    {{-- ================================================================ --}}
    {{-- INDICATEUR DES 3 ÉTAPES --}}
    {{-- ================================================================ --}}
    <br>
    <div class="rounded-2xl border border-[#EADFD3] p-5">

        <div class="flex items-center justify-between">

            {{-- ÉTAPE 1 --}}
            <div class="flex items-center gap-3">

                <div
                    class="
                        w-10 h-10
                        rounded-full
                        flex items-center justify-center
                        font-semibold
                        {{ $step >= 1
                            ? 'bg-[#C87A2A] color : #BB7229;'
                            : 'bg-[#F7F2EE] text-[#6B4A3A]' }}
                    "
                >
                    1 - Compte
                </div>

                <div class="hidden sm:block">

                    <p class="text-sm font-semibold text-[#4B2E1F]">
                        1 - Compte
                    </p>

                    <p class="text-xs text-[#6B4A3A]">
                        Informations utilisateur
                    </p>

                </div>

            </div>


            {{-- LIGNE --}}
            <div class="flex-1 h-px bg-[#EADFD3] mx-4"></div>


            {{-- ÉTAPE 2 --}}
            <div class="flex items-center gap-3">

                <div
                    class="
                        w-10 h-10
                        rounded-full
                        flex items-center justify-center
                        font-semibold
                        {{ $step >= 2
                            ? 'bg-[#C87A2A] color : #BB7229;'
                            : 'bg-[#F7F2EE] text-[#6B4A3A]' }}
                    "
                >
                    2 - Assignation
                </div>

                <div class="hidden sm:block">

                    <p class="text-sm font-semibold text-[#4B2E1F]">
                        Questionnaires
                    </p>

                    <p class="text-xs text-[#6B4A3A]">
                        Assignation
                    </p>

                </div>

            </div>


            {{-- LIGNE --}}
            <div class="flex-1 h-px bg-[#EADFD3] mx-4"></div>


            {{-- ÉTAPE 3 --}}
            <div class="flex items-center gap-3">

                <div
                    class="
                        w-10 h-10
                        rounded-full
                        flex items-center justify-center
                        font-semibold
                        {{ $step >= 3
                            ? 'bg-[#C87A2A] color : #BB7229;'
                            : 'bg-[#F7F2EE] text-[#6B4A3A]' }}
                    "
                >
                    3 - Notification
                </div>

                <div class="hidden sm:block">

                    <p class="text-sm font-semibold text-[#4B2E1F]">
                        Notification
                    </p>

                    <p class="text-xs text-[#6B4A3A]">
                        Envoi des accès
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================================ --}}
    {{-- ÉTAPE 1 --}}
    {{-- ================================================================ --}}

    @if($step === 1)
        <br>
        <div class="border-[#EADFD3] rounded-[28px] shadow-sm p-8">

            <div class="mb-8">

                <h2 class="text-xl font-semibold text-[#4B2E1F]">
                    1 - Informations du compte
                </h2>

                <p class="text-sm text-[#6B4A3A] mt-1">
                    Renseignez les informations du nouvel utilisateur.
                </p>

            </div>

            <br>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- PRÉNOM --}}
                <div>

                    <label class="block text-sm font-medium text-[#4B2E1F] mb-2">
                        Prénom *
                    </label>

                    <input
                        type="text"
                        wire:model="first_name"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 focus:ring-2 focus:ring-[#C87A2A] focus:border-[#C87A2A]"
                    >

                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- NOM --}}
                <div>

                    <label class="block text-sm font-medium text-[#4B2E1F] mb-2">
                        Nom *
                    </label>

                    <input
                        type="text"
                        wire:model="last_name"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 focus:ring-2 focus:ring-[#C87A2A] focus:border-[#C87A2A]"
                    >

                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- EMAIL --}}
                <div>

                    <label class="block text-sm font-medium text-[#4B2E1F] mb-2">
                        Email *
                    </label>

                    <input
                        type="email"
                        wire:model="email"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 focus:ring-2 focus:ring-[#C87A2A] focus:border-[#C87A2A]"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- TÉLÉPHONE --}}
                <div>

                    <label class="block text-sm font-medium text-[#4B2E1F] mb-2">
                        Téléphone
                    </label>

                    <input
                        type="text"
                        wire:model="phone"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 focus:ring-2 focus:ring-[#C87A2A] focus:border-[#C87A2A]"
                    >

                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- VILLE --}}
                <div>

                    <label class="block text-sm font-medium text-[#4B2E1F] mb-2">
                        Ville
                    </label>

                    <input
                        type="text"
                        wire:model="city"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 focus:ring-2 focus:ring-[#C87A2A] focus:border-[#C87A2A]"
                    >

                </div>


                {{-- PAYS --}}
                <div>

                    <label class="block text-sm font-medium text-[#4B2E1F] mb-2">
                        Pays
                    </label>

                    <input
                        type="text"
                        wire:model="country"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 focus:ring-2 focus:ring-[#C87A2A] focus:border-[#C87A2A]"
                    >

                </div>


                {{-- RÔLE --}}
                <div>

                    <label class="block text-sm font-medium text-[#4B2E1F] mb-2">
                        Rôle *
                    </label>

                    <select
                        wire:model="role"
                        class="w-full rounded-xl border border-[#EADFD3] bg-white px-4 py-3 focus:ring-2 focus:ring-[#C87A2A] focus:border-[#C87A2A]"
                    >

                        <option value="client">
                            Client
                        </option>

                        <option value="micronutritionist">
                            Micronutritionniste
                        </option>

                        <option value="admin">
                            Administrateur
                        </option>

                    </select>

                    @error('role')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- STATUT --}}
                <div>

                    <label class="block text-sm font-medium text-[#4B2E1F] mb-2">
                        Statut du compte
                    </label>

                    <label class="flex items-center gap-3 mt-3">

                        <input
                            type="checkbox"
                            wire:model="is_active"
                            class="rounded border-[#EADFD3] text-[#C87A2A] focus:ring-[#C87A2A]"
                        >

                        <span class="text-sm text-[#6B4A3A]">
                            Compte actif
                        </span>

                    </label>

                </div>

            </div>


            {{-- ACTIONS --}}
            <div class="flex justify-between mt-10 pt-6 border-t border-[#EADFD3]">

                <button
                    type="button"
                    wire:click="cancel"
                    class="px-5 py-3 rounded-xl border border-[#EADFD3] font-medium text-[#6B4A3A] hover:bg-[#F7F2EE]"
                    style="
                        background-color: #ff0000;
                        padding-top: 10px;
                        padding-bottom: 10px;
                        color : #ffffff;
                    "
                    >
                    Annuler
                </button>

                <button
                    type="button"
                    wire:click="createUser"
                    wire:loading.attr="disabled"
                    class="px-6 py-3 rounded-xl bg-[#C87A2A] text-white font-medium hover:bg-[#B36C22]"
                    style="
                        background-color: #BB7229;
                        padding-top: 10px;
                        padding-bottom: 10px;
                    "
                >
                     {{ $createdUserId ? 'Continuer' : 'Créer et continuer' }}
                </button>

            </div>

        </div>

    @endif


    {{-- ================================================================ --}}
    {{-- ÉTAPE 2 --}}
    {{-- ================================================================ --}}

    @if($step === 2)

        <div class="border border-[#EADFD3] rounded-[28px] shadow-sm p-8">

            <div class="mb-8">

                <h2 class="text-xl font-semibold text-[#4B2E1F]">
                    Assigner les questionnaires
                </h2>

                <p class="text-sm text-[#6B4A3A] mt-1">
                    Sélectionnez les questionnaires auxquels cet utilisateur
                    aura accès.
                </p>

            </div>


            {{-- UTILISATEUR --}}
            <div class="mb-6 p-4 rounded-2xl bg-[#F7F2EE]">

                <p class="text-sm text-[#6B4A3A]">
                    Utilisateur
                </p>

                <p class="font-semibold text-[#4B2E1F]">
                    {{ $first_name }} {{ $last_name }}
                </p>

                <p class="text-sm text-[#6B4A3A]">
                    {{ $email }}
                </p>

            </div>


            {{-- QUESTIONNAIRES --}}
            <div class="space-y-3">

                @forelse($this->forms as $form)

                    <label
                        class="
                            flex
                            items-start
                            gap-4
                            p-5
                            rounded-2xl
                            border
                            border-[#EADFD3]
                            cursor-pointer
                            hover:bg-[#F7F2EE]
                            transition
                        "
                    >

                        <input
                            type="checkbox"
                            value="{{ $form->id }}"
                            wire:model="selectedForms"
                            class="mt-1 rounded border-[#EADFD3] text-[#C87A2A] focus:ring-[#C87A2A]"
                        >

                        <div>

                            <p class="font-semibold text-[#4B2E1F]">
                                {{ $form->title }}
                            </p>

                            @if($form->description)

                                <p class="mt-1 text-sm text-[#6B4A3A]">
                                    {{ $form->description }}
                                </p>

                            @endif

                        </div>

                    </label>
                    <br>
                @empty

                    <div class="p-6 text-center bg-[#F7F2EE] rounded-2xl">

                        <p class="text-[#6B4A3A]">
                            Aucun questionnaire actif disponible.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- ACTIONS --}}
            <div class="flex justify-between mt-10 pt-6 border-t border-[#EADFD3]">

                <button
                    type="button"
                    wire:click="previousStep"
                    class="px-5 py-3 rounded-xl border border-[#EADFD3] text-white font-medium hover:bg-[#F7F2EE]"
                    style="
                        background-color: #BB7229;
                        padding-top: 10px;
                        padding-bottom: 10px;
                    "
                    >
                    Retour
                </button>

                <button
                    type="button"
                    wire:click="assignForms"
                    wire:loading.attr="disabled"
                    class="px-6 py-3 rounded-xl bg-[#C87A2A] text-white font-medium hover:bg-[#B36C22]"
                    style="
                        background-color: #BB7229;
                        padding-top: 10px;
                        padding-bottom: 10px;
                    "
                    >
                    Continuer
                </button>

            </div>

        </div>

    @endif


    {{-- ================================================================ --}}
    {{-- ÉTAPE 3 --}}
    {{-- ================================================================ --}}

    @if($step === 3)
        <br>
        <div class="border border-[#EADFD3] rounded-[28px] shadow-sm p-8">

            <div class="mb-8">

                <h2 class="text-xl font-semibold text-[#4B2E1F]">
                    Notification de l'utilisateur
                </h2>

                <p class="text-sm text-[#6B4A3A] mt-1">
                    Choisissez quand transmettre les identifiants de connexion.
                </p>

            </div>


            {{-- RÉCAPITULATIF --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                {{-- UTILISATEUR --}}
                <div class="p-5 rounded-2xl bg-[#F7F2EE]">

                    <p class="text-xs uppercase tracking-wide text-[#6B4A3A]">
                        Utilisateur
                    </p>

                    <p class="mt-2 font-semibold text-[#4B2E1F]">
                        {{ $first_name }} {{ $last_name }}
                    </p>

                    <p class="text-sm text-[#6B4A3A]">
                        {{ $email }}
                    </p>

                    <p class="text-sm text-[#6B4A3A]">
                        Rôle :
                        <span class="font-medium">
                            {{ $role }}
                        </span>
                    </p>

                </div>


                {{-- QUESTIONNAIRES --}}
                <div class="p-5 rounded-2xl bg-[#F7F2EE]">

                    <p class="text-xs uppercase tracking-wide text-[#6B4A3A]">
                        Questionnaires
                    </p>

                    <p class="mt-2 font-semibold text-[#4B2E1F]">
                        {{ count($selectedForms) }}
                        questionnaire(s) assigné(s)
                    </p>

                </div>

            </div>
            <br>

            {{-- OPTIONS --}}
            <div class="space-y-4">

                <label
                    class="
                        flex
                        gap-4
                        p-5
                        rounded-2xl
                        border
                        cursor-pointer
                        transition
                        {{ $notification === 'now'
                            ? 'border-[#C87A2A] bg-[#FFF8F1]'
                            : 'border-[#EADFD3]' }}
                    "
                >

                    <input
                        type="radio"
                        wire:model="notification"
                        value="now"
                        class="mt-1 text-[#C87A2A] focus:ring-[#C87A2A]"
                    >

                    <div>

                        <p class="font-semibold text-[#4B2E1F]">
                            Envoyer les identifiants maintenant
                        </p>

                        <p class="text-sm text-[#6B4A3A] mt-1">
                            L'utilisateur recevra immédiatement un email
                            contenant ses identifiants de connexion.
                        </p>

                    </div>

                </label>

                <br>
                <label
                    class="
                        flex
                        gap-4
                        p-5
                        rounded-2xl
                        border
                        cursor-pointer
                        transition
                        {{ $notification === 'later'
                            ? 'border-[#C87A2A] bg-[#FFF8F1]'
                            : 'border-[#EADFD3]' }}
                    "
                >

                    <input
                        type="radio"
                        wire:model="notification"
                        value="later"
                        class="mt-1 text-[#C87A2A] focus:ring-[#C87A2A]"
                    >

                    <div>

                        <p class="font-semibold text-[#4B2E1F]">
                            Envoyer les identifiants plus tard
                        </p>

                        <p class="text-sm text-[#6B4A3A] mt-1">
                            Le compte sera créé mais aucun email ne sera envoyé
                            maintenant.
                        </p>

                    </div>

                </label>

            </div>


            {{-- ACTIONS --}}
            <div class="flex justify-between mt-10 pt-6 border-t border-[#EADFD3]">

                <button
                    type="button"
                    wire:click="previousStep"
                    class="px-5 py-3 rounded-xl border border-[#EADFD3] text-white font-medium hover:bg-[#F7F2EE]"
                    style="
                        background-color: #BB7229;
                        padding-top: 10px;
                        padding-bottom: 10px;
                    "
                    >
                    Retour
                </button>

                <button
                    type="button"
                    wire:click="finish"
                    wire:loading.attr="disabled"
                    class="px-6 py-3 rounded-xl bg-[#C87A2A] text-white font-medium hover:bg-[#B36C22]"
                    style="
                        background-color: #BB7229;
                        padding-top: 10px;
                        padding-bottom: 10px;
                    "
                    >
                    Terminer
                </button>

            </div>

        </div>

    @endif

</div>