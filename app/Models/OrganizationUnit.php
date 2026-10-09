<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
    ];

    public function projects(){
        return $this->hasMany(DigitalHealthProject::class);
    }

    public function digitalHealthProjects()
    {
        return $this->belongsToMany(DigitalHealthProject::class, 'digital_health_project_partner', 'organization_unit_id', 'digital_health_project_id');
    }
}
