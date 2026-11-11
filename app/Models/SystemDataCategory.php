<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemDataCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function projects(){
        return $this->belongsToMany(DigitalHealthProject::class, 'digital_health_project_system_data_category');
    }
}
