<?php
namespace App\Services;

use App\Contracts\PositionServiceInterface;
use App\Models\Position;

class PositionService extends BaseService implements PositionServiceInterface
{
    public function __construct(Position $position)
    {
        parent::__construct($position);
    }
    
}
