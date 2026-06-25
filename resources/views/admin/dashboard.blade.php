<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                Admin Dashboard
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Overview of hostel branches, rooms, seats, payments, and customer requests.
            </p>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-500">
                    <p class="text-gray-500 text-sm">Total Customers</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalCustomers }}</h3>
                </div>

                <div class="bg-white p-6 rounded-xl shadow border-l-4 border-purple-500">
                    <p class="text-gray-500 text-sm">Branches</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalBranches }}</h3>
                </div>

                <div class="bg-white p-6 rounded-xl shadow border-l-4 border-indigo-500">
                    <p class="text-gray-500 text-sm">Rooms</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalRooms }}</h3>
                </div>

                <div class="bg-white p-6 rounded-xl shadow border-l-4 border-cyan-500">
                    <p class="text-gray-500 text-sm">Total Seats</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalSeats }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-green-50 p-6 rounded-xl shadow border border-green-100">
                    <p class="text-green-700 text-sm font-semibold">Available Seats</p>
                    <h3 class="text-3xl font-bold text-green-800 mt-2">{{ $availableSeats }}</h3>
                </div>

                <div class="bg-red-50 p-6 rounded-xl shadow border border-red-100">
                    <p class="text-red-700 text-sm font-semibold">Booked Seats</p>
                    <h3 class="text-3xl font-bold text-red-800 mt-2">{{ $bookedSeats }}</h3>
                </div>

                <div class="bg-yellow-50 p-6 rounded-xl shadow border border-yellow-100">
                    <p class="text-yellow-700 text-sm font-semibold">Due Rents</p>
                    <h3 class="text-3xl font-bold text-yellow-800 mt-2">{{ $dueRents }}</h3>
                </div>

                <div class="bg-blue-50 p-6 rounded-xl shadow border border-blue-100">
                    <p class="text-blue-700 text-sm font-semibold">Pending Payments</p>
                    <h3 class="text-3xl font-bold text-blue-800 mt-2">{{ $pendingPayments }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        Pending Requests
                    </h3>

                    <div class="space-y-4">
                        <a href="{{ route('admin.seat-change-requests.index') }}"
                           class="flex justify-between items-center border rounded-lg p-4 hover:bg-gray-50">
                            <span class="text-gray-700">Seat Change Requests</span>
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-bold">
                                {{ $pendingSeatChanges }}
                            </span>
                        </a>

                        <a href="{{ route('admin.leave-requests.index') }}"
                           class="flex justify-between items-center border rounded-lg p-4 hover:bg-gray-50">
                            <span class="text-gray-700">Leave Requests</span>
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-bold">
                                {{ $pendingLeaves }}
                            </span>
                        </a>

                        <a href="{{ route('admin.exit-requests.index') }}"
                           class="flex justify-between items-center border rounded-lg p-4 hover:bg-gray-50">
                            <span class="text-gray-700">Exit Requests</span>
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-bold">
                                {{ $pendingExits }}
                            </span>
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow lg:col-span-2">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        Quick Actions
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.branches.index') }}"
                           class="bg-blue-600 text-white text-center p-4 rounded-lg font-semibold hover:bg-blue-700">
                            Manage Branches
                        </a>

                        <a href="{{ route('admin.rooms.index') }}"
                           class="bg-indigo-600 text-white text-center p-4 rounded-lg font-semibold hover:bg-indigo-700">
                            Manage Rooms
                        </a>

                        <a href="{{ route('admin.seats.index') }}"
                           class="bg-purple-600 text-white text-center p-4 rounded-lg font-semibold hover:bg-purple-700">
                            Manage Seats
                        </a>

                        <a href="{{ route('admin.payments.index') }}"
                           class="bg-green-600 text-white text-center p-4 rounded-lg font-semibold hover:bg-green-700">
                            Manage Payments
                        </a>

                        <a href="{{ route('admin.announcements.index') }}"
                           class="bg-orange-600 text-white text-center p-4 rounded-lg font-semibold hover:bg-orange-700">
                            Announcements
                        </a>

                        <a href="{{ route('admin.exit-requests.index') }}"
                           class="bg-red-600 text-white text-center p-4 rounded-lg font-semibold hover:bg-red-700">
                            Exit Requests
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">
                        Latest Announcements
                    </h3>

                    <a href="{{ route('admin.announcements.index') }}"
                       class="text-blue-600 text-sm font-semibold">
                        View All
                    </a>
                </div>

                @forelse($announcements as $announcement)
                    <div class="border-b py-4">
                        <h4 class="font-bold text-gray-800">{{ $announcement->title }}</h4>
                        <p class="text-gray-600 mt-1">{{ $announcement->message }}</p>
                        <p class="text-xs text-gray-400 mt-2">
                            {{ $announcement->created_at->format('d M Y') }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500">No announcements found.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>