<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index()
    {
        $seats = Seat::with('room.branch')->latest()->paginate(10);

        return view('admin.seats.index', compact('seats'));
    }

    public function create()
    {
        $rooms = Room::with('branch')->orderBy('room_number')->get();

        return view('admin.seats.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'seat_number' => 'required|string|max:100',
            'status' => 'required|in:available,booked',
        ]);

        Seat::create([
            'room_id' => $request->room_id,
            'seat_number' => $request->seat_number,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.seats.index')
            ->with('success', 'Seat created successfully.');
    }

    public function show(Seat $seat)
    {
        return redirect()->route('admin.seats.index');
    }

    public function edit(Seat $seat)
    {
        $rooms = Room::with('branch')->orderBy('room_number')->get();

        return view('admin.seats.edit', compact('seat', 'rooms'));
    }

    public function update(Request $request, Seat $seat)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'seat_number' => 'required|string|max:100',
            'status' => 'required|in:available,booked',
        ]);

        $seat->update([
            'room_id' => $request->room_id,
            'seat_number' => $request->seat_number,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.seats.index')
            ->with('success', 'Seat updated successfully.');
    }

    public function destroy(Seat $seat)
    {
        $seat->delete();

        return redirect()
            ->route('admin.seats.index')
            ->with('success', 'Seat deleted successfully.');
    }
}