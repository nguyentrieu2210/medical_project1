<?php
namespace App\Services;

use App\Contracts\BedServiceInterface;
use App\Models\Bed;

class BedService extends BaseService implements BedServiceInterface
{
    public function __construct(Bed $bed)
    {
        parent::__construct($bed);
    }
    
}
