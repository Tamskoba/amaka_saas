<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\FunctionalSynthesisPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define(
            'functional-synthesis.viewAny',
            function (User $user) {
                return app(FunctionalSynthesisPolicy::class)
                    ->viewAny($user);
            }
        );

        Gate::define(
            'functional-synthesis.view',
            function (User $user, User $target) {
                return app(FunctionalSynthesisPolicy::class)
                    ->view($user, $target);
            }
        );

        Gate::define(
            'functional-synthesis.generate',
            function (User $user, User $target) {
                return app(FunctionalSynthesisPolicy::class)
                    ->generate($user, $target);
            }
        );
    }
}