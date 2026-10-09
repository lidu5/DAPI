<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'digital_health_project_id'
    ];

    public function interventions(){
        return $this->belongsToMany(DigitalHealthIntervention::class, 'software_digital_health_intervention');
    }
}
