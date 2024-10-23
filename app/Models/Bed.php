<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'price',
        'status',
        'room_id',
        'patient_id',
        'created_at',
        'updated_at'
    ];

    public function room () {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function patient () {
        return $this->hasOne(Patient::class, 'patient_id', 'id');
    }
}
