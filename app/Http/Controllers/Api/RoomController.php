<?php

namespace App\Http\Controllers\Api;

use App\Contracts\RoomServiceInterface as RoomService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
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
        $rooms = $this->roomService->paginate($this->getFields(), $condition, ['department', 'roomCatalogue', 'users'], ['name', 'description'], $keyword, ['id', 'DESC'], $limit, ['beds']);
        if($rooms->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $rooms
        ];
        return $response;
    }

    public function show ($id) {
        $room = $this->roomService->getById($id, ['beds'], ['users']);
        if($room) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $room,
        ];
        return $response;
    }

    public function create(StoreRoomRequest $request) {
        $payload = $request->all();
        $room = $this->roomService->create($payload);
        if($room->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $room
        ];
    }

    public function update (UpdateRoomRequest $request, $id) {
        $payload = $request->all();
        $room = $this->roomService->getById($id);
        if(!$room) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $room = $this->roomService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $room
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->roomService->delete($id);
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
            'code',
            'status',
            'room_catalogue_id',
            'department_id',
            'status_bed',
            'created_at',
            'updated_at'
        ];
    }
}
