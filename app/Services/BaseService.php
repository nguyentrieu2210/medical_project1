<?php

namespace App\Services;

use App\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseService implements BaseServiceInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function paginate ($fieldSelects = ['*'], $conditions = [], $relations = [], $fieldSearch = [], $keyword = '', $orderBy = ['id', 'DESC'], $limit = 20) {
        $query = $this->model->select($fieldSelects);
        if(!empty($relations)) {
            foreach($relations as $relation) {
                $query = $query->with($relation);
            }
        }
        if(!empty($conditions)) {
            foreach($conditions as $condition) {
                $query = $query->where($condition[0], $condition[1], $condition[2]);
            }
        }
        if(!empty($fieldSearch) && !is_null($keyword)) {
            $query = $query->where(function($query) use ($fieldSearch, $keyword) {
                foreach($fieldSearch as $field) {
                    $query->orWhere($field, 'LIKE', '%'.$keyword.'%');
                }
            });
        }
        return $query->orderBy($orderBy[0], $orderBy[1])->paginate($limit);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create ($payload) {
        DB::beginTransaction();
        try {
            $department = $this->model->create($payload);
            DB::commit();
            return $department;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }
    }

    public function update($id, array $payload = [])
    {
        DB::beginTransaction();
        try {
            $flag = $this->model->where('id', $id)->update($payload);
            if($flag) {
                $department = $this->model->find($id);
            }
            DB::commit();
            return $department;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $flag = $this->model->where('id', $id)->delete();
            DB::commit();
            return $flag;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }
    }
}