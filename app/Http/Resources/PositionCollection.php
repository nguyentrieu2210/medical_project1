<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PositionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    private $statusText;

    public function __construct($resource, $statusText = 'success')
    {
        parent::__construct($resource);
        $this->statusText = $statusText;
    }
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'status' => $this->statusText,
            'count' => $this->collection->count()
        ];
    }
}
