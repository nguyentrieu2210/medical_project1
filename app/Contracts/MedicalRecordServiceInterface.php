<?php

namespace App\Contracts;

interface MedicalRecordServiceInterface extends BaseServiceInterface
{
    public function createPivot($payload = []);
    public function getMedicalRecordList ($fieldSelects = ['*'], $conditions = [], $relations = [], $fieldSearch = [], $orderBy = ['updated_at', 'ASC'], $limit = 20, $isDiagnosis);
    public function save ($payload);
}
