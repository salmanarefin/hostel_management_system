<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Seat Change Requests
        </h2>
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
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Customer</th>
                            <th class="border p-2 text-left">Current Seat</th>
                            <th class="border p-2 text-left">Requested Seat</th>
                            <th class="border p-2 text-left">Current Rent</th>
                            <th class="border p-2 text-left">New Rent</th>
                            <th class="border p-2 text-left">Difference</th>
                            <th class="border p-2 text-left">Reason</th>
                            <th class="border p-2 text-left">Status</th>
                            <th class="border p-2 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($requests as $request)
                            <tr>
                                <td class="border p-2">
                                    <p class="font-bold">{{ $request->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $request->user->email ?? 'N/A' }}</p>
                                </td>

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
                                    {{ number_format($request->current_rent, 2) }} BDT
                                </td>

                                <td class="border p-2">
                                    {{ number_format($request->new_rent, 2) }} BDT
                                </td>

                                <td class="border p-2">
                                    @if($request->payment_difference > 0)
                                        <span class="text-red-600 font-bold">
                                            Pay Extra {{ number_format($request->payment_difference, 2) }} BDT
                                        </span>
                                    @elseif($request->payment_difference < 0)
                                        <span class="text-green-600 font-bold">
                                            Balance {{ number_format(abs($request->payment_difference), 2) }} BDT
                                        </span>
                                    @else
                                        <span class="text-gray-600 font-bold">
                                            No Difference
                                        </span>
                                    @endif
                                </td>

                                <td class="border p-2">
                                    {{ $request->reason ?? 'N/A' }}
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
                                    @if($request->status === 'pending')
                                        <form action="{{ route('admin.seat-change-requests.approve', $request) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Approve this request?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="bg-green-600 text-white px-3 py-1 rounded mb-1">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.seat-change-requests.reject', $request) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Reject this request?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded">
                                                Reject
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">No action</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="border p-3 text-center">
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