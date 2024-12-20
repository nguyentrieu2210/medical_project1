<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PositionServiceInterface as PositionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    protected $positionService;

    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
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
        $positions = $this->positionService->paginate($this->getFields(), $condition, [], ['name', 'description'], $keyword, ['id', 'DESC'], $limit);
        if($positions->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $positions
        ];
        return $response;
    }

    public function show ($id) {
        $position = $this->positionService->getById($id);
        if($position) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $position,
        ];
        return $response;
    }

    public function create(StorePositionRequest $request) {
        $payload = $request->all();
        $position = $this->positionService->create($payload);
        if($position->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $position
        ];
    }

    public function update (StorePositionRequest $request, $id) {
        $payload = $request->all();
        $position = $this->positionService->getById($id);
        if(!$position) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $position = $this->positionService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $position
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->positionService->delete($id);
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
