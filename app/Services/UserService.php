<?php
namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService implements UserServiceInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function create ($payload) {
        DB::beginTransaction();
        try {
            $roomIds = $payload['room_ids'];
            unset($payload['room_ids']);
            $user = $this->model->create($payload);
            $user->rooms()->attach($roomIds);
            DB::commit();
            return $user;
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
            $roomIds = $payload['room_ids'];
            unset($payload['room_ids']);
            $flag = $this->model->where('id', $id)->update($payload);
            if($flag) {
                $object = $this->model->find($id);
                $object->rooms()->sync($roomIds);
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
