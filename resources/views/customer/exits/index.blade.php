<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Exit Requests
            </h2>

            <a href="{{ route('customer.exits.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Request Exit
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

            <div class="bg-white shadow rounded p-6 overflow-x-auto">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Exit Date</th>
                            <th class="border p-2 text-left">Due Amount</th>
                            <th class="border p-2 text-left">Deposit</th>
                            <th class="border p-2 text-left">Final Settlement</th>
                            <th class="border p-2 text-left">Reason</th>
                            <th class="border p-2 text-left">Status</th>
                            <th class="border p-2 text-left">Requested Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($exits as $exit)
                            <tr>
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
                                    {{ $exit->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border p-3 text-center">
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