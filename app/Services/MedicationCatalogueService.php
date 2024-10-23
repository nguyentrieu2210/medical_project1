<?php
namespace App\Services;

use App\Contracts\MedicationCatalogueServiceInterface;
use App\Models\MedicationCatalogue;
use Illuminate\Support\Facades\DB;

class MedicationCatalogueService extends BaseService implements MedicationCatalogueServiceInterface
{
    public function __construct(MedicationCatalogue $medicationCatalogue)
    {
        parent::__construct($medicationCatalogue);
    }

    public function create ($payload) {
        DB::beginTransaction();
        try {
            $parentId = $payload['parent_id'];
            unset($payload['parent_id']);
            if($parentId) {
                $parentNode = $this->model->find($parentId);
                $payload['level'] = $parentNode->level + 1;
                $object = new MedicationCatalogue($payload);
                $object->appendToNode($parentNode)->save();
            }else{
                $object = $this->model->create($payload);
            }
            DB::commit();
            return $object;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }
    }

    public function update($id, array $payload = [])
    {
        DB::beginTransaction();
        try {
            $parentId = $payload['parent_id'];
            unset($payload['parent_id']);
            $object = $this->model->find($id);
            $flag = false;
            if($object) {
                if($parentId) {
                    $parentNode = $this->model->find($parentId);
                    $object->appendToNode($parentNode)->save();
                    $payload['level'] = $parentNode->level + 1;
                }else{
                    $object->makeRoot()->save();
                    $payload['level'] = 0;
                }
                $flag = $object->update($payload);
            }
            if($flag) {
                $object = $this->model->find($id);
            }
            DB::commit();
            return $object;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }
    }
    
}
