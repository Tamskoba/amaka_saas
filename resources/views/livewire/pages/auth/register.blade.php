<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Volt\Component;

new class extends Component
{
    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([

            'first_name' => [
                'required',
                'string',
                'max:255'
            ],

            'last_name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::defaults(),
            ],

        ]);

        $validated['password'] = Hash::make(
            $validated['password']
        );

        event(new Registered(

            $user = User::create($validated)

        ));

        Auth::login($user);

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
                Créez votre
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
                Accédez à votre parcours
                personnalisé, vos questionnaires
                et vos analyses afro-fonctionnelles.
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
                “Je n’aide pas les femmes
                à essayer plus.
                Je les aide à arrêter
                de perdre du temps.”
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
                max-w-2xl
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
                    Commencez votre parcours
                </p>

                <h2
                    class="
                        text-5xl
                        font-heading
                        text-[#4A2D21]
                        mb-4
                    "
                >
                    Créer un compte
                </h2>

                <p
                    class="
                        text-[#6D5245]
                        text-lg
                        leading-relaxed
                    "
                >
                    Rejoignez votre espace santé
                    afro-fonctionnel personnalisé.
                </p>

            </div>

            {{-- FORM --}}
            <form wire:submit="register">

                {{-- NAME GRID --}}
                <div
                    class="
                        grid
                        md:grid-cols-2
                        gap-6
                        mb-6
                    "
                >

                    {{-- FIRST NAME --}}
                    <div>

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
                            Prénom
                        </label>

                        <input
                            wire:model="first_name"
                            type="text"
                            placeholder="Votre prénom"
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

                        @error('first_name')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    {{-- LAST NAME --}}
                    <div>

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
                            Nom
                        </label>

                        <input
                            wire:model="last_name"
                            type="text"
                            placeholder="Votre nom"
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

                        @error('last_name')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>

                {{-- EMAIL --}}
                <div class="mb-6">

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
                        autocomplete="username"
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
                        for="password"
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
                        id="password"
                        type="password"
                        required
                        autocomplete="new-password"
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

                {{-- CONFIRM PASSWORD --}}
                <div class="mb-10">

                    <label
                        for="password_confirmation"
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
                        Confirmation du mot de passe
                    </label>

                    <input
                        wire:model="password_confirmation"
                        id="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
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

                    @error('password_confirmation')

                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

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
                    Créer mon compte →
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
                    text-[#6D5245]
                "
            >

                <p class="mb-2">
                    Vous avez déjà un compte ?
                </p>

                <a
                    href="{{ route('login') }}"
                    wire:navigate
                    class="
                        text-[#C9822B]
                        font-medium
                        hover:text-[#B87424]
                        transition
                    "
                >
                    Se connecter
                </a>

            </div>

        </div>

    </div>

</div>