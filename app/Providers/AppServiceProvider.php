<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //para validar cada pantalla dentro del sistema dependiendo el usuario
        Gate::define('solo-admin', function ($user) {
            return $user->esAdmin();
        });

        Gate::define('solo-recepcionista', function ($user) {
            return $user->esRecepcionista();
        });

        Gate::define('admin-o-recepcionista', function ($user) {
            return $user->esAdmin() || $user->esRecepcionista();
        });
    }
}
