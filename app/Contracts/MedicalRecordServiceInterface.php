<?php

namespace App\Contracts;

interface MedicalRecordServiceInterface extends BaseServiceInterface
{
    public function createPivot($payload = []);
}
