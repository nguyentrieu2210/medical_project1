<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function updateStatus (Request $request) {
        $modelName = $request->input('model');
        $model = app("App\\Models\\$modelName");
        $flag = $model->where('id', $request->input('id'))->update(['status' => $request->input('status')]);
        if($flag) {
            $response = [
                'status' => 200,
                'message' => 'Cập nhật thành công',
                'data' => $model->find($request->input('id'))
            ];
        }else{
            $response = [
                'status' => 404,
                'message' => 'Cập nhật không thành công'
            ];
        }
        return $response;
    }
}
