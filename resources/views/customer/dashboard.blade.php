<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Customer Dashboard
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Manage your hostel booking, seat, rent, leave, exit request, and notifications.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('customer.notifications.index') }}"
                   class="relative bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl shadow-sm hover:bg-gray-50 transition">
                    Notifications

                    @if(isset($unreadNotificationCount) && $unreadNotificationCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                            {{ $unreadNotificationCount }}
                        </span>
                    @endif
                </a>

                @if($user->seat_id)
                    <a href="{{ route('customer.seat-change.index') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-xl shadow-sm hover:bg-blue-700 transition">
                        Change Seat
                    </a>
                @else
                    <a href="{{ route('customer.bookings.index') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-xl shadow-sm hover:bg-blue-700 transition">
                        Book Seat
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Welcome Hero -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-700 rounded-3xl shadow-xl mb-8">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-24 -mt-24"></div>
                <div class="absolute bottom-0 left-0 w-56 h-56 bg-white/10 rounded-full -ml-24 -mb-24"></div>

                <div class="relative p-8 lg:p-10 text-white">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
                        <div class="lg:col-span-2">
                            <p class="uppercase tracking-widest text-blue-100 text-xs font-bold mb-3">
                                Younic Home Customer Panel
                            </p>

                            <h1 class="text-3xl lg:text-4xl font-extrabold mb-3">
                                Welcome back, {{ $user->name }}
                            </h1>

                            <p class="text-blue-100 leading-relaxed max-w-2xl">
                                Here you can manage your hostel seat booking, rent payment, leave application,
                                exit request, and important notifications from one place.
                            </p>
                        </div>

                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5">
                            <p class="text-blue-100 text-sm">Current Status</p>

                            @if($user->seat_id)
                                <h3 class="text-2xl font-bold mt-1">Seat Assigned</h3>
                                <p class="text-blue-100 text-sm mt-2">
                                    {{ $user->branch->name ?? 'N/A' }} /
                                    Room {{ $user->room->room_number ?? 'N/A' }} /
                                    Seat {{ $user->seat->seat_number ?? 'N/A' }}
                                </p>
                            @else
                                <h3 class="text-2xl font-bold mt-1">No Seat Yet</h3>
                                <p class="text-blue-100 text-sm mt-2">
                                    Please book an available seat first.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-white/80 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Deposit / Paid Balance</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-2">
                                {{ number_format($user->deposit_amount, 2) }}
                                <span class="text-sm text-gray-500 font-semibold">BDT</span>
                            </h3>
                        </div>

                        <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-2xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m0-6h4v6h-4m0-6a2 2 0 100 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-white/80 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Current Balance</p>
                            <h3 class="text-2xl font-extrabold {{ $user->balance < 0 ? 'text-red-600' : 'text-green-600' }} mt-2">
                                {{ number_format($user->balance, 2) }}
                                <span class="text-sm text-gray-500 font-semibold">BDT</span>
                            </h3>
                        </div>

                        <div class="w-12 h-12 bg-green-100 text-green-700 rounded-2xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 14l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-white/80 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Daily Rent</p>
                            <h3 class="text-2xl font-extrabold text-gray-900 mt-2">
                                {{ $user->room ? number_format($user->room->rent_amount, 2) : '0.00' }}
                                <span class="text-sm text-gray-500 font-semibold">BDT</span>
                            </h3>
                        </div>

                        <div class="w-12 h-12 bg-purple-100 text-purple-700 rounded-2xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-white/80 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Rent Status</p>

                            @if($latestRent && $latestRent->status === 'paid')
                                <h3 class="text-2xl font-extrabold text-green-600 mt-2">
                                    Paid
                                </h3>
                            @else
                                <h3 class="text-2xl font-extrabold text-red-600 mt-2">
                                    Due
                                </h3>
                            @endif
                        </div>

                        <div class="w-12 h-12 bg-orange-100 text-orange-700 rounded-2xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile + Rent -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-white/80 overflow-hidden">
                    <div class="p-6 border-b bg-gradient-to-r from-white to-blue-50">
                        <h3 class="text-xl font-bold text-gray-900">
                            My Profile Information
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Your personal and assigned hostel information.
                        </p>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Name</p>
                                <p class="font-bold text-gray-900 mt-1">{{ $user->name }}</p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Phone</p>
                                <p class="font-bold text-gray-900 mt-1">{{ $user->phone ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">NID</p>
                                <p class="font-bold text-gray-900 mt-1">{{ $user->nid ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Branch</p>
                                <p class="font-bold text-gray-900 mt-1">{{ $user->branch->name ?? 'Not Assigned' }}</p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Room</p>
                                <p class="font-bold text-gray-900 mt-1">{{ $user->room->room_number ?? 'Not Assigned' }}</p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Seat</p>
                                <p class="font-bold text-gray-900 mt-1">{{ $user->seat->seat_number ?? 'Not Assigned' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-white/80 overflow-hidden">
                    <div class="p-6 bg-gradient-to-r from-indigo-600 to-blue-600 text-white">
                        <h3 class="text-xl font-bold">
                            Current Rent
                        </h3>
                        <p class="text-blue-100 text-sm mt-1">
                            Latest rent information
                        </p>
                    </div>

                    <div class="p-6">
                        <p class="text-gray-500 text-sm font-medium">Amount</p>

                        <h3 class="text-4xl font-extrabold text-gray-900 mt-2">
                            {{ $latestRent ? number_format($latestRent->amount, 2) : '0.00' }}
                            <span class="text-base text-gray-500">BDT</span>
                        </h3>

                        <div class="mt-5">
                            <p class="text-gray-500 text-sm font-medium">Payment Status</p>

                            @if($latestRent && $latestRent->status === 'paid')
                                <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full font-bold mt-2">
                                    <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                                    Paid
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-4 py-2 rounded-full font-bold mt-2">
                                    <span class="w-2 h-2 bg-red-600 rounded-full"></span>
                                    Due
                                </span>
                            @endif
                        </div>

                        <a href="{{ route('customer.payments.index') }}"
                           class="block text-center mt-6 bg-blue-600 text-white px-4 py-3 rounded-2xl font-semibold hover:bg-blue-700 transition">
                            View Payment
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl shadow-sm border border-white/80 p-6 mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">
                            Quick Actions
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Access your important hostel services quickly.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <a href="{{ route('customer.bookings.index') }}"
                       class="group bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-100 rounded-2xl p-5 hover:shadow-md transition">
                        <div class="w-11 h-11 bg-blue-600 text-white rounded-2xl flex items-center justify-center mb-4 group-hover:scale-105 transition">
                            B
                        </div>
                        <h4 class="font-bold text-gray-900">Booking</h4>
                        <p class="text-sm text-gray-500 mt-1">Book first seat</p>
                    </a>

                    <a href="{{ route('customer.seat-change.index') }}"
                       class="group bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-100 rounded-2xl p-5 hover:shadow-md transition">
                        <div class="w-11 h-11 bg-purple-600 text-white rounded-2xl flex items-center justify-center mb-4 group-hover:scale-105 transition">
                            S
                        </div>
                        <h4 class="font-bold text-gray-900">Seat Change</h4>
                        <p class="text-sm text-gray-500 mt-1">Request new seat</p>
                    </a>

                    <a href="{{ route('customer.payments.index') }}"
                       class="group bg-gradient-to-br from-green-50 to-green-100 border border-green-100 rounded-2xl p-5 hover:shadow-md transition">
                        <div class="w-11 h-11 bg-green-600 text-white rounded-2xl flex items-center justify-center mb-4 group-hover:scale-105 transition">
                            P
                        </div>
                        <h4 class="font-bold text-gray-900">Payment</h4>
                        <p class="text-sm text-gray-500 mt-1">Rent and payment</p>
                    </a>

                    <a href="{{ route('customer.leaves.index') }}"
                       class="group bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-100 rounded-2xl p-5 hover:shadow-md transition">
                        <div class="w-11 h-11 bg-yellow-600 text-white rounded-2xl flex items-center justify-center mb-4 group-hover:scale-105 transition">
                            L
                        </div>
                        <h4 class="font-bold text-gray-900">Leave</h4>
                        <p class="text-sm text-gray-500 mt-1">Apply for leave</p>
                    </a>

                    <a href="{{ route('customer.exits.index') }}"
                       class="group bg-gradient-to-br from-red-50 to-red-100 border border-red-100 rounded-2xl p-5 hover:shadow-md transition">
                        <div class="w-11 h-11 bg-red-600 text-white rounded-2xl flex items-center justify-center mb-4 group-hover:scale-105 transition">
                            E
                        </div>
                        <h4 class="font-bold text-gray-900">Exit</h4>
                        <p class="text-sm text-gray-500 mt-1">Exit request</p>
                    </a>
                </div>
            </div>

            <!-- Notifications + Announcements + Payments -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="bg-white rounded-3xl shadow-sm border border-white/80 overflow-hidden">
                    <div class="p-6 border-b bg-gradient-to-r from-white to-indigo-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    Latest Notifications
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Recent updates
                                </p>
                            </div>

                            <a href="{{ route('customer.notifications.index') }}"
                               class="text-blue-600 text-sm font-bold hover:underline">
                                View All
                            </a>
                        </div>
                    </div>

                    <div class="p-6">
                        @if(isset($notifications))
                            @forelse($notifications as $notification)
                                <div class="flex gap-3 py-3 border-b last:border-b-0">
                                    <div class="w-10 h-10 rounded-2xl {{ $notification->read_at ? 'bg-gray-100 text-gray-500' : 'bg-blue-100 text-blue-700' }} flex items-center justify-center font-bold shrink-0">
                                        N
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-gray-900 text-sm">
                                            {{ $notification->title }}
                                        </h4>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ \Illuminate\Support\Str::limit($notification->message, 80) }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $notification->created_at->format('d M Y, h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-8">
                                    No notification found.
                                </p>
                            @endforelse
                        @else
                            <p class="text-gray-500 text-center py-8">
                                No notification found.
                            </p>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-white/80 overflow-hidden">
                    <div class="p-6 border-b bg-gradient-to-r from-white to-orange-50">
                        <h3 class="text-xl font-bold text-gray-900">
                            Latest Announcements
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Notice from admin
                        </p>
                    </div>

                    <div class="p-6">
                        @forelse($announcements as $announcement)
                            <div class="py-3 border-b last:border-b-0">
                                <h4 class="font-bold text-gray-900">
                                    {{ $announcement->title }}
                                </h4>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ \Illuminate\Support\Str::limit($announcement->message, 100) }}
                                </p>

                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $announcement->created_at->format('d M Y') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">
                                No announcement found.
                            </p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-white/80 overflow-hidden">
                    <div class="p-6 border-b bg-gradient-to-r from-white to-green-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    Recent Payments
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Latest payment activities
                                </p>
                            </div>

                            <a href="{{ route('customer.payments.index') }}"
                               class="text-blue-600 text-sm font-bold hover:underline">
                                View All
                            </a>
                        </div>
                    </div>

                    <div class="p-6">
                        @forelse($payments as $payment)
                            <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                                <div>
                                    <p class="font-bold text-gray-900">
                                        {{ number_format($payment->amount, 2) }} BDT
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $payment->payment_method ?? 'N/A' }}
                                    </p>
                                </div>

                                <div>
                                    @if($payment->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-bold">
                                            Pending
                                        </span>
                                    @elseif($payment->status === 'approved')
                                        <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-bold">
                                            Approved
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-bold">
                                            Rejected
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">
                                No payment found.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>