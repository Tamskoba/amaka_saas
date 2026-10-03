<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Page introuvable | Amaka</title>

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
                            d="M9 4.5h6M10 3h4a1 1 0 0 1 1 1v1.5h1.5A1.5 1.5 0 0 1 18 7v12a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 6 19V7a1.5 1.5 0 0 1 1.5-1.5H9V4a1 1 0 0 1 1-1Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9.5 11.5h5M9.5 15h3"
                        />
                    </svg>

                </div>


                {{-- Code --}}
                <div class="text-5xl font-bold text-[#4B2E1F] mb-3">
                    404
                </div>


                {{-- Titre --}}
                <h1 class="text-2xl font-semibold text-[#4B2E1F] mb-4">
                    Page introuvable
                </h1>


                {{-- Message --}}
                <p class="text-[#6B4A3A] leading-relaxed mb-8">
                    La page que vous recherchez n’existe pas ou n’est plus disponible.
                    Vérifiez l’adresse utilisée ou revenez à votre espace Amaka.
                </p>


                {{-- Actions --}}
                <br>
                <div class="flex flex-wrap items-center justify-center gap-3">

                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center
                            px-6 py-3
                            text-sm font-semibold text-white
                            transition hover:bg-[#B36C22]"
                        style="background-color: #BB7229; border-radius: 10px;"
                    >
                        Retour au tableau de bord
                    </a>
                    ou
                    <button
                        type="button"
                        onclick="history.back()"
                        class="inline-flex items-center justify-center
                            px-6 py-3
                            text-sm font-semibold text-white
                            transition hover:bg-[#B36C22]"
                        style="background-color: #BB7229; border-radius: 10px;"
                    >
                        Page précédente
                    </button>

                </div>

            </div>


            {{-- Petit pied de page --}}
            <p class="text-center text-xs text-[#8A6A58] mt-6">
                © {{ date('Y') }} Amaka — Tous droits réservés
            </p>

        </div>
    </body>
</html>