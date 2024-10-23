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
            'App\Contracts\BaseServiceInterface' => 'App\Services\BaseService',
            'App\Contracts\DepartmentServiceInterface' => 'App\Services\DepartmentService',
            'App\Contracts\PositionServiceInterface' => 'App\Services\PositionService',
            'App\Contracts\UserServiceInterface' => 'App\Services\UserService',
            'App\Contracts\RoomCatalogueServiceInterface' => 'App\Services\RoomCatalogueService',
            'App\Contracts\RoomServiceInterface' => 'App\Services\RoomService',
            'App\Contracts\PatientServiceInterface' => 'App\Services\PatientService',
            'App\Contracts\BedServiceInterface' => 'App\Services\BedService',
            'App\Contracts\ServiceCatalogueServiceInterface' => 'App\Services\ServiceCatalogueService',
            'App\Contracts\ServiceServiceInterface' => 'App\Services\ServiceService',
            'App\Contracts\PermissionServiceInterface' => 'App\Services\PermissionService',
            'App\Contracts\MedicationCatalogueServiceInterface' => 'App\Services\MedicationCatalogueService',
            'App\Contracts\MedicationServiceInterface' => 'App\Services\MedicationService',
        ];
        foreach($bindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
