<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Http\Resources\PositionResource;
use App\Http\Resources\PositionCollection;

class PositionController extends Controller
{
    //
    public function index (Request $request) {
        $where = [];
        if($request->name) {
            $where[] = ['name', 'LIKE', '%'.$request->name.'%'];
        }
        if($request->description) {
            $where[] = ['description', 'LIKE', '%'.$request->description.'%'];
        }
        $positions = Position::orderBy('id', 'DESC');
        if(!empty($where)) {
            $positions = $positions->where($where);
        }
        $positions = $positions->paginate();
        if($positions->count()) {
            $status = 'success';
        }else{
            $status = 'no_data';
        }
        $positions = new PositionCollection($positions, $status);
        // $response = [
        //     'status' => $status,
        //     'data' => $positions
        // ];
        return $positions;
    }

    public function detail ($id) {
        $position = Position::find($id);
        if(isset($position)) {
            $position = new PositionResource($position);
            $response = [
                'status' => 'success',
                'data' => $position
            ];
        }else{
            $response = [
                'status' => 'no_data'
            ];
        }
        return $response;
    }

    public function create(Request $request) {
        $this->validation($request);
        $position = Position::create($request->all());
        if($position->id) {
            $response = [
                'status' => 'success',
                'data' => $position
            ];
        }else{
            $response = [
                'status' => 'error'
            ];
        }
        return $response;
    }

    public function update (Request $request, $id) {
        $position = Position::find($id);
        if(!$position) {
            $response = [
                'status' => 'no_data'
            ];
        }else{
            $this->validation($request);
            $method = $request->method();
            if($method == 'PUT') {
                $position->name = $request->name;
                $position->description = $request->description;
                if(isset($request->status)) {
                    $position->status = $request->status;
                }else{
                    $position->status = $position->status;
                }
    
                
            }else{
                if(isset($request->name)) {
                    $position->name = $request->name;
                }
                if(isset($request->description)) {
                    $position->description = $request->description;
                }
                if(isset($request->status)) {
                    $position->status = $request->status;
                }
            }
    
            $position->save();
            
            $response = [
                'status' => 'success',
                'data' => $position
            ];
        }
        return $response;
    }

    public function delete (Position $position) {
        $status = Position::destroy($position->id);
        if($status) {
            $response = [
                'status' => 'success'
            ];
        }else{
            $response = [
                'status' => 'error'
            ];
        }
        return $response;
    }

    public function validation ($request) {
        // $emailValidation = 'required|email|unique:users';
        // if(!empty($id)) {
        //     $emailValidation .= ',email,'.$id;
        // }
        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name.required' => 'Tên bắt buộc phải nhập',
        ];
        $request->validate($rules, $messages);
    }
}
