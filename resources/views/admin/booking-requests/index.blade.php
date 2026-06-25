<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Booking Requests
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
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

            <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Customer</th>
                            <th class="border p-2 text-left">Seat</th>
                            <th class="border p-2 text-left">Paid Days</th>
                            <th class="border p-2 text-left">Total</th>
                            <th class="border p-2 text-left">Payment</th>
                            <th class="border p-2 text-left">Transaction</th>
                            <th class="border p-2 text-left">Status</th>
                            <th class="border p-2 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td class="border p-2">
                                    <p class="font-bold">{{ $booking->user->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->user->email ?? 'N/A' }}</p>
                                </td>

                                <td class="border p-2">
                                    {{ $booking->branch->name ?? 'N/A' }} /
                                    {{ $booking->room->room_number ?? 'N/A' }} /
                                    {{ $booking->seat->seat_number ?? 'N/A' }}
                                </td>

                                <td class="border p-2">
                                    {{ $booking->paid_days }} day(s)
                                </td>

                                <td class="border p-2">
                                    {{ number_format($booking->total_amount, 2) }} BDT
                                </td>

                                <td class="border p-2">
                                    {{ $booking->payment_method }}
                                </td>

                                <td class="border p-2">
                                    {{ $booking->transaction_id }}
                                </td>

                                <td class="border p-2">
                                    @if($booking->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                            Pending
                                        </span>
                                    @elseif($booking->status === 'approved')
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
                                    @if($booking->status === 'pending')
                                        <form action="{{ route('admin.booking-requests.approve', $booking) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Approve this booking?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="bg-green-600 text-white px-3 py-1 rounded mb-1">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.booking-requests.reject', $booking) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Reject this booking?')">
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
                                <td colspan="8" class="border p-3 text-center">
                                    No booking request found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>