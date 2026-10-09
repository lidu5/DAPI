<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function projects(){
        return $this->belongsToMany(DigitalHealthProject::class, 'digital_health_project_coverage')
            ->withPivot('num_hw_users', 'num_hw_facilities', 'num_clients');
    }
}
