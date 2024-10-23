<?php
namespace App\Services;

use App\Contracts\RoomCatalogueServiceInterface;
use App\Models\RoomCatalogue;

class RoomCatalogueService extends BaseService implements RoomCatalogueServiceInterface
{
    public function __construct(RoomCatalogue $roomCatalogue)
    {
        parent::__construct($roomCatalogue);
    }
    
}
