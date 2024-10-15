<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\DepartmentResource;

class DepartmentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    private $statusText;
    private $statusCode;

    public function __construct($resource, $statusCode = 200, $statusText = 'success')
    {
        parent::__construct($resource);
        $this->statusText = $statusText;
        $this->statusCode = $statusCode;
    }
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'status' => $this->statusCode,
            'title' => $this->statusText,
            'count' => $this->collection->count()
        ];
    }
}
