<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            New Seat Change Request
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">Current Seat Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-gray-500">Branch</p>
                        <p class="font-bold">{{ $user->branch->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Room</p>
                        <p class="font-bold">{{ $user->room->room_number ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Seat</p>
                        <p class="font-bold">{{ $user->seat->seat_number ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Current Daily Rent</p>
                        <p class="font-bold">
                            {{ $user->room ? number_format($user->room->rent_amount, 2) : '0.00' }} BDT
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded mb-6">
                <strong>No Refund Policy:</strong>
                If the new seat is cheaper, extra money will be converted into extra stay days.
                No cash refund will be given.
            </div>

            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('customer.seat-change.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Remaining Paid Days</label>

                        <input id="remaining_days"
                               type="number"
                               name="remaining_days"
                               value="{{ old('remaining_days', 1) }}"
                               class="w-full border-gray-300 rounded"
                               min="1"
                               required>

                        @error('remaining_days')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Select New Available Seat</label>

                        <select id="requested_seat_id"
                                name="requested_seat_id"
                                class="w-full border-gray-300 rounded"
                                required>
                            <option value="">Select Seat</option>

                            @foreach($availableSeats as $seat)
                                <option value="{{ $seat->id }}"
                                        data-rent="{{ $seat->room->rent_amount }}"
                                        @selected(old('requested_seat_id') == $seat->id)>
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

                        @error('requested_seat_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="bg-gray-50 border rounded p-4">
                            <p class="text-gray-500">Current Daily Rent</p>
                            <p class="text-xl font-bold">
                                <span id="currentRent">
                                    {{ $user->room ? number_format($user->room->rent_amount, 2) : '0.00' }}
                                </span>
                                BDT
                            </p>
                        </div>

                        <div class="bg-gray-50 border rounded p-4">
                            <p class="text-gray-500">New Daily Rent</p>
                            <p class="text-xl font-bold">
                                <span id="newRent">0.00</span>
                                BDT
                            </p>
                        </div>

                        <div class="bg-gray-50 border rounded p-4">
                            <p class="text-gray-500">Adjustment</p>
                            <p id="differenceText" class="text-xl font-bold">
                                Select a seat
                            </p>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 p-4 rounded mb-4">
                        <p id="adjustmentNote" class="text-blue-800 font-semibold">
                            Select seat and remaining days to see adjustment.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Reason</label>

                        <textarea name="reason"
                                  rows="4"
                                  class="w-full border-gray-300 rounded"
                                  placeholder="Why do you want to change your seat?">{{ old('reason') }}</textarea>

                        @error('reason')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Submit Request
                        </button>

                        <a href="{{ route('customer.seat-change.index') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded">
                            Back
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        const seatSelect = document.getElementById('requested_seat_id');
        const remainingDaysInput = document.getElementById('remaining_days');
        const currentDailyRent = Number({{ $user->room ? $user->room->rent_amount : 0 }});
        const newRent = document.getElementById('newRent');
        const differenceText = document.getElementById('differenceText');
        const adjustmentNote = document.getElementById('adjustmentNote');

        function calculateAdjustment() {
            const selectedOption = seatSelect.options[seatSelect.selectedIndex];
            const remainingDays = Number(remainingDaysInput.value);

            if (!selectedOption.value || remainingDays < 1) {
                newRent.innerText = '0.00';
                differenceText.innerText = 'Select a seat';
                adjustmentNote.innerText = 'Select seat and remaining days to see adjustment.';
                return;
            }

            const newDailyRent = Number(selectedOption.getAttribute('data-rent'));

            const currentValue = currentDailyRent * remainingDays;
            const newSeatValue = newDailyRent * remainingDays;
            const difference = newSeatValue - currentValue;

            newRent.innerText = newDailyRent.toFixed(2);

            if (difference > 0) {
                let payable = difference < 100 ? 100 : difference;

                differenceText.innerText = 'Pay ' + payable.toFixed(2) + ' BDT';
                differenceText.className = 'text-xl font-bold text-red-600';

                adjustmentNote.innerText = 'New seat is more expensive. Customer must pay ' + payable.toFixed(2) + ' BDT.';
            } else if (difference < 0) {
                const credit = Math.abs(difference);
                let extraDays = 0;
                let minimumPayable = 0;

                if (newDailyRent > 0) {
                    extraDays = Math.floor(credit / newDailyRent);
                    const remainingCredit = credit - (extraDays * newDailyRent);
                    const shortForNextDay = newDailyRent - remainingCredit;

                    if (extraDays === 0 && shortForNextDay <= 100) {
                        extraDays = 1;
                        minimumPayable = shortForNextDay;
                    } else if (remainingCredit > 0 && shortForNextDay <= 100) {
                        extraDays = extraDays + 1;
                        minimumPayable = shortForNextDay;
                    }
                }

                differenceText.innerText = 'No Refund';
                differenceText.className = 'text-xl font-bold text-green-600';

                if (extraDays > 0 && minimumPayable > 0) {
                    adjustmentNote.innerText = 'Extra balance converts to ' + extraDays + ' extra day(s). Customer must pay ' + minimumPayable.toFixed(2) + ' BDT to complete the extra day. No refund.';
                } else if (extraDays > 0) {
                    adjustmentNote.innerText = 'Extra balance converts to ' + extraDays + ' extra day(s). No refund.';
                } else {
                    adjustmentNote.innerText = 'Extra balance is not enough for one full extra day. No refund.';
                }
            } else {
                differenceText.innerText = 'No Difference';
                differenceText.className = 'text-xl font-bold text-gray-700';
                adjustmentNote.innerText = 'Both seats have same rent. No extra payment and no refund.';
            }
        }

        seatSelect.addEventListener('change', calculateAdjustment);
        remainingDaysInput.addEventListener('input', calculateAdjustment);
    </script>
</x-app-layout>