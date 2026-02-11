<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone'];

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function location()
    {
        return $this->hasOne(DriverLocation::class);
    }
}
