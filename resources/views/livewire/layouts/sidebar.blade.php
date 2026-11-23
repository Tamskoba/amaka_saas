<aside
    class="
        w-72
        bg-white
        border-r
        border-[#EFE2D5]
        hidden
        md:flex
        flex-col
        min-h-screen
    "
    style="
        background-color: #F7F1ED;
    "     
>

    {{-- LOGO --}}
    <div
        class="
            h-24
            flex
            items-center
            px-8
            border-b
            border-[#EFE2D5]
        "
    >

        <div>

            <h1
                class="
                    text-4xl
                    text-[#4B2E1F]
                    font-['Playfair_Display']
                "
            >
                Amaka
            </h1>

            <p
                class="
                    text-sm
                    italic
                    text-[#6B4A3A]
                "
            >
                Nutrition & équilibre
            </p>

        </div>

    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 p-5 space-y-3">

        <a href="/dashboard"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition
            {{ request()->routeIs('dashboard')
                ? 'bg-[#C87A2A] text-black font-semibold shadow-sm'
                : 'text-[#6B4A3A] hover:bg-[#EADFD3]' }}">
            <span>📊</span>        
            <span>Mon tableau de bord</span> 
        </a>

        <a
            href="/forms"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition
            {{ request()->routeIs('forms.index')
                    ? 'bg-[#C87A2A] text-black font-semibold shadow-sm'
                    : 'text-[#6B4A3A] hover:bg-[#EADFD3]' }}"
        >
            <span>📋</span>        
            <span>Mes questionnaires</span>
        </a>

        <a
            href="/profile"
            class="flex items-center gap-3 rounded-xl px-4 py-3 transition
            {{ request()->routeIs('profile')
                    ? 'bg-[#C87A2A] text-whblackite font-semibold shadow-sm'
                    : 'text-[#6B4A3A] hover:bg-[#EADFD3]' }}"
        >
            <span>👤</span>
            <span>Mon compte<span>
        </a>       
        
        {{-- ADMIN ACCESS --}}
        @auth
        @if(

            auth()->user()->role === 'admin'
            || auth()->user()->role === 'super_admin'
            || auth()->user()->role === 'micronutritionniste'
        )

            <a
                href="{{ route('admin.dashboard') }}"
                class="
                    flex
                    items-center
                    gap-3
                    px-5
                    py-4
                    rounded-2xl
                    hover:bg-[#F8F1EB]
                    transition
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 7h18M3 12h18M3 17h18"
                    />
                </svg>

                <span>
                    Administration
                </span>

            </a>

        @endif
        @endauth
    </nav>

</aside>