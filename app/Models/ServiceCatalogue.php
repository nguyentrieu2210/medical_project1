<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCatalogue extends Model
{
    use HasFactory;

    protected $table = 'service_catalogues';

    protected $fillable = [
        'name',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];
}
