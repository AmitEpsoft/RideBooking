<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'passenger_id',
        'driver_id',
        'pickup_lat',
        'pickup_lng',
        'destination_lat',
        'destination_lng',
        'status',
        'approved_at',
        'passenger_completed_at',
        'driver_completed_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'passenger_completed_at' => 'datetime',
        'driver_completed_at' => 'datetime',
    ];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function driverRequests()
    {
        return $this->hasMany(RideDriverRequest::class);
    }

    public function isFullyCompleted(): bool
    {
        return !is_null($this->passenger_completed_at) && !is_null($this->driver_completed_at);
    }
}
