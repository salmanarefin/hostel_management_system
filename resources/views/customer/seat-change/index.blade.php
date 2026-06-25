<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Seat Change Requests
            </h2>

            <a href="{{ route('customer.seat-change.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                New Request
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

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded p-6 overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Current Seat</th>
                            <th class="border p-2 text-left">Requested Seat</th>
                            <th class="border p-2 text-left">Remaining Days</th>
                            <th class="border p-2 text-left">Current Daily Rent</th>
                            <th class="border p-2 text-left">New Daily Rent</th>
                            <th class="border p-2 text-left">Adjustment</th>
                            <th class="border p-2 text-left">Status</th>
                            <th class="border p-2 text-left">Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($requests as $request)
                            <tr>
                                <td class="border p-2">
                                    {{ $request->currentBranch->name ?? 'N/A' }} /
                                    {{ $request->currentRoom->room_number ?? 'N/A' }} /
                                    {{ $request->currentSeat->seat_number ?? 'N/A' }}
                                </td>

                                <td class="border p-2">
                                    {{ $request->requestedBranch->name ?? 'N/A' }} /
                                    {{ $request->requestedRoom->room_number ?? 'N/A' }} /
                                    {{ $request->requestedSeat->seat_number ?? 'N/A' }}
                                </td>

                                <td class="border p-2">
                                    {{ $request->remaining_days }} day(s)
                                </td>

                                <td class="border p-2">
                                    {{ number_format($request->current_rent, 2) }} BDT
                                </td>

                                <td class="border p-2">
                                    {{ number_format($request->new_rent, 2) }} BDT
                                </td>

                                <td class="border p-2">
                                    <p class="font-bold">
                                        {{ $request->adjustment_note ?? 'N/A' }}
                                    </p>
                                </td>

                                <td class="border p-2">
                                    @if($request->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                            Pending
                                        </span>
                                    @elseif($request->status === 'approved')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                            Approved
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                                            Rejected
                                        </span>
                                    @endif
                                </td>

                                <td class="border p-2">
                                    {{ $request->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="border p-3 text-center">
                                    No seat change request found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $requests->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>