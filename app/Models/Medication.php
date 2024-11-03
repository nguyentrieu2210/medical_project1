<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'medication_catalogue_id',
        'price',
        'measure',
        'measure_count',
        'description',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function medicationCatalogue () {
        return $this->belongsTo(MedicationCatalogue::class, 'medication_catalogue_id', 'id');
    }
}
