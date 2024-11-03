<?php

namespace App\Http\Controllers\Api;

use App\Contracts\BedServiceInterface as BedService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBedRequest;
use App\Http\Requests\UpdateBedRequest;
use Illuminate\Http\Request;

class BedController extends Controller
{
    protected $bedService;

    public function __construct(BedService $bedService)
    {
        $this->bedService = $bedService;
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
        $beds = $this->bedService->paginate($this->getFields(), $condition, ['room', 'patient'], ['name', 'description'], $keyword, ['id', 'DESC'], $limit);
        if($beds->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $beds
        ];
        return $response;
    }

    public function show ($id) {
        $bed = $this->bedService->getById($id,[] , ['room', 'patient']);
        if($bed) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $bed,
        ];
        return $response;
    }

    public function create(StoreBedRequest $request) {
        $payload = $request->all();
        $bed = $this->bedService->create($payload);
        if($bed->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $bed
        ];
    }

    public function update (UpdateBedRequest $request, $id) {
        $payload = $request->all();
        $bed = $this->bedService->getById($id);
        if(!$bed) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $bed = $this->bedService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $bed
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->bedService->delete($id);
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
            'code',
            'price',
            'status',
            'room_id',
            'patient_id',
            'created_at',
            'updated_at'
        ];
    }
}
