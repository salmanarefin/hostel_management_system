<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Leave Requests
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
                            <th class="border p-2 text-left">Start Date</th>
                            <th class="border p-2 text-left">End Date</th>
                            <th class="border p-2 text-left">Reason</th>
                            <th class="border p-2 text-left">Status</th>
                            <th class="border p-2 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($leaves as $leave)
                            <tr>
                                <td class="border p-2">
                                    <p class="font-bold">{{ $leave->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $leave->user->email ?? 'N/A' }}</p>
                                </td>

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
                                    @if($leave->status === 'pending')
                                        <form action="{{ route('admin.leave-requests.approve', $leave) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Approve this leave request?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="bg-green-600 text-white px-3 py-1 rounded mb-1">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.leave-requests.reject', $leave) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Reject this leave request?')">
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
                                <td colspan="6" class="border p-3 text-center">
                                    No leave request found.
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