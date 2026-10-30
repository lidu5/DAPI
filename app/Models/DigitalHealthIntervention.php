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

    const TYPE_PERSON = 'Digital system';
    const TYPE_HEALTHCARE_PROVIDERS = 'Data service';
    const TYPE_HEALTH_MANAGEMENT_AND_SUPPORT_PERSONNEL = 'Delivery channel';
    const TYPE_DATA_SERVICES = 'Equipment';
    const TYPE_PROGRAMME = 'Programme';
}
