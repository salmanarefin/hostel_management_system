<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Book Seat
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded mb-6">
                <strong>No Refund Policy:</strong>
                After booking, unused paid amount is not refundable. You can request seat change later.
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <form method="POST" action="{{ route('customer.bookings.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Select Available Seat</label>

                        <select id="seat_id"
                                name="seat_id"
                                class="w-full border-gray-300 rounded"
                                required>
                            <option value="">Select Seat</option>

                            @foreach($availableSeats as $seat)
                                <option value="{{ $seat->id }}"
                                        data-rent="{{ $seat->room->rent_amount }}"
                                        @selected(old('seat_id') == $seat->id)>
                                    {{ $seat->room->branch->name ?? 'N/A' }}
                                    -
                                    Room {{ $seat->room->room_number ?? 'N/A' }}
                                    -
                                    Seat {{ $seat->seat_number }}
                                    -
                                    Daily Rent {{ number_format($seat->room->rent_amount, 2) }} BDT
                                </option>
                            @endforeach
                        </select>

                        @error('seat_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Paid Days</label>

                        <input id="paid_days"
                               type="number"
                               name="paid_days"
                               value="{{ old('paid_days', 1) }}"
                               class="w-full border-gray-300 rounded"
                               min="1"
                               required>

                        @error('paid_days')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="bg-gray-50 border rounded p-4">
                            <p class="text-gray-500">Daily Rent</p>
                            <p class="text-2xl font-bold">
                                <span id="dailyRent">0.00</span> BDT
                            </p>
                        </div>

                        <div class="bg-gray-50 border rounded p-4">
                            <p class="text-gray-500">Paid Days</p>
                            <p class="text-2xl font-bold">
                                <span id="paidDaysText">1</span> day(s)
                            </p>
                        </div>

                        <div class="bg-gray-50 border rounded p-4">
                            <p class="text-gray-500">Total Amount</p>
                            <p class="text-2xl font-bold text-blue-600">
                                <span id="totalAmount">0.00</span> BDT
                            </p>
                        </div>
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
                        <label class="block font-medium mb-1">Transaction ID / Receipt No</label>

                        <input type="text"
                               name="transaction_id"
                               value="{{ old('transaction_id') }}"
                               class="w-full border-gray-300 rounded"
                               required>

                        @error('transaction_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Note</label>

                        <textarea name="note"
                                  rows="4"
                                  class="w-full border-gray-300 rounded"
                                  placeholder="Optional note">{{ old('note') }}</textarea>

                        @error('note')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Submit Booking Request
                        </button>

                        <a href="{{ route('customer.bookings.index') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded">
                            Back
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        const seatSelect = document.getElementById('seat_id');
        const paidDaysInput = document.getElementById('paid_days');
        const dailyRentText = document.getElementById('dailyRent');
        const paidDaysText = document.getElementById('paidDaysText');
        const totalAmountText = document.getElementById('totalAmount');

        function calculateBookingAmount() {
            const selectedOption = seatSelect.options[seatSelect.selectedIndex];
            const paidDays = Number(paidDaysInput.value);

            if (!selectedOption.value || paidDays < 1) {
                dailyRentText.innerText = '0.00';
                paidDaysText.innerText = paidDays > 0 ? paidDays : 1;
                totalAmountText.innerText = '0.00';
                return;
            }

            const dailyRent = Number(selectedOption.getAttribute('data-rent'));
            const totalAmount = dailyRent * paidDays;

            dailyRentText.innerText = dailyRent.toFixed(2);
            paidDaysText.innerText = paidDays;
            totalAmountText.innerText = totalAmount.toFixed(2);
        }

        seatSelect.addEventListener('change', calculateBookingAmount);
        paidDaysInput.addEventListener('input', calculateBookingAmount);
    </script>
</x-app-layout>