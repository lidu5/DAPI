<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationMetricsCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'weight',
    ];
    
    public function evaluation_metrics(){
        return $this->hasMany(EvaluationMetrics::class);
    }
}
