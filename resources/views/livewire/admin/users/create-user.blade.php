<div class="max-w-4xl mx-auto space-y-6">

    <h1 class="text-2xl font-semibold">
        Nouvel utilisateur
    </h1>

    <div class="max-w-xl
                mx-automx-auto
                bg-white/70
                backdrop-blur-sm
                border
                border-[#EADFD3]
                rounded-[32px]
                shadow-[0_10px_40px_rgba(74,45,33,0.08)]
                p-8
                lg:p-12">

        <div class="
            mx-auto
            w-[250px]
            flex
            flex-col
            gap-4">

            <input
                type="text"
                wire:model="first_name"
                placeholder="Prénom"
                class="
                    w-full
                    rounded-xl
                    border
                    border-[#EADFD3]
                    bg-white
                    px-4
                    py-3
                    focus:ring-2
                    focus:ring-[#C87A2A]
                    focus:border-[#C87A2A]
                "
            >

            <input
                type="text"
                wire:model="last_name"
                placeholder="Nom"
                class="
                    w-full
                    rounded-xl
                    border
                    border-[#EADFD3]
                    bg-white
                    px-4
                    py-3
                    focus:ring-2
                    focus:ring-[#C87A2A]
                    focus:border-[#C87A2A]
                "
            >

            <input
                type="email"
                wire:model="email"
                placeholder="Email"
                class="rounded-lg"
            >

            <input
                type="text"
                wire:model="phone"
                placeholder="Téléphone"
                class="rounded-lg"
            >

            <input
                type="text"
                wire:model="city"
                placeholder="Ville"
                class="rounded-lg"
            >

            <input
                type="text"
                wire:model="country"
                placeholder="Pays"
                class="rounded-lg"
            >

            <select
                wire:model="role"
                class="rounded-lg"
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

        <div class="mt-6 text-center">

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
                Créer l'utilisateur
            </button>

        </div>

    </div>

</div>