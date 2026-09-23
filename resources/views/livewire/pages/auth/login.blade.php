<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {

            throw ValidationException::withMessages([
                'email' => 'Identifiants incorrects.',
            ]);
        }

        request()->session()->regenerate();

        $this->redirect(
            route('dashboard'),
            navigate: true
        );
    }
};
?>

<div
    class="
        min-h-screen
        flex
        items-center
        justify-center
        px-6
        py-10
    "
    style="background-color: #F7F1ED;"
>

    {{-- LOGIN CARD --}}
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
               Amakanutrition
            </p>

            <h1
                class="
                    text-5xl
                    font-heading
                    text-[#4A2D21]
                    mb-4
                "
            >
                Connexion
            </h1>

            <p
                class="
                    text-[#6D5245]
                    text-lg
                    leading-relaxed
                "
            >
                Accédez à votre espace santé personnalisé.
            </p>

        </div>


        {{-- FORM --}}
        <form wire:submit="login">

            {{-- EMAIL --}}
            <div class="mb-6">

                <label
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
                    type="email"
                    placeholder="nom@email.com"
                    autocomplete="email"
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
                    <p
                        class="
                            mt-2
                            text-sm
                            text-red-500
                        "
                    >
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- PASSWORD --}}
            <div class="mb-6">

                <label
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
                    Mot de passe
                </label>

                <input
                    wire:model="password"
                    type="password"
                    placeholder="••••••••"
                    autocomplete="current-password"
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

                @error('password')
                    <p
                        class="
                            mt-2
                            text-sm
                            text-red-500
                        "
                    >
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- REMEMBER --}}
            <div
                class="
                    flex
                    items-center
                    justify-between
                    mb-10
                "
            >

                <label
                    class="
                        flex
                        items-center
                        gap-3
                    "
                >

                    <input
                        wire:model="remember"
                        type="checkbox"
                        class="
                            rounded
                            border-[#DCCBBB]
                            text-[#C9822B]
                            focus:ring-[#C9822B]
                        "
                    >

                    <span
                        class="
                            text-sm
                            text-[#6D5245]
                        "
                    >
                        Se souvenir de moi
                    </span>

                </label>


                <a
                    href="/forgot-password"
                    class="
                        text-sm
                        text-[#C9822B]
                        hover:text-[#B97321]
                        transition
                    "
                >
                    Mot de passe oublié ?
                </a>

            </div>


            {{-- BUTTON --}}
            <button
                type="submit"
                class="
                    w-full
                    rounded-2xl
                    text-white
                    py-5
                    text-lg
                    font-medium
                    transition-all
                    duration-300
                    shadow-lg
                    hover:shadow-xl
                "
                style="
                    background-color: #BB7229;
                    padding-top: 10px;
                    padding-bottom: 10px;
                "
            >
                Se connecter →
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
                href="/"
                class="
                    text-[#C9822B]
                    font-medium
                    hover:text-[#B87424]
                    transition
                "
            >
                ← Retour à l'accueil
            </a>

        </div>
    </div>

</div>