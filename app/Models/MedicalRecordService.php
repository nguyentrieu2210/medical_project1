<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecordService extends Model
{
    use HasFactory;

    protected $table = 'medical_record_service';

    protected $fillable = [
        'patient_id',
        'service_id',
        'room_id',
        'medical_record_id',
        'service_name',
        'result_details',
        'apointment_date',
        'created_at',
        'updated_at',
    ];
}
