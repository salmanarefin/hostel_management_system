<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Room
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('admin.rooms.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Branch</label>
                        <select name="branch_id" class="w-full border-gray-300 rounded" required>
                            <option value="">Select Branch</option>

                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" @selected(old('branch_id') == $branch->id)>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('branch_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Room Number</label>
                        <input type="text"
                               name="room_number"
                               value="{{ old('room_number') }}"
                               class="w-full border-gray-300 rounded"
                               required>

                        @error('room_number')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Capacity</label>
                        <input type="number"
                               name="capacity"
                               value="{{ old('capacity') }}"
                               class="w-full border-gray-300 rounded"
                               min="1"
                               required>

                        @error('capacity')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Rent Amount</label>
                        <input type="number"
                               name="rent_amount"
                               value="{{ old('rent_amount') }}"
                               class="w-full border-gray-300 rounded"
                               min="0"
                               step="0.01"
                               required>

                        @error('rent_amount')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Save
                        </button>

                        <a href="{{ route('admin.rooms.index') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded">
                            Back
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>