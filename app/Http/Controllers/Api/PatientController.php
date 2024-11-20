<?php

namespace App\Http\Controllers\Api;

use App\Contracts\PatientServiceInterface as PatientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
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
        $patients = $this->patientService->paginate($this->getFields(), $condition, [], ['name', 'description'], $keyword, ['id', 'DESC'], $limit);
        if($patients->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $patients
        ];
        return $response;
    }

    public function getHistory ($id) {
        $relations = [
            'medicalRecords' => ['services', 'user', 'medications'],
        ];
        $patient = $this->patientService->getHistory($id, $relations);
        if($patient) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $patient,
        ];
        return $response;
    }

    public function show ($id) {
        $patient = $this->patientService->getById($id);
        if($patient) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $patient,
        ];
        return $response;
    }

    public function create(StorePatientRequest $request) {
        $payload = $request->all();
        $patient = $this->patientService->create($payload);
        if($patient->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $patient
        ];
    }

    public function update (StorePatientRequest $request, $id) {
        $payload = $request->all();
        $patient = $this->patientService->getById($id);
        if(!$patient) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $patient = $this->patientService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $patient
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->patientService->delete($id);
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
            'birthday',
            'address',
            'phone',
            'cccd_number',
            'health_insurance_code',
            'guardian_phone',
            'gender',
            'description',
            'created_at',
            'updated_at'
        ];
    }
}
