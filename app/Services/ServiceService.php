<?php
namespace App\Services;

use App\Contracts\ServiceServiceInterface;
use App\Models\Service;

class ServiceService extends BaseService implements ServiceServiceInterface
{
    public function __construct(Service $service)
    {
        parent::__construct($service);
    }
    
}
