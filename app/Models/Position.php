<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
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
}
