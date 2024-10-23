<?php

namespace App\Http\Controllers\Api;

use App\Contracts\MedicationServiceInterface as MedicationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicationRequest;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    protected $medicationService;

    public function __construct(MedicationService $medicationService)
    {
        $this->medicationService = $medicationService;
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
        $medications = $this->medicationService->paginate($this->getFields(), $condition, [], ['name', 'description'], $keyword, ['id', 'DESC'], $limit);
        if($medications->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $medications
        ];
        return $response;
    }

    public function show ($id) {
        $medication = $this->medicationService->getById($id);
        if($medication) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $medication,
        ];
        return $response;
    }

    public function create(StoreMedicationRequest $request) {
        $payload = $request->all();
        // return $payload;
        $medication = $this->medicationService->create($payload);
        if($medication->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $medication
        ];
    }

    public function update (StoreMedicationRequest $request, $id) {
        $payload = $request->all();
        $medication = $this->medicationService->getById($id);
        if(!$medication) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $medication = $this->medicationService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $medication
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->medicationService->delete($id);
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
            'medication_catalogue_id',
            'price',
            'measure',
            'measure_count',
            'description',
            'status',
            'created_at',
            'updated_at',
            'deleted_at'
        ];
    }
}
