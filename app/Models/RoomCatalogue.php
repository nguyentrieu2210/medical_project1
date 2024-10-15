<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomCatalogue extends Model
{
    use HasFactory;
    
    protected $table = 'room_catalogues';

    protected $fillable = [
        'keyword',
        'name',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];
}
