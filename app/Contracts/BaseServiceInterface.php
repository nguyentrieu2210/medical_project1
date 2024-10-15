<?php

namespace App\Contracts;

interface BaseServiceInterface
{
    public function getAll();
    public function paginate($fieldSelects = ['*'], $conditions = [], $relations = [], $fieldSearch = [], $keyword = '', $orderBy = ['id', 'DESC'], $limit = 20);
    public function getById($id);
    public function create($payload);
    public function update($id, array $data);
    public function delete($id);
}
