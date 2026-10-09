<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalHealthIntervention extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'category',
    ];

    const TYPE_PERSON = 'PERSON';
    const TYPE_HEALTHCARE_PROVIDERS = 'HEALTHCARE PROVIDERS';
    const TYPE_HEALTH_MANAGEMENT_AND_SUPPORT_PERSONNEL = 'HEALTH MANAGEMENT AND SUPPORT PERSONNEL';
    const TYPE_DATA_SERVICES = 'DATA SERVICES';
}
