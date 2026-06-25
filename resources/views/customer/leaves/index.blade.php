<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Leave Applications
            </h2>

            <a href="{{ route('customer.leaves.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Apply Leave
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
                            <th class="border p-2 text-left">Start Date</th>
                            <th class="border p-2 text-left">End Date</th>
                            <th class="border p-2 text-left">Reason</th>
                            <th class="border p-2 text-left">Status</th>
                            <th class="border p-2 text-left">Applied Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($leaves as $leave)
                            <tr>
                                <td class="border p-2">
                                    {{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}
                                </td>

                                <td class="border p-2">
                                    {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                                </td>

                                <td class="border p-2">
                                    {{ $leave->reason }}
                                </td>

                                <td class="border p-2">
                                    @if($leave->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                            Pending
                                        </span>
                                    @elseif($leave->status === 'approved')
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
                                    {{ $leave->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border p-3 text-center">
                                    No leave application found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $leaves->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>