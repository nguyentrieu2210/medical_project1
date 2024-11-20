<?php

namespace App\Contracts;

interface MedicalRecordServiceServiceInterface extends BaseServiceInterface
{
    public function updateMultiple ($payload);
}
