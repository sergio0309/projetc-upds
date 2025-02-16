<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantsPay extends Model
{
    protected $fillable = [
        'name',
        'image',
        'status',
    ];
}
