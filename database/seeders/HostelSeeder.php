<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Branch;
use App\Models\Rent;
use App\Models\Room;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HostelSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@younic.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '01700000000',
            'nid' => '1234567890',
            'deposit_amount' => 0,
            'balance' => 0,
        ]);

        // Branches
        $branchA = Branch::create([
            'name' => 'Branch A',
            'address' => 'Banani, Dhaka',
            'phone' => '01811111111',
        ]);

        $branchB = Branch::create([
            'name' => 'Branch B',
            'address' => 'Uttara, Dhaka',
            'phone' => '01822222222',
        ]);

        // Rooms
        $roomA101 = Room::create([
            'branch_id' => $branchA->id,
            'room_number' => 'A-101',
            'capacity' => 2,
            'rent_amount' => 10000,
        ]);

        $roomA102 = Room::create([
            'branch_id' => $branchA->id,
            'room_number' => 'A-102',
            'capacity' => 3,
            'rent_amount' => 8000,
        ]);

        $roomB201 = Room::create([
            'branch_id' => $branchB->id,
            'room_number' => 'B-201',
            'capacity' => 2,
            'rent_amount' => 12000,
        ]);

        $roomB202 = Room::create([
            'branch_id' => $branchB->id,
            'room_number' => 'B-202',
            'capacity' => 3,
            'rent_amount' => 9000,
        ]);

        // Seats
        $seatA1011 = Seat::create([
            'room_id' => $roomA101->id,
            'seat_number' => 'A-101-S1',
            'status' => 'booked',
        ]);

        Seat::create([
            'room_id' => $roomA101->id,
            'seat_number' => 'A-101-S2',
            'status' => 'available',
        ]);

        Seat::create([
            'room_id' => $roomA102->id,
            'seat_number' => 'A-102-S1',
            'status' => 'available',
        ]);

        Seat::create([
            'room_id' => $roomA102->id,
            'seat_number' => 'A-102-S2',
            'status' => 'available',
        ]);

        Seat::create([
            'room_id' => $roomA102->id,
            'seat_number' => 'A-102-S3',
            'status' => 'available',
        ]);

        Seat::create([
            'room_id' => $roomB201->id,
            'seat_number' => 'B-201-S1',
            'status' => 'available',
        ]);

        Seat::create([
            'room_id' => $roomB201->id,
            'seat_number' => 'B-201-S2',
            'status' => 'available',
        ]);

        Seat::create([
            'room_id' => $roomB202->id,
            'seat_number' => 'B-202-S1',
            'status' => 'available',
        ]);

        Seat::create([
            'room_id' => $roomB202->id,
            'seat_number' => 'B-202-S2',
            'status' => 'available',
        ]);

        Seat::create([
            'room_id' => $roomB202->id,
            'seat_number' => 'B-202-S3',
            'status' => 'available',
        ]);

        // Customer User
        $customer = User::create([
            'name' => 'Customer',
            'email' => 'customer@younic.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '01900000000',
            'nid' => '9876543210',
            'branch_id' => $branchA->id,
            'room_id' => $roomA101->id,
            'seat_id' => $seatA1011->id,
            'deposit_amount' => 5000,
            'balance' => 0,
        ]);

        // Sample Rent
        Rent::create([
            'user_id' => $customer->id,
            'month' => now()->format('F Y'),
            'amount' => $roomA101->rent_amount,
            'due_date' => now()->addDays(7)->toDateString(),
            'status' => 'due',
        ]);

        // Announcement
        Announcement::create([
            'title' => 'Welcome to Younic Home',
            'message' => 'Please pay your monthly rent before the due date.',
        ]);
    }
}