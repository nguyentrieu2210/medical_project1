<?php

namespace App\Http\Controllers\Api;

use App\Contracts\MedicalRecordServiceServiceInterface as MedicalRecordServiceService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicalRecordServiceController extends Controller
{
    protected $medicalRecordServiceService;

    public function __construct(MedicalRecordServiceService $medicalRecordServiceService)
    {
        $this->medicalRecordServiceService = $medicalRecordServiceService;
    }
    //
    public function update (Request $request) {
        $payload = $request->all();
        $flag = $this->medicalRecordServiceService->updateMultiple($payload);
        if(!$flag) {
            $response = [
                'status' => 500,
                'title' => 'server error'
            ];
        }else{
            $response = [
                'status' => 200,
                'title' => 'success',
            ];
        }
        return $response;
    }

    private function getFields () {
        return [
            'patient_id',
            'service_id',
            'room_id',
            'medical_record_id',
            'service_name',
            'result_details',
            'apointment_date',
            'created_at',
            'updated_at',
        ];
    }
}
