<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Payments
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
                            <th class="border p-2 text-left">Rent Month</th>
                            <th class="border p-2 text-left">Amount</th>
                            <th class="border p-2 text-left">Method</th>
                            <th class="border p-2 text-left">Transaction ID</th>
                            <th class="border p-2 text-left">Payment Status</th>
                            <th class="border p-2 text-left">Rent Status</th>
                            <th class="border p-2 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="border p-2">
                                    <p class="font-bold">{{ $payment->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $payment->user->email ?? 'N/A' }}</p>
                                </td>

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
                                    @if($payment->rent && $payment->rent->status === 'paid')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                            Paid
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                                            Due
                                        </span>
                                    @endif
                                </td>

                                <td class="border p-2">
                                    @if($payment->status === 'pending')
                                        <form action="{{ route('admin.payments.approve', $payment) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Approve this payment?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="bg-green-600 text-white px-3 py-1 rounded mb-1">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.payments.reject', $payment) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Reject this payment?')">
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