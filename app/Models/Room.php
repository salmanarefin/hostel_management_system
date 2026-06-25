<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'branch_id',
        'room_number',
        'capacity',
        'rent_amount',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}