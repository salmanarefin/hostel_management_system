<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ExitRequest;
use App\Models\Rent;
use Illuminate\Http\Request;

class ExitController extends Controller
{
    public function index()
    {
        $exits = ExitRequest::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.exits.index', compact('exits'));
    }

    public function create()
    {
        $user = auth()->user();

        $dueAmount = Rent::where('user_id', $user->id)
            ->where('status', 'due')
            ->sum('amount');

        $depositAmount = $user->deposit_amount ?? 0;

        /*
            Company policy:
            No refund.
            If deposit is higher than due, final payable is 0.
            Remaining deposit/unused balance is not refundable.
        */
        $calculation = $dueAmount - $depositAmount;

        if ($calculation > 0) {
            $finalType = 'payable';
            $finalAmount = $calculation;
        } else {
            $finalType = 'no_due';
            $finalAmount = 0;
        }

        return view('customer.exits.create', compact(
            'dueAmount',
            'depositAmount',
            'finalType',
            'finalAmount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exit_date' => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        $dueAmount = Rent::where('user_id', $user->id)
            ->where('status', 'due')
            ->sum('amount');

        $depositAmount = $user->deposit_amount ?? 0;

        $calculation = $dueAmount - $depositAmount;

        if ($calculation > 0) {
            $finalType = 'payable';
            $finalAmount = $calculation;
        } else {
            $finalType = 'no_due';
            $finalAmount = 0;
        }

        ExitRequest::create([
            'user_id' => $user->id,
            'exit_date' => $request->exit_date,
            'reason' => $request->reason,
            'due_amount' => $dueAmount,
            'deposit_amount' => $depositAmount,
            'final_amount' => $finalAmount,
            'final_type' => $finalType,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('customer.exits.index')
            ->with('success', 'Exit request submitted successfully. No refund policy applied.');
    }
}