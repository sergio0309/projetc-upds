<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start',
        'end',
        'client_id',
        'worker_id'
    ];

    // Relación con Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relación con Worker
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
