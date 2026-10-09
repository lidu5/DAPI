<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OSIApprovedLicense extends Model
{
    use HasFactory;
    
    protected $table = 'o_s_i_approved_licenses';

    protected $fillable = [
        'name',
    ];

}
