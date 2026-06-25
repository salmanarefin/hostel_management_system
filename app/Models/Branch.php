<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}