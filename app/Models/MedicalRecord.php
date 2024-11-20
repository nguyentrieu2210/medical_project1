<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $table = 'medical_records';

    protected $fillable = [
        'patient_id',
        'user_id',
        'room_id',
        'visit_date',
        'diagnosis',
        'notes',
        'apointment_date',
        'is_inpatient',
        'inpatient_detail',
        'status'
    ];

    public function patient () {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function services() {
        return $this->belongsToMany(Service::class, 'medical_record_service', 'medical_record_id', 'service_id')->withPivot('service_name', 'result_details', 'room_id', 'patient_id', 'id')->withTimestamps();  
    }

    public function user () {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function medications () {
        return $this->belongsToMany(Medication::class, 'medical_record_medication', 'medical_record_id', 'medication_id')->withPivot('name', 'dosage', 'measure', 'description')->withTimestamps();  
    }
}
