<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bed;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'status',
        'room_catalogue_id',
        'department_id',
        'status_bed',
        'created_at',
        'updated_at'
    ];

    public function department () {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function roomCatalogue () {
        return $this->belongsTo(RoomCatalogue::class, 'room_catalogue_id', 'id');
    }

    public function beds () {
        return $this->hasMany(Bed::class, 'room_id', 'id');
    }
}
