<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationMetrics extends Model
{
    use HasFactory;

    protected $fillable = [
        'elements',
        'weight',
        'evaluation_metrics_category_id',
    ];
    
    public function projects(){
        return $this->belongsToMany(DigitalHealthProject::class, 'digital_health_projects_evaluations')
        ->withPivot('score');
    }

    public function category()
    {
        return $this->belongsTo(EvaluationMetricsCategory::class, 'evaluation_metrics_category_id');
    }
}
