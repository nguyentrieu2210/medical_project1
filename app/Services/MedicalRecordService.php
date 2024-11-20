<?php
namespace App\Services;

use App\Contracts\MedicalRecordServiceInterface;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\DB;

use function Illuminate\Events\queueable;

class MedicalRecordService extends BaseService implements MedicalRecordServiceInterface
{
    public function __construct(MedicalRecord $medicalRecord)
    {
        parent::__construct($medicalRecord);
    }

    public function getMedicalRecordList ($fieldSelects = ['*'], $conditions = [], $relations = [], $fieldSearch = [], $orderBy = ['updated_at', 'ASC'], $limit = 20, $isDiagnosis) {
        $query = $this->model->select($fieldSelects);
        if(!empty($conditions)) {
            foreach($conditions as $condition) {
                $query = $query->where($condition[0], $condition[1], $condition[2]);
            }
        }
        if(!empty($relations)) {
            foreach($relations as $key => $item) {
                if(empty($relations[$key])) {
                    $query->with($key);
                }else{
                    $query->with([$key => function($query) use ($key, $item, $fieldSearch) {
                        if($key == 'patient') {
                            $keyword = $item[0]['keyword'];
                            $query->where(function($query) use($keyword, $fieldSearch) {
                                foreach($fieldSearch as $field) {
                                    $query->orWhere($field, 'LIKE', '%'.$keyword.'%');
                                }
                            });
                        }else{
                            foreach($item as $val) {
                                $query->wherePivot($val[0], $val[1], $val[2]);
                            }
                        }
                    }]);
                }
            }
        }
        if(!$isDiagnosis) {
            $query->where(function ($query) {
                $query->whereRaw(
                    '(SELECT COUNT(*) 
                      FROM medical_record_service 
                      WHERE medical_record_service.medical_record_id = medical_records.id 
                        AND medical_record_service.result_details IS NOT NULL) = 
                     (SELECT COUNT(*) 
                      FROM medical_record_service 
                      WHERE medical_record_service.medical_record_id = medical_records.id)'
                );
            });
        }
        return $query->orderBy($orderBy[0], $orderBy[1])->paginate($limit);
    }

    public function save ($payload) {
        DB::beginTransaction();
        try {
            //Cập nhật bệnh án của bệnh nhân
            $this->model->where('id', $payload['medical_record']['medical_record_id'])->update($payload['medical_record']['data']);
            //Thêm các bản ghi để lưu lại thuốc đã kê cho bệnh án 
            $medicalRecord = $this->model->find($payload['medical_record']['medical_record_id']);
            $pivotData = [];
            foreach($payload['medications']['data'] as $item) {
                $pivotData[$item['medication_id']] = [
                    'name' => $item['name'],
                    'dosage' => $item['dosage'],
                    'measure' => $item['measure'],
                    'description' => $item['description']
                ];
            }
            $medicalRecord->medications()->attach($pivotData);
            // dd($this->model->with('medications')->with('services')->with('patient')->get()->toArray());
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }
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
                    'service_name' => $item['service_name'],
                    'room_id' => $payload['room_id']
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
