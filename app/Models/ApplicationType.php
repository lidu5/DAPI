<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'eha_component_id',
    ];

    public function ehaComponent()
    {
        return $this->belongsTo(EhaComponent::class);
    }

    public function projects(){
        return $this->belongsToMany(DigitalHealthProject::class, 'digital_health_project_application_type');
    }
}
