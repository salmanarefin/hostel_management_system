<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Seat
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('admin.seats.update', $seat) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Room</label>
                        <select name="room_id" class="w-full border-gray-300 rounded" required>
                            <option value="">Select Room</option>

                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" @selected(old('room_id', $seat->room_id) == $room->id)>
                                    {{ $room->branch->name ?? 'N/A' }} - {{ $room->room_number }}
                                </option>
                            @endforeach
                        </select>

                        @error('room_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Seat Number</label>
                        <input type="text"
                               name="seat_number"
                               value="{{ old('seat_number', $seat->seat_number) }}"
                               class="w-full border-gray-300 rounded"
                               required>

                        @error('seat_number')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded" required>
                            <option value="available" @selected(old('status', $seat->status) === 'available')>
                                Available
                            </option>
                            <option value="booked" @selected(old('status', $seat->status) === 'booked')>
                                Booked
                            </option>
                        </select>

                        @error('status')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Update
                        </button>

                        <a href="{{ route('admin.seats.index') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded">
                            Back
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>