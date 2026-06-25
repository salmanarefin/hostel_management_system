<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatChangeRequest extends Model
{
    protected $fillable = [
        'user_id',

        'current_branch_id',
        'current_room_id',
        'current_seat_id',

        'requested_branch_id',
        'requested_room_id',
        'requested_seat_id',

        'current_rent',
        'new_rent',
        'payment_difference',

        'remaining_days',
        'unused_credit',
        'extra_days',
        'minimum_payable',
        'adjustment_note',

        'status',
        'reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currentBranch()
    {
        return $this->belongsTo(Branch::class, 'current_branch_id');
    }

    public function currentRoom()
    {
        return $this->belongsTo(Room::class, 'current_room_id');
    }

    public function currentSeat()
    {
        return $this->belongsTo(Seat::class, 'current_seat_id');
    }

    public function requestedBranch()
    {
        return $this->belongsTo(Branch::class, 'requested_branch_id');
    }

    public function requestedRoom()
    {
        return $this->belongsTo(Room::class, 'requested_room_id');
    }

    public function requestedSeat()
    {
        return $this->belongsTo(Seat::class, 'requested_seat_id');
    }
}