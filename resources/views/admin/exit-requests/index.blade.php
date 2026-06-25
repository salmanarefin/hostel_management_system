<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Exit Requests
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
                            <th class="border p-2 text-left">Exit Date</th>
                            <th class="border p-2 text-left">Due</th>
                            <th class="border p-2 text-left">Deposit</th>
                            <th class="border p-2 text-left">Final Settlement</th>
                            <th class="border p-2 text-left">Reason</th>
                            <th class="border p-2 text-left">Status</th>
                            <th class="border p-2 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($exits as $exit)
                            <tr>
                                <td class="border p-2">
                                    <p class="font-bold">{{ $exit->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $exit->user->email ?? 'N/A' }}</p>
                                </td>

                                <td class="border p-2">
                                    {{ $exit->user->branch->name ?? 'N/A' }} /
                                    {{ $exit->user->room->room_number ?? 'N/A' }} /
                                    {{ $exit->user->seat->seat_number ?? 'N/A' }}
                                </td>

                                <td class="border p-2">
                                    {{ \Carbon\Carbon::parse($exit->exit_date)->format('d M Y') }}
                                </td>

                                <td class="border p-2">
                                    {{ number_format($exit->due_amount, 2) }} BDT
                                </td>

                                <td class="border p-2">
                                    {{ number_format($exit->deposit_amount, 2) }} BDT
                                </td>

                                <td class="border p-2">
                                    @if($exit->final_type === 'payable')
                                        <span class="text-red-600 font-bold">
                                            Payable {{ number_format($exit->final_amount, 2) }} BDT
                                        </span>
                                    @else
                                        <span class="text-green-600 font-bold">
                                            Refundable {{ number_format($exit->final_amount, 2) }} BDT
                                        </span>
                                    @endif
                                </td>

                                <td class="border p-2">
                                    {{ $exit->reason ?? 'N/A' }}
                                </td>

                                <td class="border p-2">
                                    @if($exit->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                            Pending
                                        </span>
                                    @elseif($exit->status === 'approved')
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
                                    @if($exit->status === 'pending')
                                        <form action="{{ route('admin.exit-requests.approve', $exit) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Approve this exit request?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="bg-green-600 text-white px-3 py-1 rounded mb-1">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.exit-requests.reject', $exit) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Reject this exit request?')">
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
                                    No exit request found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $exits->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>