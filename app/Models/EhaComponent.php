<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EhaComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function applicationType()
    {
        return $this->hasMany(ApplicationType::class);
    }

    public function projects(){
        return $this->belongsToMany(DigitalHealthProject::class, 'digital_health_project_eha_component');
    }
}
