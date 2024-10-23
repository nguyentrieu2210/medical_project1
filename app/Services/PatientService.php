<?php
namespace App\Services;

use App\Contracts\PatientServiceInterface;
use App\Models\Patient;

class PatientService extends BaseService implements PatientServiceInterface
{
    public function __construct(Patient $patient)
    {
        parent::__construct($patient);
    }
    
}
