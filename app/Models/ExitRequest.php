<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExitRequest extends Model
{
    protected $fillable = [
        'user_id',
        'exit_date',
        'reason',
        'due_amount',
        'deposit_amount',
        'final_amount',
        'final_type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}