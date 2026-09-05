<div class="space-y-6">

    <div class="flex justify-between items-center">

        <h1 class="text-2xl font-semibold">
            Utilisateurs
        </h1>

        <a
            href="{{ route('admin.users.create') }}"
            
            class="
                amaka-btn-primary
            "
        >
            Nouvel utilisateur
        </a>
        <a
            href="{{ route('admin.trash.index') }}"
        >
            Corbeille
        </a>

    </div>

    <div class="flex gap-3">

        <input
            type="text"
            wire:model.live="search"
            placeholder="Nom ou email..."
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

        <button
            wire:click="loadUsers"
            class="
                amaka-btn-primary
            "
        >
            Rechercher
        </button>

    </div>

    <table class="
            bg-white/70
            backdrop-blur-sm
            border
            border-[#EADFD3]
            rounded-[32px]
            shadow-[0_10px_40px_rgba(74,45,33,0.08)]
            p-6
        ">

        <thead>

            <tr>

                <th>Prénom</th>

                <th>Nom</th>

                <th>Email</th>

                <th>Statut</th>

                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

            @foreach($users as $user)

                <tr>

                    <td>
                        {{ $user['first_name'] }}
                    </td>

                    <td>
                        {{ $user['last_name'] }}
                    </td>

                    <td>
                        {{ $user['email'] }}
                    </td>

                    <td>

                        @if($user['is_active'])

                            Actif

                        @else

                            Inactif

                        @endif

                    </td>

                    <td class="space-x-2">

                        <a
                            href="{{ route(
                                'admin.users.edit',
                                $user['id']
                            ) }}"
                        >
                            Modifier
                        </a>

                        <button
                            wire:click="deleteUser({{ $user['id'] }})"
                            wire:confirm="
                                Voulez-vous vraiment placer cet utilisateur dans la corbeille ?
                            "
                            class="
                                px-3
                                py-1
                                rounded-lg
                                bg-red-100
                                text-red-700
                            "
                        >
                            Supprimer
                        </button>
                        <a
                            href="{{
                                route(
                                    'admin.users.forms',
                                    $user['id']
                                )
                            }}"
                            class="
                                px-3
                                py-1
                                rounded-lg
                                bg-blue-100
                                text-blue-700
                            "
                        >
                            Questionnaires
                        </a>
                        <a
                            href="{{ route(
                                'admin.users.sessions',
                                $user['id']
                            ) }}"
                            class="
                                px-3
                                py-1
                                rounded-lg
                                bg-purple-100
                                text-purple-700
                            "
                        >
                            Historique sessions
                        </a>
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>