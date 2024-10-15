<?php
namespace App\Services;

use App\Contracts\DepartmentServiceInterface;
use App\Models\Department;

class DepartmentService extends BaseService implements DepartmentServiceInterface
{
    public function __construct(Department $department)
    {
        parent::__construct($department);
    }
    
}
