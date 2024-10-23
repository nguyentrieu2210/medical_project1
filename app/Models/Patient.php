<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birthday',
        'address',
        'phone',
        'cccd_number',
        'health_insurance_code',
        'guardian_phone',
        'gender',
        'description',
        'created_at',
        'updated_at'
    ];

    public function bed () {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}
