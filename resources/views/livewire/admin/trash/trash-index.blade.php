<div
    class="
        space-y-6
    "
>

    {{-- HEADER --}}
    <div
        class="
            flex
            items-center
            justify-between
        "
    >

        <div>

            <h1
                class="
                    text-2xl
                    font-semibold
                    text-gray-900
                "
            >
                Corbeille
            </h1>

            <p
                class="
                    text-sm
                    text-gray-500
                    mt-1
                "
            >
                Les éléments supprimés sont conservés pendant
                7 jours avant suppression définitive.
            </p>

        </div>

    </div>

    {{-- TABS --}}
    <div
        class="
            flex
            gap-3
        "
    >

        <button

            wire:click="$set('tab', 'forms')"

            @class([

                'px-4 py-2 rounded-lg transition',

                'bg-[#C87A2A] text-black'
                    => $tab === 'forms',

                'bg-gray-100 text-gray-700'
                    => $tab !== 'forms',

            ])

        >
            Questionnaires
        </button>

        <button

            wire:click="$set('tab', 'users')"

            @class([

                'px-4 py-2 rounded-lg transition',

                'bg-[#C87A2A] text-black'
                    => $tab === 'users',

                'bg-gray-100 text-gray-700'
                    => $tab !== 'users',

            ])

        >
            Utilisateurs
        </button>

    </div>

    {{-- QUESTIONNAIRES --}}
    @if($tab === 'forms')

        <div
            class="
                bg-white
                rounded-xl
                border
                border-gray-200
                overflow-hidden
            "
        >

            <table class="w-full">

                <thead>

                    <tr
                        class="
                            bg-gray-50
                            text-left
                            text-sm
                            text-gray-600
                        "
                    >

                        <th class="p-4">
                            Titre
                        </th>

                        <th class="p-4">
                            Description
                        </th>

                        <th class="p-4">
                            Supprimé le
                        </th>

                        <th class="p-4">
                            Purge prévue
                        </th>

                        <th
                            class="
                                p-4
                                text-right
                            "
                        >
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($forms as $form)

                        <tr
                            class="
                                border-t
                                border-gray-100
                            "
                        >

                            <td class="p-4">

                                <div
                                    class="
                                        font-medium
                                        text-gray-900
                                    "
                                >
                                    {{ $form['title'] }}
                                </div>

                            </td>

                            <td
                                class="
                                    p-4
                                    text-sm
                                    text-gray-600
                                "
                            >
                                {{ $form['description'] }}
                            </td>

                            <td
                                class="
                                    p-4
                                    text-sm
                                    text-gray-600
                                "
                            >
                                {{ $form['deleted_at'] }}
                            </td>

                            <td
                                class="
                                    p-4
                                    text-sm
                                    text-red-600
                                "
                            >
                                {{ $form['purge_at'] }}
                            </td>

                            <td
                                class="
                                    p-4
                                    text-right
                                "
                            >

                                <div
                                    class="
                                        flex
                                        justify-end
                                        gap-2
                                    "
                                >

                                    <button

                                        wire:click="
                                            restoreForm(
                                                {{ $form['id'] }}
                                            )
                                        "

                                        class="
                                            px-3
                                            py-2
                                            rounded-lg
                                            bg-green-100
                                            text-green-700
                                        "
                                    >
                                        Restaurer
                                    </button>

                                    <button
                                        wire:click="forceDeleteForm({{ $form['id'] }})"
                                        onclick="return confirm('Supprimer définitivement ce questionnaire ?')"
                                        class="
                                            px-3
                                            py-1
                                            rounded-lg
                                            bg-red-600
                                            text-white
                                        "
                                    >
                                        Supprimer définitivement
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="
                                    p-10
                                    text-center
                                    text-gray-500
                                "
                            >
                                Aucun questionnaire supprimé.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    @endif

    {{-- UTILISATEURS --}}
    @if($tab === 'users')

        <div
            class="
                bg-white
                rounded-xl
                border
                border-gray-200
                overflow-hidden
            "
        >

            <table class="w-full">

                <thead>

                    <tr
                        class="
                            bg-gray-50
                            text-left
                            text-sm
                            text-gray-600
                        "
                    >

                        <th class="p-4">
                            Prénom
                        </th>

                        <th class="p-4">
                            Nom
                        </th>

                        <th class="p-4">
                            Email
                        </th>

                        <th class="p-4">
                            Supprimé le
                        </th>

                        <th class="p-4">
                            Purge prévue
                        </th>

                        <th
                            class="
                                p-4
                                text-right
                            "
                        >
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr
                            class="
                                border-t
                                border-gray-100
                            "
                        >

                            <td class="p-4">
                                {{ $user['first_name'] ?? '' }}
                            </td>

                            <td class="p-4">
                                {{ $user['last_name'] ?? '' }}
                            </td>

                            <td class="p-4">
                                {{ $user['email'] }}
                            </td>

                            <td
                                class="
                                    p-4
                                    text-sm
                                    text-gray-600
                                "
                            >
                                {{ $user['deleted_at'] }}
                            </td>

                            <td
                                class="
                                    p-4
                                    text-sm
                                    text-red-600
                                "
                            >
                                {{ $user['purge_at'] }}
                            </td>

                            <td
                                class="
                                    p-4
                                    text-right
                                "
                            >

                                <div
                                    class="
                                        flex
                                        justify-end
                                        gap-2
                                    "
                                >

                                    <button

                                        wire:click="
                                            restoreUser(
                                                {{ $user['id'] }}
                                            )
                                        "

                                        class="
                                            px-3
                                            py-2
                                            rounded-lg
                                            bg-green-100
                                            text-green-700
                                        "
                                    >
                                        Restaurer
                                    </button>

                                    <button
                                        wire:click="forceDeleteUser({{ $user['id'] }})"
                                        onclick="return confirm('Supprimer définitivement cet utilisateur ?')"
                                        class="
                                            px-3
                                            py-1
                                            rounded-lg
                                            bg-red-600
                                            text-white
                                        "
                                    >
                                        Supprimer définitivement
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="
                                    p-10
                                    text-center
                                    text-gray-500
                                "
                            >
                                Aucun utilisateur supprimé.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    @endif

</div>