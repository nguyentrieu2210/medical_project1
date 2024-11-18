<?php
namespace App\Services;

use App\Contracts\MedicalRecordServiceInterface;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\DB;

class MedicalRecordService extends BaseService implements MedicalRecordServiceInterface
{
    public function __construct(MedicalRecord $medicalRecord)
    {
        parent::__construct($medicalRecord);
    }

    public function create ($payload) {
        DB::beginTransaction();
        try {
            $payload['visit_date'] = now();
            $object = $this->model->create($payload);
            DB::commit();
            return $object;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }
    }

    public function createPivot ($payload = []) {
        DB::beginTransaction();
        try {
            $pivotData = [];
            foreach($payload['services'] as $item) {
                $pivotData[$item['service_id']] = [
                    'service_name' => $item['service_name']
                ];
            }
            $medicalRecord = $this->model->find($payload['medical_record_id']);
            if($medicalRecord) {
                $medicalRecord->services()->attach($pivotData);
                $medicalRecord->status = 1;
                $medicalRecord->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return false;
        }
    }
    
}
