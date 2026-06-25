<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Apply for Leave
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('customer.leaves.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Start Date</label>

                        <input type="date"
                               name="start_date"
                               value="{{ old('start_date') }}"
                               class="w-full border-gray-300 rounded"
                               required>

                        @error('start_date')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">End Date</label>

                        <input type="date"
                               name="end_date"
                               value="{{ old('end_date') }}"
                               class="w-full border-gray-300 rounded"
                               required>

                        @error('end_date')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Reason</label>

                        <textarea name="reason"
                                  rows="5"
                                  class="w-full border-gray-300 rounded"
                                  placeholder="Write your leave reason"
                                  required>{{ old('reason') }}</textarea>

                        @error('reason')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Submit Application
                        </button>

                        <a href="{{ route('customer.leaves.index') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded">
                            Back
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>