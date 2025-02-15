<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales',
        'discounts',
        'purchases',
        'recorded_purchases',
        'previous_balance',
        'update',
        'current_balance',
        'calculated_IVA',
        'real_IVA',
        'comp_IUE',
        'calculated_IT',
        'real_IT',
        'IUE',
    ];

    // Relación con el modelo Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relación con el modelo Worker
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
