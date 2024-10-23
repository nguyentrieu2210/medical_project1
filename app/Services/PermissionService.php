<?php
namespace App\Services;

use App\Contracts\PermissionServiceInterface;
use App\Models\Permission;

class PermissionService extends BaseService implements PermissionServiceInterface
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }
    
}
