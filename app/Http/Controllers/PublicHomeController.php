<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Seat;

class PublicHomeController extends Controller
{
    public function index()
    {
        $availableSeats = Seat::with(['room.branch'])
            ->where('status', 'available')
            ->latest()
            ->take(12)
            ->get();

        $offers = Announcement::latest()->take(5)->get();

        /*
            Slider needs at least 2 offers.
            If admin has less than 2 announcements,
            we will show default demo offers also.
        */
        if ($offers->count() < 2) {
            $offers = collect([
                (object) [
                    'title' => 'Welcome Offer',
                    'message' => 'Register now and explore available hostel seats easily with our digital management system.',
                ],
                (object) [
                    'title' => 'Special Discount',
                    'message' => 'Get special promotional seat offers from selected branches. Contact admin after registration.',
                ],
                (object) [
                    'title' => 'Easy Booking',
                    'message' => 'View available seats online and complete your booking request after login.',
                ],
                (object) [
                    'title' => 'No Refund Policy',
                    'message' => 'Unused paid amount is not refundable, but customers can request seat change according to company policy.',
                ],
            ]);
        }

        return view('welcome', compact('availableSeats', 'offers'));
    }
}