<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {

            $this->addError(
                'email',
                __($status)
            );

            return;
        }

        $this->reset('email');

        session()->flash(
            'status',
            __($status)
        );
    }
};

?>

<div
    class="
        min-h-screen
        grid
        lg:grid-cols-2
    "
    style="background-color: #F7F1ED;"    
>

    {{-- LEFT SIDE --}}
    <div
        class="
            hidden
            lg:flex
            flex-col
            justify-between
            relative
            overflow-hidden
            px-16
            py-14
            bg-[#EFE7DF]
        "
    >

        {{-- CONTENT --}}
        <div class="max-w-xl">

            <p
                class="
                    text-[#C9822B]
                    italic
                    text-lg
                    mb-6
                "
            >
                Espace Afro-Fertilité
            </p>

            <h1
                class="
                    text-6xl
                    leading-tight
                    font-heading
                    text-[#4A2D21]
                    mb-8
                "
            >
                Réinitialisez
                votre accès.
            </h1>

            <p
                class="
                    text-xl
                    leading-relaxed
                    text-[#6D5245]
                    max-w-lg
                "
            >
                Recevez un lien sécurisé pour
                retrouver l’accès à votre espace
                santé personnalisé.
            </p>

        </div>

        {{-- QUOTE --}}
        <div class="max-w-lg">

            <div
                class="
                    w-16
                    h-[2px]
                    bg-[#C9822B]
                    mb-6
                "
            ></div>

            <p
                class="
                    text-3xl
                    leading-relaxed
                    font-heading
                    text-[#4A2D21]
                "
            >
                “Comprendre ce qui bloque
                commence par retrouver
                un accès clair à son espace.”
            </p>

        </div>

        {{-- BACKGROUND SHAPE --}}
        <div
            class="
                absolute
                -bottom-32
                -right-32
                w-[420px]
                h-[420px]
                rounded-full
                bg-[#E7DBD0]
                blur-3xl
                opacity-60
            "
        ></div>

    </div>

    {{-- RIGHT SIDE --}}
    <div
        class="
            flex
            items-center
            justify-center
            px-6
            py-10
            bg-[#F8F2EC]
        "
    >

        {{-- CARD --}}
        <div
            class="
                w-full
                max-w-xl
                bg-white/70
                backdrop-blur-sm
                border
                border-[#EADFD3]
                rounded-[32px]
                shadow-[0_10px_40px_rgba(74,45,33,0.08)]
                p-8
                lg:p-12
            "
        >

            {{-- HEADER --}}
            <div class="mb-10">

                <p
                    class="
                        text-[#C9822B]
                        italic
                        text-base
                        mb-4
                    "
                >
                    Mot de passe oublié
                </p>

                <h2
                    class="
                        text-5xl
                        font-heading
                        text-[#4A2D21]
                        mb-4
                    "
                >
                    Réinitialisation
                </h2>

                <p
                    class="
                        text-[#6D5245]
                        text-lg
                        leading-relaxed
                    "
                >
                    Entrez votre adresse email pour recevoir
                    un lien de réinitialisation sécurisé.
                </p>

            </div>

            {{-- SESSION STATUS --}}
            @if (session('status'))

                <div
                    class="
                        mb-6
                        rounded-2xl
                        border
                        border-[#D8C3A7]
                        bg-[#F6EEE5]
                        px-5
                        py-4
                        text-sm
                        text-[#7A5737]
                    "
                >
                    {{ session('status') }}
                </div>

            @endif

            {{-- FORM --}}
            <form wire:submit="sendPasswordResetLink">

                {{-- EMAIL --}}
                <div class="mb-8">

                    <label
                        for="email"
                        class="
                            block
                            mb-3
                            text-sm
                            uppercase
                            tracking-wide
                            font-medium
                            text-[#4A2D21]
                        "
                    >
                        Adresse email
                    </label>

                    <input
                        wire:model="email"
                        id="email"
                        type="email"
                        required
                        autofocus
                        placeholder="nom@email.com"
                        class="
                            w-full
                            rounded-2xl
                            border
                            border-[#E6D9CC]
                            bg-[#FCFAF8]
                            px-5
                            py-4
                            text-[#4A2D21]
                            placeholder:text-[#B7A69A]
                            focus:ring-2
                            focus:ring-[#C9822B]
                            focus:border-transparent
                            outline-none
                            transition
                        "
                    >

                    @error('email')

                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>
                <br>

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="
                        w-full
                        rounded-2xl
                        bg-[#C9822B]
                        hover:bg-[#B87424]
                        text-white
                        py-5
                        text-lg
                        font-medium
                        transition-all
                        duration-300
                        shadow-lg
                        hover:shadow-xl
                    "
                    style="background-color: #bb7229;padding-top: 10px;padding-bottom :10px"
                >
                    Envoyer le lien →
                </button>

            </form>

            {{-- FOOTER --}}
            <div
                class="
                    mt-10
                    pt-8
                    border-t
                    border-[#EEE3D7]
                    text-center
                "
            >

                <a
                    href="/login"
                    class="
                        text-[#C9822B]
                        font-medium
                        hover:text-[#B87424]
                        transition
                    "
                >
                    ← Retour à la connexion
                </a>

            </div>

        </div>

    </div>

</div>