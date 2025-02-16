<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    protected $fillable = [
        'date',
        'amount',
        'paid',
        'status_debt',
        'status',
        'description',
        'type_service_id',
        'statement_id',
        'client_id',
        'worker_id'
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

    // Relación con el modelo Worker
    public function statement()
    {
        return $this->belongsTo(Statement::class);
    }

    // Relación con el modelo Worker
    public function type_service()
    {
        return $this->belongsTo(TypeService::class, 'type_service_id');
    }

    public function plantsPays()
    {
        return $this->belongsToMany(PlantsPay::class, 'pays', 'service_record_id', 'plant_pay_id')
                ->withPivot('pay', 'file', 'description', 'status')
                ->withTimestamps();
    }
}
