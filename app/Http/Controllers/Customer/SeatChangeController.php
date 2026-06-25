<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Seat;
use App\Models\SeatChangeRequest;
use Illuminate\Http\Request;

class SeatChangeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $requests = SeatChangeRequest::with([
                'currentBranch',
                'currentRoom',
                'currentSeat',
                'requestedBranch',
                'requestedRoom',
                'requestedSeat',
            ])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('customer.seat-change.index', compact('requests'));
    }

    public function create()
    {
        $user = auth()->user()->load(['branch', 'room', 'seat']);

        if (!$user->seat_id) {
            return redirect()
                ->route('customer.bookings.index')
                ->with('error', 'You do not have a booked seat yet. Please book a seat first.');
        }

        $branches = Branch::orderBy('name')->get();

        $availableSeats = Seat::with(['room.branch'])
            ->where('status', 'available')
            ->where('id', '!=', $user->seat_id)
            ->orderBy('room_id')
            ->orderBy('seat_number')
            ->get();

        return view('customer.seat-change.create', compact('user', 'branches', 'availableSeats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'requested_seat_id' => 'required|exists:seats,id',
            'remaining_days' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user()->load(['branch', 'room', 'seat']);

        if (!$user->seat_id) {
            return redirect()
                ->route('customer.bookings.index')
                ->with('error', 'You do not have a booked seat yet. Please book a seat first.');
        }

        $requestedSeat = Seat::with(['room.branch'])->findOrFail($request->requested_seat_id);

        if ($requestedSeat->status !== 'available') {
            return back()
                ->withInput()
                ->with('error', 'This seat is not available.');
        }

        if ($user->seat_id == $requestedSeat->id) {
            return back()
                ->withInput()
                ->with('error', 'You are already assigned to this seat.');
        }

        if (!$requestedSeat->room || !$requestedSeat->room->branch) {
            return back()
                ->withInput()
                ->with('error', 'Selected seat does not have valid room or branch information.');
        }

        $remainingDays = (int) $request->remaining_days;

        /*
            Business rule:
            rent_amount is treated as daily rent.
            Example:
            Current seat daily rent = 12000
            New seat daily rent = 8000
            Remaining days = 1
        */
        $currentDailyRent = $user->room ? $user->room->rent_amount : 0;
        $newDailyRent = $requestedSeat->room ? $requestedSeat->room->rent_amount : 0;

        $currentRemainingValue = $currentDailyRent * $remainingDays;
        $newSeatCostForRemainingDays = $newDailyRent * $remainingDays;

        $paymentDifference = $newSeatCostForRemainingDays - $currentRemainingValue;

        $unusedCredit = 0;
        $extraDays = 0;
        $minimumPayable = 0;
        $adjustmentNote = '';

        if ($paymentDifference > 0) {
            /*
                New seat is more expensive.
                Customer must pay extra.
                If payable amount is less than 100 BDT, minimum payable is 100 BDT.
            */
            $minimumPayable = $paymentDifference < 100 ? 100 : $paymentDifference;

            $adjustmentNote = 'New seat is more expensive. Customer must pay ' . number_format($minimumPayable, 2) . ' BDT. No refund policy applied.';
        } elseif ($paymentDifference < 0) {
            /*
                New seat is cheaper.
                No refund.
                Extra balance converts into extra days.
            */
            $unusedCredit = abs($paymentDifference);

            if ($newDailyRent > 0) {
                $extraDays = floor($unusedCredit / $newDailyRent);

                $remainingCreditAfterExtraDays = $unusedCredit - ($extraDays * $newDailyRent);

                $shortForNextDay = $newDailyRent - $remainingCreditAfterExtraDays;

                if ($extraDays == 0 && $shortForNextDay <= 100) {
                    $extraDays = 1;
                    $minimumPayable = $shortForNextDay;
                } elseif ($remainingCreditAfterExtraDays > 0 && $shortForNextDay <= 100) {
                    $extraDays = $extraDays + 1;
                    $minimumPayable = $shortForNextDay;
                }
            }

            if ($extraDays > 0 && $minimumPayable > 0) {
                $adjustmentNote = 'New seat is cheaper. No refund will be given. Extra balance converts to ' . $extraDays . ' extra day(s). Customer must pay additional ' . number_format($minimumPayable, 2) . ' BDT to complete the extra day.';
            } elseif ($extraDays > 0) {
                $adjustmentNote = 'New seat is cheaper. No refund will be given. Extra balance converts to ' . $extraDays . ' extra day(s).';
            } else {
                $adjustmentNote = 'New seat is cheaper, but extra balance is not enough for one full extra day. No refund will be given.';
            }
        } else {
            $adjustmentNote = 'Both seats have the same rent. No extra payment and no refund.';
        }

        SeatChangeRequest::create([
            'user_id' => $user->id,

            'current_branch_id' => $user->branch_id,
            'current_room_id' => $user->room_id,
            'current_seat_id' => $user->seat_id,

            'requested_branch_id' => $requestedSeat->room->branch_id,
            'requested_room_id' => $requestedSeat->room_id,
            'requested_seat_id' => $requestedSeat->id,

            'current_rent' => $currentDailyRent,
            'new_rent' => $newDailyRent,
            'payment_difference' => $paymentDifference,

            'remaining_days' => $remainingDays,
            'unused_credit' => $unusedCredit,
            'extra_days' => $extraDays,
            'minimum_payable' => $minimumPayable,
            'adjustment_note' => $adjustmentNote,

            'status' => 'pending',
            'reason' => $request->reason,
        ]);

        return redirect()
            ->route('customer.seat-change.index')
            ->with('success', 'Seat change request submitted successfully.');
    }
}