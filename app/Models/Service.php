<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'service_catalogue_id',
        'detail',
        'health_insurance_applied',
        'health_insurance_value',
        'status',
        'room_catalogue_id',
        'created_at',
        'updated_at'
    ];

    public function serviceCatalogue () {
        return $this->belongsTo(ServiceCatalogue::class, 'service_catalogue_id', 'id');
    }

    public function roomCatalogue() {
        return $this->belongsTo(RoomCatalogue::class, 'room_catalogue_id', 'id');
    }
}
