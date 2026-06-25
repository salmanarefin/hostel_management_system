<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rent & Payment
            </h2>

            <a href="{{ route('customer.payments.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Submit Payment
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

            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">My Rent History</h3>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Month</th>
                            <th class="border p-2 text-left">Amount</th>
                            <th class="border p-2 text-left">Due Date</th>
                            <th class="border p-2 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rents as $rent)
                            <tr>
                                <td class="border p-2">{{ $rent->month }}</td>
                                <td class="border p-2">{{ number_format($rent->amount, 2) }} BDT</td>
                                <td class="border p-2">{{ \Carbon\Carbon::parse($rent->due_date)->format('d M Y') }}</td>
                                <td class="border p-2">
                                    @if($rent->status === 'paid')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                            Paid
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                                            Due
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border p-3 text-center">
                                    No rent found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $rents->links() }}
                </div>
            </div>

            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-bold mb-4">My Payment History</h3>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Month</th>
                            <th class="border p-2 text-left">Amount</th>
                            <th class="border p-2 text-left">Method</th>
                            <th class="border p-2 text-left">Transaction ID</th>
                            <th class="border p-2 text-left">Status</th>
                            <th class="border p-2 text-left">Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="border p-2">
                                    {{ $payment->rent->month ?? 'N/A' }}
                                </td>

                                <td class="border p-2">
                                    {{ number_format($payment->amount, 2) }} BDT
                                </td>

                                <td class="border p-2">
                                    {{ $payment->payment_method ?? 'N/A' }}
                                </td>

                                <td class="border p-2">
                                    {{ $payment->transaction_id ?? 'N/A' }}
                                </td>

                                <td class="border p-2">
                                    @if($payment->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                            Pending
                                        </span>
                                    @elseif($payment->status === 'approved')
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
                                    {{ $payment->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border p-3 text-center">
                                    No payment found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $payments->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
