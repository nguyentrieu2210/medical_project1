<?php

namespace App\Http\Controllers\Api;

use App\Contracts\MedicationCatalogueServiceInterface as MedicationCatalogueService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicationCatalogueRequest;
use Illuminate\Http\Request;

class MedicationCatalogueController extends Controller
{
    protected $medicationCatalogueService;

    public function __construct(MedicationCatalogueService $medicationCatalogueService)
    {
        $this->medicationCatalogueService = $medicationCatalogueService;
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
        $medicationCatalogues = $this->medicationCatalogueService->paginate($this->getFields(), $condition, [], ['name', 'description'], $keyword, ['_lft', 'ASC'], $limit);
        if($medicationCatalogues->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $medicationCatalogues
        ];
        return $response;
    }

    public function show ($id) {
        $medicationCatalogue = $this->medicationCatalogueService->getById($id);
        if($medicationCatalogue) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $medicationCatalogue,
        ];
        return $response;
    }

    public function create(StoreMedicationCatalogueRequest $request) {
        $payload = $request->all();
        $medicationCatalogue = $this->medicationCatalogueService->create($payload);
        if($medicationCatalogue->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $medicationCatalogue
        ];
    }

    public function update (StoreMedicationCatalogueRequest $request, $id) {
        $payload = $request->all();
        $medicationCatalogue = $this->medicationCatalogueService->getById($id);
        if(!$medicationCatalogue) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $medicationCatalogue = $this->medicationCatalogueService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $medicationCatalogue
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->medicationCatalogueService->delete($id);
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
            'level',
            'parent_id',
            '_lft',
            '_rgt',
            'created_at',
            'updated_at',
            'deleted_at'
        ];
    }
}
