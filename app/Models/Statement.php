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
    public function serviceRecord()
    {
        return $this->hasOne(ServiceRecord::class, 'statement_id');  // Asumiendo que 'statement_id' es la clave foránea
    }
}
