<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class MedicationCatalogue extends Model
{
    use HasFactory, SoftDeletes, NodeTrait;

    protected $fillable = [
        'name',
        'description',
        'status',
        'level',
        'parent_id',
        '_lft',
        '_rgt',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
