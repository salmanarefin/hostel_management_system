<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Submit Rent Payment
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('customer.payments.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Select Due Rent</label>

                        <select id="rent_id"
                                name="rent_id"
                                class="w-full border-gray-300 rounded"
                                required>
                            <option value="">Select Rent</option>

                            @foreach($dueRents as $rent)
                                <option value="{{ $rent->id }}"
                                        data-amount="{{ $rent->amount }}"
                                        @selected(old('rent_id') == $rent->id)>
                                    {{ $rent->month }}
                                    -
                                    {{ number_format($rent->amount, 2) }} BDT
                                    -
                                    Due: {{ \Carbon\Carbon::parse($rent->due_date)->format('d M Y') }}
                                </option>
                            @endforeach
                        </select>

                        @error('rent_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Amount</label>

                        <input id="amount"
                               type="number"
                               name="amount"
                               value="{{ old('amount') }}"
                               class="w-full border-gray-300 rounded"
                               min="1"
                               step="0.01"
                               required>

                        @error('amount')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Payment Method</label>

                        <select name="payment_method"
                                class="w-full border-gray-300 rounded"
                                required>
                            <option value="">Select Method</option>
                            <option value="bKash" @selected(old('payment_method') === 'bKash')>bKash</option>
                            <option value="Nagad" @selected(old('payment_method') === 'Nagad')>Nagad</option>
                            <option value="Rocket" @selected(old('payment_method') === 'Rocket')>Rocket</option>
                            <option value="Bank" @selected(old('payment_method') === 'Bank')>Bank</option>
                            <option value="Cash" @selected(old('payment_method') === 'Cash')>Cash</option>
                        </select>

                        @error('payment_method')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Transaction ID</label>

                        <input type="text"
                               name="transaction_id"
                               value="{{ old('transaction_id') }}"
                               class="w-full border-gray-300 rounded"
                               placeholder="Enter transaction ID or cash receipt number"
                               required>

                        @error('transaction_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Submit Payment
                        </button>

                        <a href="{{ route('customer.payments.index') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded">
                            Back
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        const rentSelect = document.getElementById('rent_id');
        const amountInput = document.getElementById('amount');

        rentSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];

            if (!selectedOption.value) {
                amountInput.value = '';
                return;
            }

            amountInput.value = selectedOption.getAttribute('data-amount');
        });
    </script>
</x-app-layout>