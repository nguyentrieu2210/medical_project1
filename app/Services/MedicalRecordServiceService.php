<?php
namespace App\Services;

use App\Contracts\MedicalRecordServiceServiceInterface;
use App\Models\MedicalRecordService;
use Illuminate\Support\Facades\DB;

class MedicalRecordServiceService extends BaseService implements MedicalRecordServiceServiceInterface
{
    public function __construct(MedicalRecordService $medicalRecordService)
    {
        parent::__construct($medicalRecordService);
    }
    
    public function updateMultiple ($payload) {
        DB::beginTransaction();
        try {
            foreach($payload as $item) {
                $this->model->where('id', $item['id'])->update(['result_details' => $item['result_details']]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }
    }
}
