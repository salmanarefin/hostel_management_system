<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    My Booking Requests
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    First-time seat booking and payment status.
                </p>
            </div>

            <a href="{{ route('customer.bookings.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Book Seat
            </a>
        </div>
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
                            <th class="border p-2 text-left">Seat</th>
                            <th class="border p-2 text-left">Paid Days</th>
                            <th class="border p-2 text-left">Daily Rent</th>
                            <th class="border p-2 text-left">Total</th>
                            <th class="border p-2 text-left">Payment</th>
                            <th class="border p-2 text-left">Transaction</th>
                            <th class="border p-2 text-left">Status</th>
                            <th class="border p-2 text-left">Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td class="border p-2">
                                    {{ $booking->branch->name ?? 'N/A' }} /
                                    {{ $booking->room->room_number ?? 'N/A' }} /
                                    {{ $booking->seat->seat_number ?? 'N/A' }}
                                </td>

                                <td class="border p-2">
                                    {{ $booking->paid_days }} day(s)
                                </td>

                                <td class="border p-2">
                                    {{ number_format($booking->daily_rent, 2) }} BDT
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
                                    {{ $booking->created_at->format('d M Y') }}
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