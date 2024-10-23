<?php
namespace App\Services;

use App\Contracts\RoomServiceInterface;
use App\Models\Room;

class RoomService extends BaseService implements RoomServiceInterface
{
    public function __construct(Room $room)
    {
        parent::__construct($room);
    }
    
}
