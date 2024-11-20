<?php
namespace App\Services;

use App\Contracts\MedicationCatalogueServiceInterface;
use App\Models\MedicationCatalogue;
use Illuminate\Support\Facades\DB;

class MedicationCatalogueService extends BaseService implements MedicationCatalogueServiceInterface
{
    public function __construct(MedicationCatalogue $medicationCatalogue)
    {
        parent::__construct($medicationCatalogue);
    }
    
    
}
