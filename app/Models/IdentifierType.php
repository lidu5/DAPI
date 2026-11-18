<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentifierType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function projects(){
        return $this->hasMany(DigitalHealthProject::class, 'identifier_type_id');
    }
}
