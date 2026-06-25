<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                New Seat Change Request
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Select an available seat and see automatic no-refund adjustment calculation.
            </p>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Current Seat Info -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-700 to-indigo-700 px-6 py-5 text-white">
                    <h3 class="text-xl font-bold">
                        Current Seat Information
                    </h3>
                    <p class="text-blue-100 text-sm mt-1">
                        This is your currently assigned seat.
                    </p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">
                                Branch
                            </p>
                            <p class="font-bold text-gray-900 mt-1">
                                {{ $user->branch->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">
                                Room
                            </p>
                            <p class="font-bold text-gray-900 mt-1">
                                {{ $user->room->room_number ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">
                                Seat
                            </p>
                            <p class="font-bold text-gray-900 mt-1">
                                {{ $user->seat->seat_number ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">
                                Current Daily Rent
                            </p>
                            <p class="font-bold text-gray-900 mt-1">
                                {{ $user->room ? number_format($user->room->rent_amount, 2) : '0.00' }} BDT
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Policy -->
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-5 rounded-2xl mb-6 shadow-sm">
                <p class="font-semibold">
                    No Refund Policy
                </p>
                <p class="mt-1 text-sm leading-relaxed">
                    If the new seat is cheaper, extra money will not be refunded. Extra money will be converted into extra stay days.
                    If the shortage for one extra day is 100 BDT or less, the customer must pay that shortage.
                </p>
            </div>

            <!-- Seat Change Form -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b bg-gradient-to-r from-white to-blue-50">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">
                                Select New Seat
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Available seats found: {{ $availableSeats->count() }}
                            </p>
                        </div>

                        <a href="{{ route('customer.seat-change.index') }}"
                           class="bg-gray-700 text-white px-4 py-2 rounded-xl text-center hover:bg-gray-800 transition">
                            Back
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($availableSeats->count() === 0)
                        <div class="bg-red-50 border border-red-200 text-red-700 p-5 rounded-2xl">
                            No available seat found. Please contact admin or add available seats from admin panel.
                        </div>
                    @else
                        <form method="POST" action="{{ route('customer.seat-change.store') }}">
                            @csrf

                            <div class="mb-5">
                                <label for="remaining_days" class="block font-bold text-gray-800 mb-2">
                                    Remaining Paid Days
                                </label>

                                <input id="remaining_days"
                                       type="number"
                                       name="remaining_days"
                                       value="{{ old('remaining_days', 1) }}"
                                       class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       min="1"
                                       required>

                                @error('remaining_days')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="requested_seat_id" class="block font-bold text-gray-800 mb-2">
                                    Select New Available Seat
                                </label>

                                <select id="requested_seat_id"
                                        name="requested_seat_id"
                                        class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        size="1"
                                        required>
                                    <option value="">Select Seat</option>

                                    @foreach($availableSeats as $seat)
                                        <option value="{{ $seat->id }}"
                                                data-rent="{{ $seat->room->rent_amount }}"
                                                data-branch="{{ $seat->room->branch->name ?? 'N/A' }}"
                                                data-room="{{ $seat->room->room_number ?? 'N/A' }}"
                                                data-seat="{{ $seat->seat_number }}"
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
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <p class="text-xs text-gray-500 mt-2">
                                    If your newly added seat is not visible here, check that the seat status is available in admin panel.
                                </p>
                            </div>

                            <!-- Selected Seat Preview -->
                            <div id="selectedSeatPreview" class="hidden mb-5 bg-blue-50 border border-blue-200 rounded-2xl p-5">
                                <p class="text-sm text-blue-700 font-bold mb-2">
                                    Selected Seat Preview
                                </p>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold">Branch</p>
                                        <p id="previewBranch" class="font-bold text-gray-900">N/A</p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold">Room</p>
                                        <p id="previewRoom" class="font-bold text-gray-900">N/A</p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold">Seat</p>
                                        <p id="previewSeat" class="font-bold text-gray-900">N/A</p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold">Daily Rent</p>
                                        <p id="previewRent" class="font-bold text-gray-900">0.00 BDT</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Calculation Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5">
                                    <p class="text-gray-500 text-sm font-medium">
                                        Current Daily Rent
                                    </p>
                                    <p class="text-2xl font-extrabold text-gray-900 mt-1">
                                        <span id="currentRent">
                                            {{ $user->room ? number_format($user->room->rent_amount, 2) : '0.00' }}
                                        </span>
                                        BDT
                                    </p>
                                </div>

                                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5">
                                    <p class="text-gray-500 text-sm font-medium">
                                        New Daily Rent
                                    </p>
                                    <p class="text-2xl font-extrabold text-gray-900 mt-1">
                                        <span id="newRent">0.00</span>
                                        BDT
                                    </p>
                                </div>

                                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5">
                                    <p class="text-gray-500 text-sm font-medium">
                                        Adjustment
                                    </p>
                                    <p id="differenceText" class="text-2xl font-extrabold text-gray-900 mt-1">
                                        Select a seat
                                    </p>
                                </div>
                            </div>

                            <div class="bg-blue-50 border border-blue-200 p-5 rounded-2xl mb-5">
                                <p id="adjustmentNote" class="text-blue-800 font-semibold leading-relaxed">
                                    Select seat and remaining days to see adjustment.
                                </p>
                            </div>

                            <div class="mb-5">
                                <label for="reason" class="block font-bold text-gray-800 mb-2">
                                    Reason
                                </label>

                                <textarea id="reason"
                                          name="reason"
                                          rows="5"
                                          class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Why do you want to change your seat?">{{ old('reason') }}</textarea>

                                @error('reason')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="submit"
                                        class="bg-blue-600 text-white px-5 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                                    Submit Request
                                </button>

                                <a href="{{ route('customer.seat-change.index') }}"
                                   class="bg-gray-700 text-white px-5 py-3 rounded-xl font-bold hover:bg-gray-800 transition text-center">
                                    Back
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const seatSelect = document.getElementById('requested_seat_id');
            const remainingDaysInput = document.getElementById('remaining_days');

            const currentDailyRent = Number({{ $user->room ? $user->room->rent_amount : 0 }});

            const newRent = document.getElementById('newRent');
            const differenceText = document.getElementById('differenceText');
            const adjustmentNote = document.getElementById('adjustmentNote');

            const selectedSeatPreview = document.getElementById('selectedSeatPreview');
            const previewBranch = document.getElementById('previewBranch');
            const previewRoom = document.getElementById('previewRoom');
            const previewSeat = document.getElementById('previewSeat');
            const previewRent = document.getElementById('previewRent');

            function calculateAdjustment() {
                if (!seatSelect) {
                    return;
                }

                const selectedOption = seatSelect.options[seatSelect.selectedIndex];
                const remainingDays = Number(remainingDaysInput.value);

                if (!selectedOption || !selectedOption.value || remainingDays < 1) {
                    newRent.innerText = '0.00';
                    differenceText.innerText = 'Select a seat';
                    differenceText.className = 'text-2xl font-extrabold text-gray-900 mt-1';
                    adjustmentNote.innerText = 'Select seat and remaining days to see adjustment.';

                    selectedSeatPreview.classList.add('hidden');

                    return;
                }

                const newDailyRent = Number(selectedOption.getAttribute('data-rent'));
                const branchName = selectedOption.getAttribute('data-branch');
                const roomNumber = selectedOption.getAttribute('data-room');
                const seatNumber = selectedOption.getAttribute('data-seat');

                selectedSeatPreview.classList.remove('hidden');
                previewBranch.innerText = branchName;
                previewRoom.innerText = roomNumber;
                previewSeat.innerText = seatNumber;
                previewRent.innerText = newDailyRent.toFixed(2) + ' BDT';

                const currentValue = currentDailyRent * remainingDays;
                const newSeatValue = newDailyRent * remainingDays;
                const difference = newSeatValue - currentValue;

                newRent.innerText = newDailyRent.toFixed(2);

                if (difference > 0) {
                    let payable = difference < 100 ? 100 : difference;

                    differenceText.innerText = 'Pay ' + payable.toFixed(2) + ' BDT';
                    differenceText.className = 'text-2xl font-extrabold text-red-600 mt-1';

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
                    differenceText.className = 'text-2xl font-extrabold text-green-600 mt-1';

                    if (extraDays > 0 && minimumPayable > 0) {
                        adjustmentNote.innerText = 'Extra balance converts to ' + extraDays + ' extra day(s). Customer must pay ' + minimumPayable.toFixed(2) + ' BDT to complete the extra day. No refund.';
                    } else if (extraDays > 0) {
                        adjustmentNote.innerText = 'Extra balance converts to ' + extraDays + ' extra day(s). No refund.';
                    } else {
                        adjustmentNote.innerText = 'Extra balance is not enough for one full extra day. No refund.';
                    }
                } else {
                    differenceText.innerText = 'No Difference';
                    differenceText.className = 'text-2xl font-extrabold text-gray-900 mt-1';

                    adjustmentNote.innerText = 'Both seats have same rent. No extra payment and no refund.';
                }
            }

            if (seatSelect) {
                seatSelect.addEventListener('change', calculateAdjustment);
            }

            if (remainingDaysInput) {
                remainingDaysInput.addEventListener('input', calculateAdjustment);
            }

            calculateAdjustment();
        });
    </script>
</x-app-layout>