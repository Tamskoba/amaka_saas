<div
    class="
        bg-white
        rounded-[32px]
        p-8
        border
        border-[#F1E4D8]
        shadow-[0_10px_40px_rgba(0,0,0,0.04)]
    "
>

    <h3
        class="
            text-2xl
            text-[#4B2E1F]
            mb-6
            font-semibold
        "
    >
        Activité récente
    </h3>

    <div class="space-y-5">

        @foreach($activities as $activity)

            <div
                class="
                    flex
                    items-center
                    justify-between
                    border-b
                    border-[#F5E9DE]
                    pb-4
                "
            >

                <div>

                    <div class="font-medium text-[#4B2E1F]">

                        {{ $activity->form->title }}

                    </div>

                    <div
                        class="
                            text-sm
                            text-[#8A5A44]
                        "
                    >

                        {{ ucfirst($activity->status) }}

                    </div>

                </div>

                <div
                    class="
                        text-sm
                        text-[#8A5A44]
                    "
                >

                    {{ $activity->updated_at->diffForHumans() }}

                </div>

            </div>

        @endforeach

    </div>

</div>