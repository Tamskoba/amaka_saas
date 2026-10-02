<div class="max-w-4xl mx-auto">

    <h1
        class="
            text-2xl
            font-semibold
            mb-6
        "
    >
        Modifier l'utilisateur
    </h1>

    <div
        class="
            max-w-2xl
            mx-auto
            rounded-xl
            border
            p-6
        "
    >

        <div
            class="
                max-w-lg
                mx-auto
                flex
                flex-col
                gap-4
            "
        >

            <div>

                <label
                    class="
                        block
                        mb-1
                        font-medium
                    "
                >
                    Prénom
                </label>

                <input
                    type="text"
                    wire:model="first_name"
                    class="
                        w-full
                        rounded-lg
                    "
                >

            </div>

            <div>

                <label
                    class="
                        block
                        mb-1
                        font-medium
                    "
                >
                    Nom
                </label>

                <input
                    type="text"
                    wire:model="last_name"
                    class="
                        w-full
                        rounded-lg
                    "
                >

            </div>

            <div>
                <label class="block mb-1 font-medium">Email</label>

                <input
                    type="email"
                    wire:model="email"
                    class="w-full rounded-lg @error('email') border-red-500 @enderror"
                >

                @error('email')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>

                <label
                    class="
                        block
                        mb-1
                        font-medium
                    "
                >
                    Téléphone
                </label>

                <input
                    type="text"
                    wire:model="phone"
                    class="
                        w-full
                        rounded-lg
                    "
                >

            </div>

            <div>

                <label
                    class="
                        block
                        mb-1
                        font-medium
                    "
                >
                    Ville
                </label>

                <input
                    type="text"
                    wire:model="city"
                    class="
                        w-full
                        rounded-lg
                    "
                >

            </div>

            <div>

                <label
                    class="
                        block
                        mb-1
                        font-medium
                    "
                >
                    Pays
                </label>

                <input
                    type="text"
                    wire:model="country"
                    class="
                        w-full
                        rounded-lg
                    "
                >

            </div>

            <div>

                <label
                    class="
                        block
                        mb-1
                        font-medium
                    "
                >
                    Nouveau mot de passe
                </label>

                <input
                    type="password"
                    wire:model="password"
                    class="
                        w-full
                        rounded-lg
                    "
                >

                <p
                    class="
                        text-xs
                        text-gray-500
                        mt-1
                    "
                >
                    Laisser vide pour conserver le mot de passe actuel.
                </p>

            </div>

            <div>

                <label
                    class="
                        block
                        mb-1
                        font-medium
                    "
                >
                    Rôle
                </label>

                <select
                    wire:model="role"
                    class="
                        w-full
                        rounded-lg
                    "
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

            </div>

            <div>

                <label
                    class="
                        flex
                        items-center
                        gap-2
                    "
                >

                    <input
                        type="checkbox"
                        wire:model="is_active"
                    >

                    <span>
                        Utilisateur actif
                    </span>

                </label>

            </div>

            <div
                class="
                    mt-8
                    pt-6
                    border-t
                    border-[#EADFD3]
                    flex
                    items-center
                    justify-between
                    gap-4
                "
            >

                {{-- ANNULER --}}
                <button
                    type="button"
                    wire:click="cancel"
                    class="
                        px-5
                        py-3
                        rounded-xl
                        border
                        border-[#EADFD3]
                        text-[#6B4A3A]
                        hover:bg-[#F7F2EE]
                        transition
                        font-medium
                    "
                    style="
                        background-color: #ff0000;
                        padding-top: 10px;
                        padding-bottom: 10px;
                        color : #ffffff;
                    "
                >
                    Annuler
                </button>


                {{-- ENREGISTRER --}}
                <button
                    type="button"
                    wire:click="save"
                    wire:loading.attr="disabled"
                    class="
                        px-5
                        py-3
                        rounded-xl
                        bg-[#C87A2A]
                        text-white
                        font-medium
                        hover:bg-[#B36C22]
                        transition
                    "
                    style="
                        background-color: #BB7229;
                        padding-top: 10px;
                        padding-bottom: 10px;
                    "
                >
                    Enregistrer les modifications
                </button>

            </div>

        </div>

    </div>

</div>