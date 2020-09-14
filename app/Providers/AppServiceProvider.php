<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         *  Acá aplicamos el principio de Inversion de dependencias
         *
         *  Comunicamos el servicio [UserRepository] y el controlador por medio
         * de la interface [UserInterface]
         */
        $this->app->bind(
            'App\UseCase\UserInterface',
            'App\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\UseCase\VehicleInterface',
            'App\Repositories\VehicleRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
