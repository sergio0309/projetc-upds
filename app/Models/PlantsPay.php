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

    public function serviceRecords()
    {
        return $this->belongsToMany(ServiceRecord::class, 'pays')
                    ->withPivot('pay', 'file', 'description', 'status')
                    ->withTimestamps();
    }
}
