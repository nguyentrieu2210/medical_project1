<?php

namespace App\Http\Controllers\Api;

use App\Contracts\RoomCatalogueServiceInterface as RoomCatalogueService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomCatalogueRequest;
use App\Http\Requests\UpdateRoomCatalogueRequest;
use Illuminate\Http\Request;

class RoomCatalogueController extends Controller
{
    protected $roomCatalogueService;

    public function __construct(RoomCatalogueService $roomCatalogueService)
    {
        $this->roomCatalogueService = $roomCatalogueService;
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
        $roomCatalogues = $this->roomCatalogueService->paginate($this->getFields(), $condition, [], ['code'], $keyword, ['id', 'DESC'], $limit);
        if($roomCatalogues->count()) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 204;
            $statusText = "No Data";
        }
        $response = [
            'status' => $statusCode,
            'message' => $statusText,
            'data' => $roomCatalogues
        ];
        return $response;
    }

    public function show ($id) {
        $roomCatalogue = $this->roomCatalogueService->getById($id);
        if($roomCatalogue) {
            $statusCode = 200;
            $statusText = 'success';
        }else{
            $statusCode = 404;
            $statusText = 'Not Found';
        }
        $response = [
            'status' => $statusCode,
            'title' => $statusText,
            'data' => $roomCatalogue,
        ];
        return $response;
    }

    public function create(StoreRoomCatalogueRequest $request) {
        $payload = $request->all();
        $roomCatalogue = $this->roomCatalogueService->create($payload);
        if($roomCatalogue->id) {
            $status = 201;
            $message = 'created';
        }else{
            $status = 500;
            $message = 'server error';
        }
        return [
            'status' => $status,
            'message' => $message,
            'data' => $roomCatalogue
        ];
    }

    public function update (UpdateRoomCatalogueRequest $request, $id) {
        $payload = $request->all();
        $roomCatalogue = $this->roomCatalogueService->getById($id);
        if(!$roomCatalogue) {
            $response = [
                'status' => 404,
                'title' => 'Not Found'
            ];
        }else{
            $roomCatalogue = $this->roomCatalogueService->update($id, $payload);
            $response = [
                'status' => 200,
                'title' => 'success',
                'data' => $roomCatalogue
            ];
        }
        return $response;
    }

    public function delete ($id) {
        $flag = $this->roomCatalogueService->delete($id);
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
            'keyword',
            'name',
            'description',
            'status',
            'created_at',
            'updated_at'
        ];
    }
}
