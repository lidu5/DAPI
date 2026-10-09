<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthSystemChallenge extends Model
{
   
   use HasFactory;

  

    protected $fillable = [
        'name',
        'category',
    ];

    public function projects(){
        return $this->belongsToMany(DigitalHealthProject::class, 'digital_health_project_health_system_challenge');
    }
}
