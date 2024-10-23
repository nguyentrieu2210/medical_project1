<?php

namespace App\Http\Controllers\Api;

use App\Contracts\DepartmentServiceInterface as DepartmentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use Illuminate\Http\Request;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\DepartmentCollection;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }
    //
    public function index (Request $request) {
        $keyword = $request->query('keyword');
        $status = $request->query('status');
        $limit = $request->query('limit') ?? 1;
        $condition = [];
        if(!is_null($status)) {
            $condition[] = ['status', '=', $status];
        }
        $departments = $this->departmentService->paginate($this->getFields(), $condition, [], ['name', 'description'], $keyword, ['id', 'DESC'], $limit);
        if($departments->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $departments
        ];
        return $response;
    }

    public function show ($id) {
        $department = $this->departmentService->getById($id);
        if($department) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $department,
        ];
        return $response;
    }

    public function create(StoreDepartmentRequest $request) {
        $request->validated();
        $payload = $request->all();
        $department = $this->departmentService->create($payload);
        if($department->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $department
        ];
    }

    public function update (StoreDepartmentRequest $request, $id) {
        $payload = $request->all();
        $department = $this->departmentService->getById($id);
        if(!$department) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $department = $this->departmentService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $department
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->departmentService->delete($id);
        if($flag) {
            $status = 204;
            $message = 'success';
        }else{
            $status = 404;
            $message = 'error';
        }
        return [
            'status' => $status,
            'message' => $message
        ];
    }

    private function getFields () {
        return [
            'id',
            'name',
            'description',
            'status',
            'created_at',
            'updated_at'
        ];
    }
}
