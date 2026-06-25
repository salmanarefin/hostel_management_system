<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('branch')->latest()->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $branches = Branch::orderBy('name')->get();

        return view('admin.rooms.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'room_number' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'rent_amount' => 'required|numeric|min:0',
        ]);

        Room::create([
            'branch_id' => $request->branch_id,
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
            'rent_amount' => $request->rent_amount,
        ]);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        return redirect()->route('admin.rooms.index');
    }

    public function edit(Room $room)
    {
        $branches = Branch::orderBy('name')->get();

        return view('admin.rooms.edit', compact('room', 'branches'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'room_number' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'rent_amount' => 'required|numeric|min:0',
        ]);

        $room->update([
            'branch_id' => $request->branch_id,
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
            'rent_amount' => $request->rent_amount,
        ]);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}