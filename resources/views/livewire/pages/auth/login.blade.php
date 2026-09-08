<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
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
        grid
        lg:grid-cols-2
        bg-[#F5EFE9]
    "
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
                Lecture afro-métabolique
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
                Accédez à votre
                espace fertilité.
            </h1>

            <p
                class="
                    text-xl
                    leading-relaxed
                    text-[#6D5245]
                    max-w-lg
                "
            >
                Retrouvez votre espace personnalisé,
                vos questionnaires afro-métaboliques
                et votre suivi santé.
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
                “Le problème n’est pas ton engagement.
                Le problème, c’est l’absence
                de lecture adaptée à ton corps.”
            </p>

        </div>

        {{-- BACKGROUND CIRCLE --}}
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
                    Heureux de vous revoir
                </p>

                <h2
                    class="
                        text-5xl
                        font-heading
                        text-[#4A2D21]
                        mb-4
                    "
                >
                    Connexion
                </h2>

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

                        <p class="mt-2 text-sm text-red-500">
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
                        bg-[#C9822B]
                        hover:bg-[#B87424]
                        text-black
                        py-5
                        text-lg
                        font-medium
                        transition-all
                        duration-300
                        shadow-lg
                        hover:shadow-xl
                    "
                >
                    Se connecter →
                </button>

            </form>

            {{-- FOOTER --}}

        </div>

    </div>

</div>