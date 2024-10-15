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
        //
        $this->registerServices();
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

    private function registerServices () {
        $bindings = [
            'App\Contracts\DepartmentServiceInterface' => 'App\Services\DepartmentService'
        ];
        foreach($bindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
