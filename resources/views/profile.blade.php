<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"
        style="
            background-color: #F7F1ED;
        " 
        >
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12"
        style="
            background-color: #F7F1ED;
        " 
    >
        <div class="mx-auto max-w-7xl space-y-6 bg-transparent sm:px-6 lg:px-8">

            {{-- Informations du profil --}}
            <div class="bg-transparent p-4 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            {{-- Modification du mot de passe --}}
            <div class="bg-transparent p-4 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            {{-- Suppression du compte désactivée --}}
            {{-- 
            <div class="bg-transparent p-4 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
            --}}

        </div>
    </div>

</x-app-layout>