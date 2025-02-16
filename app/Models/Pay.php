<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    protected $fillable = ['service_record_id', 'plant_pay_id', 'pay', 'file', 'description', 'status'];

    public function serviceRecord()
    {
        return $this->belongsTo(ServiceRecord::class, 'service_record_id');
    }

    public function plantPay()
    {
        return $this->belongsTo(PlantsPay::class);
    }
}
