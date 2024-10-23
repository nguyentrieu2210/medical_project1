<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserServiceInterface as UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
        $users = $this->userService->paginate($this->getFields(), $condition, ['department', 'position'], ['name', 'email', 'address', 'phone', 'cccd'], $keyword, ['id', 'DESC'], $limit);
        if($users->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $users
        ];
        return $response;
    }

    public function show ($id) {
        $user = $this->userService->getById($id);
        if($user) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $user,
        ];
        return $response;
    }

    public function create(StoreUserRequest $request) {
        $payload = $request->all();
        $user = $this->userService->create($payload);
        if($user->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $user
        ];
    }

    public function update (UpdateUserRequest $request, $id) {
        $payload = $request->all();
        $user = $this->userService->getById($id);
        if(!$user) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $user = $this->userService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $user
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->userService->delete($id);
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
            'email',
            'password',
            'address',
            'phone',
            'cccd',
            'gender',
            'status',
            'certificate',
            'position_id',
            'department_id',
            'created_at',
            'updated_at'
        ];
    }
}
