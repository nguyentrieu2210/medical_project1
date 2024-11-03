<?php

namespace App\Contracts;
use Illuminate\Http\Request;

interface BaseServiceInterface
{
    public function getAll();
    public function paginate($fieldSelects = ['*'], $conditions = [], $relations = [], $fieldSearch = [], $keyword = '', $orderBy = ['id', 'DESC'], $limit = 20, $count = []);
    public function getById($id, $count = [], $relations = []);
    public function create($payload);
    public function update($id, array $data);
    public function delete($id);
}
