<?php

namespace App\Http\Controllers\Api;

use App\Contracts\MedicalRecordServiceInterface as MedicalRecordService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    protected $medicalRecordService;

    public function __construct(MedicalRecordService $medicalRecordService)
    {
        $this->medicalRecordService = $medicalRecordService;
    }

    //Bệnh nhân chờ khám
    public function index (Request $request) {
        $keyword = $request->query('keyword');
        $status = $request->query('status');
        $limit = $request->query('limit') ?? 1;
        $roomId = $request->query('room_id');
        $condition = [];
        if(!is_null($status)) {
            $condition[] = ['status', '=', $status];
        }
        if(!is_null($roomId)) {
            $condition[] = ['room_id', '=', $roomId];
        }
        $medicalRecords = $this->medicalRecordService->paginate($this->getFields(), $condition, ['patient', 'services'], [], $keyword, ['visit_date', 'ASC'], $limit);
        if($medicalRecords->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $medicalRecords
        ];
        return $response;
    }

    //Bệnh nhân chờ kết luận 
    public function getPatientWaitDiagnosis (Request $request) {
        return $this->getMedicalRecordList($request, $status = 0);
    }

    //bệnh nhân chờ thực hiện các dịch vụ
    public function getPatientWaitTest (Request $request) {
        return $this->getMedicalRecordList($request);
    }

    public function getMedicalRecordList ($request, $status = 1) {
        $id = $request->query('id');
        $keyword = $request->query('keyword');
        $limit = $request->query('limit') ?? 1;
        $roomId = $request->query('room_id');
        if(!is_null($id)) {
            $conditions[] = ['id', '=', $id];
        }
        $conditions[] = ['diagnosis', '=', null];
        $conditions[] = ['status', '=', 1];
        if(!$status) {
            $conditions[] = ['room_id', '=', $roomId];
        }
        $relations = [];
        $relations['user'] = [];
        $relations['patient'][] = [
            'keyword' => !is_null($keyword) ? $keyword : ''
        ];
        if($status) {
            $relations['services'][] = ['result_details', '=', null];
            $relations['services'][] = ['room_id', '=', $roomId];
        }else{
            $relations['services'][] = ['result_details', '<>', null];
        }
        $medicalRecords = $this->medicalRecordService->getMedicalRecordList($this->getFields(), $conditions, $relations, ['name', 'cccd_number'], ['updated_at', 'ASC'], $limit, $status);
        $data = $medicalRecords;
        if(!is_null($id)) {
            $data = $data[0];
        }
        if($medicalRecords->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $data
        ];
        return $response;
    }

    public function show ($id) {
        $medicalRecord = $this->medicalRecordService->getById($id);
        if($medicalRecord) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $medicalRecord,
        ];
        return $response;
    }

    public function create(Request $request) {
        $payload = $request->all();
        $medicalRecord = $this->medicalRecordService->create($payload);
        if($medicalRecord->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $medicalRecord
        ];
    }

    public function createPivot (Request $request) {
        $payload = $request->all();
        $flag = $this->medicalRecordService->createPivot($payload);
        return [
            'status' => $flag ? 201 : 500,
            'message' => $flag ? 'created' : 'server error'
        ];
    }

    //bác sĩ phòng khám xử lý xong 1 bệnh nhân từ a-z
    public function save (Request $request) {
        $payload = $request->all();
        $flag = $this->medicalRecordService->save($payload);
        return [
            'status' => $flag ? 201 : 500,
            'message' => $flag ? 'created' : 'server error'
        ];
    }

    public function update (Request $request, $id) {
        $payload = $request->all();
        $medicalRecord = $this->medicalRecordService->getById($id);
        if(!$medicalRecord) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $medicalRecord = $this->medicalRecordService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $medicalRecord
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->medicalRecordService->delete($id);
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
            'patient_id',
            'user_id',
            'room_id',
            'visit_date',
            'diagnosis',
            'notes',
            'apointment_date',
            'is_inpatient',
            'inpatient_detail',
            'status'
        ];
    }
}
