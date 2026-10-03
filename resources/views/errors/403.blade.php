<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Accès non autorisé | Amaka</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F7F1ED] flex items-center justify-center px-6" style="background-color: #F7F1ED;">

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
                        d="M12 9v4m0 4h.01M10.3 3.8 2.7 18a2 2 0 0 0 1.7 3h15.2a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0Z"
                    />
                </svg>

            </div>


            {{-- Code --}}
            <div class="text-5xl font-bold text-[#4B2E1F] mb-3">
                403
            </div>


            {{-- Titre --}}
            <h1 class="text-2xl font-semibold text-[#4B2E1F] mb-4">
                Accès non autorisé
            </h1>


            {{-- Message --}}
            <p class="text-[#6B4A3A] leading-relaxed mb-8">
                Vous n’avez pas les autorisations nécessaires pour accéder à cette page.
                Si vous pensez qu’il s’agit d’une erreur, veuillez contacter
                l’administrateur de votre espace Amaka.
            </p>


            {{-- Actions --}}
            <br>
            <div class="flex flex-wrap items-center justify-center gap-3">

                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center rounded-[14px]
                           bg-[#C87A2A] px-6 py-3
                           text-sm font-semibold text-white
                           transition hover:bg-[#B36C22]"
                    style="background-color: #bb7229;border-radius: 10px;"        
                >
                    Retour au tableau de bord
                </a>

                ou 
                <button
                    type="button"
                    onclick="history.back()"
                    class="inline-flex items-center justify-center rounded-[14px]
                           border border-[#EADFD3]
                           bg-white px-6 py-3 font-medium
                           text-sm text-[#6B4A3A]
                           transition hover:bg-[#F7F2EE]"
                    style="background-color: #bb7229; color:#ffffff;border-radius: 10px;"       
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