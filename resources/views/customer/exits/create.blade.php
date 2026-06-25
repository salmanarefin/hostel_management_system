<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Request Hostel Exit
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded mb-6">
                <strong>No Refund Policy:</strong>
                If you leave early, unused paid amount or deposit balance will not be refunded.
            </div>

            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">Final Settlement Preview</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-red-50 border rounded p-4">
                        <p class="text-gray-500">Due Rent Amount</p>
                        <p class="text-2xl font-bold text-red-600">
                            {{ number_format($dueAmount, 2) }} BDT
                        </p>
                    </div>

                    <div class="bg-blue-50 border rounded p-4">
                        <p class="text-gray-500">Deposit / Paid Balance</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ number_format($depositAmount, 2) }} BDT
                        </p>
                    </div>

                    <div class="bg-gray-50 border rounded p-4">
                        <p class="text-gray-500">Final Settlement</p>

                        @if($finalType === 'payable')
                            <p class="text-2xl font-bold text-red-600">
                                Payable {{ number_format($finalAmount, 2) }} BDT
                            </p>
                        @else
                            <p class="text-2xl font-bold text-green-600">
                                No Due
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                No refund will be provided.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('customer.exits.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Exit Date</label>

                        <input type="date"
                               name="exit_date"
                               value="{{ old('exit_date') }}"
                               class="w-full border-gray-300 rounded"
                               required>

                        @error('exit_date')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Reason</label>

                        <textarea name="reason"
                                  rows="5"
                                  class="w-full border-gray-300 rounded"
                                  placeholder="Write your exit reason">{{ old('reason') }}</textarea>

                        @error('reason')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded mb-4">
                        By submitting this request, you agree that unused amount will not be refunded after exit.
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Submit Exit Request
                        </button>

                        <a href="{{ route('customer.exits.index') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded">
                            Back
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>