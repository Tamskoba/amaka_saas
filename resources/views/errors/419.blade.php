<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Session expirée | Amaka</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body class="min-h-screen bg-[#F7F1ED] flex items-center justify-center px-6"
        style="background-color: #F7F1ED;">

        <div class="w-full max-w-lg">

            <div class="rounded-[24px] shadow-sm border border-[#EADFD3] p-8 sm:p-10 text-center">

                {{-- Logo / nom --}}
                <div class="mb-8">
                    <div class="text-2xl font-semibold text-[#4B2E1F]">
                        Amaka
                    </div>

                    <div class="text-sm text-[#6B4A3A] mt-1">
                        Santé & micronutrition
                    </div>
                </div>


                {{-- Icône --}}
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[#F7E9DD]">

                    <svg
                        class="h-10 w-10 text-[#C87A2A]"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 8v4l2.5 2.5"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20.5 12a8.5 8.5 0 1 1-2.49-6.01"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 4h3.5v3.5"
                        />

                    </svg>

                </div>


                {{-- Code --}}
                <div class="text-5xl font-bold text-[#4B2E1F] mb-3">
                    419
                </div>


                {{-- Titre --}}
                <h1 class="text-2xl font-semibold text-[#4B2E1F] mb-4">
                    Votre session a expiré
                </h1>


                {{-- Message --}}
                <p class="text-[#6B4A3A] leading-relaxed mb-8">
                    Votre session a expiré pour des raisons de sécurité.
                    Veuillez actualiser la page et réessayer.
                    Si le problème persiste, reconnectez-vous à votre espace Amaka.
                </p>


                {{-- Actions --}}
                <div class="flex flex-wrap items-center justify-center gap-3">

                    <button
                        type="button"
                        onclick="window.location.reload()"
                        class="inline-flex items-center justify-center
                            px-6 py-3
                            text-sm font-semibold text-white
                            transition hover:bg-[#B36C22]"
                        style="background-color: #BB7229; border-radius: 10px;"
                    >
                        Actualiser la page
                    </button>

                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center justify-center
                            px-6 py-3
                            text-sm font-semibold text-white
                            transition hover:bg-[#B36C22]"
                        style="background-color: #BB7229; border-radius: 10px;"
                    >
                        Se reconnecter
                    </a>

                </div>

            </div>


            {{-- Petit pied de page --}}
            <p class="text-center text-xs text-[#8A6A58] mt-6">
                © {{ date('Y') }} Amaka — Tous droits réservés
            </p>

        </div>

    </body>
</html>