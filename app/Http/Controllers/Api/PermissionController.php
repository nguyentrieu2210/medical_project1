<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PermissionServiceInterface as PermissionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
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
        $permissions = $this->permissionService->paginate($this->getFields(), $condition, [], ['name', 'description'], $keyword, ['id', 'DESC'], $limit);
        if($permissions->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $permissions
        ];
        return $response;
    }

    public function show ($id) {
        $permission = $this->permissionService->getById($id);
        if($permission) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $permission,
        ];
        return $response;
    }

    public function create(StorePermissionRequest $request) {
        $payload = $request->all();
        $permission = $this->permissionService->create($payload);
        if($permission->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $permission
        ];
    }

    public function update (UpdatePermissionRequest $request, $id) {
        $payload = $request->all();
        $permission = $this->permissionService->getById($id);
        if(!$permission) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $permission = $this->permissionService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $permission
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->permissionService->delete($id);
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
            'keyword',
            'created_at',
            'updated_at'
        ];
    }
}
