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
            bg-white
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

                <label
                    class="
                        block
                        mb-1
                        font-medium
                    "
                >
                    Email
                </label>

                <input
                    type="email"
                    wire:model="email"
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
                class="mt-6 text-center"
            >

                <button
                    wire:click="save"
                    class="
                        px-5
                        py-3
                        rounded-lg
                        bg-[#C87A2A]
                        text-black
                    "
                >
                    Enregistrer les modifications
                </button>

            </div>

        </div>

    </div>

</div>