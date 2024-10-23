<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ServiceCatalogueServiceInterface as ServiceCatalogueService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceCatalogueRequest;
use Illuminate\Http\Request;

class ServiceCatalogueController extends Controller
{
    protected $serviceCatalogueService;

    public function __construct(ServiceCatalogueService $serviceCatalogueService)
    {
        $this->serviceCatalogueService = $serviceCatalogueService;
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
        $serviceCatalogues = $this->serviceCatalogueService->paginate($this->getFields(), $condition, [], ['name', 'description'], $keyword, ['id', 'DESC'], $limit);
        if($serviceCatalogues->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $serviceCatalogues
        ];
        return $response;
    }

    public function show ($id) {
        $serviceCatalogue = $this->serviceCatalogueService->getById($id);
        if($serviceCatalogue) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $serviceCatalogue,
        ];
        return $response;
    }

    public function create(StoreServiceCatalogueRequest $request) {
        $payload = $request->all();
        $serviceCatalogue = $this->serviceCatalogueService->create($payload);
        if($serviceCatalogue->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $serviceCatalogue
        ];
    }

    public function update (StoreServiceCatalogueRequest $request, $id) {
        $payload = $request->all();
        $serviceCatalogue = $this->serviceCatalogueService->getById($id);
        if(!$serviceCatalogue) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $serviceCatalogue = $this->serviceCatalogueService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $serviceCatalogue
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->serviceCatalogueService->delete($id);
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
