<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ServiceServiceInterface as ServiceService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
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
        $services = $this->serviceService->paginate($this->getFields(), $condition, [], ['name', 'description'], $keyword, ['id', 'DESC'], $limit);
        if($services->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $services
        ];
        return $response;
    }

    public function show ($id) {
        $service = $this->serviceService->getById($id);
        if($service) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $service,
        ];
        return $response;
    }

    public function create(StoreServiceRequest $request) {
        $payload = $request->all();
        $service = $this->serviceService->create($payload);
        if($service->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $service
        ];
    }

    public function update (StoreServiceRequest $request, $id) {
        $payload = $request->all();
        $service = $this->serviceService->getById($id);
        if(!$service) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $service = $this->serviceService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $service
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->serviceService->delete($id);
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
            'price',
            'service_catalogue_id',
            'detail',
            'health_insurance_applied',
            'health_insurance_value',
            'status',
            'room_catalogue_id',
            'created_at',
            'updated_at'
        ];
    }
}
