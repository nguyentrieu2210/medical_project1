<?php
namespace App\Services;

use App\Contracts\ServiceCatalogueServiceInterface;
use App\Models\ServiceCatalogue;

class ServiceCatalogueService extends BaseService implements ServiceCatalogueServiceInterface
{
    public function __construct(ServiceCatalogue $serviceCatalogue)
    {
        parent::__construct($serviceCatalogue);
    }
    
}
