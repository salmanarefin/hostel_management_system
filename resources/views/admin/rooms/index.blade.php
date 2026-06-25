<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Rooms
            </h2>

            <a href="{{ route('admin.rooms.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Add Room
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded p-6">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">ID</th>
                            <th class="border p-2 text-left">Branch</th>
                            <th class="border p-2 text-left">Room Number</th>
                            <th class="border p-2 text-left">Capacity</th>
                            <th class="border p-2 text-left">Rent</th>
                            <th class="border p-2 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rooms as $room)
                            <tr>
                                <td class="border p-2">{{ $room->id }}</td>
                                <td class="border p-2">{{ $room->branch->name ?? 'N/A' }}</td>
                                <td class="border p-2">{{ $room->room_number }}</td>
                                <td class="border p-2">{{ $room->capacity }}</td>
                                <td class="border p-2">{{ number_format($room->rent_amount, 2) }} BDT</td>
                                <td class="border p-2">
                                    <a href="{{ route('admin.rooms.edit', $room) }}"
                                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.rooms.destroy', $room) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-600 text-white px-3 py-1 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border p-3 text-center">
                                    No room found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $rooms->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>