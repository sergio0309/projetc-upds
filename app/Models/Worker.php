<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    /** @use HasFactory<\Database\Factories\WorkerFactory> */
    use HasFactory;

    protected $fillable = [
        'profession',
        'marital_status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
