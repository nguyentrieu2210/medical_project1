<?php
namespace App\Services;

use App\Contracts\MedicationServiceInterface;
use App\Models\Medication;

class MedicationService extends BaseService implements MedicationServiceInterface
{
    public function __construct(Medication $medication)
    {
        parent::__construct($medication);
    }
    
}
