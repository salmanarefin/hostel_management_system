<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="font-bold text-xl text-blue-700">
                        Younic Home
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.branches.index')" :active="request()->routeIs('admin.branches.*')">
                                Branches
                            </x-nav-link>

                            <x-nav-link :href="route('admin.rooms.index')" :active="request()->routeIs('admin.rooms.*')">
                                Rooms
                            </x-nav-link>

                            <x-nav-link :href="route('admin.seats.index')" :active="request()->routeIs('admin.seats.*')">
                                Seats
                            </x-nav-link>

                            <x-nav-link :href="route('admin.booking-requests.index')" :active="request()->routeIs('admin.booking-requests.*')">
                                Booking Requests
                            </x-nav-link>

                            <x-nav-link :href="route('admin.seat-change-requests.index')" :active="request()->routeIs('admin.seat-change-requests.*')">
                                Seat Requests
                            </x-nav-link>

                            <x-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')">
                                Payments
                            </x-nav-link>

                            <x-nav-link :href="route('admin.leave-requests.index')" :active="request()->routeIs('admin.leave-requests.*')">
                                Leave Requests
                            </x-nav-link>

                            <x-nav-link :href="route('admin.exit-requests.index')" :active="request()->routeIs('admin.exit-requests.*')">
                                Exit Requests
                            </x-nav-link>

                            <x-nav-link :href="route('admin.announcements.index')" :active="request()->routeIs('admin.announcements.*')">
                                Announcements
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('customer.bookings.index')" :active="request()->routeIs('customer.bookings.*')">
                                Booking
                            </x-nav-link>

                            <x-nav-link :href="route('customer.seat-change.index')" :active="request()->routeIs('customer.seat-change.*')">
                                Seat Change
                            </x-nav-link>

                            <x-nav-link :href="route('customer.payments.index')" :active="request()->routeIs('customer.payments.*')">
                                Rent & Payment
                            </x-nav-link>

                            <x-nav-link :href="route('customer.leaves.index')" :active="request()->routeIs('customer.leaves.*')">
                                Leave
                            </x-nav-link>

                            <x-nav-link :href="route('customer.exits.index')" :active="request()->routeIs('customer.exits.*')">
                                Exit
                            </x-nav-link>

                            <a href="{{ route('customer.notifications.index') }}"
                               class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('customer.notifications.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                Notifications

                                <span id="notificationBadge"
                                      class="ml-2 hidden bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                                    0
                                </span>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            @auth
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.branches.index')" :active="request()->routeIs('admin.branches.*')">
                        Branches
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.rooms.index')" :active="request()->routeIs('admin.rooms.*')">
                        Rooms
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.seats.index')" :active="request()->routeIs('admin.seats.*')">
                        Seats
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.booking-requests.index')" :active="request()->routeIs('admin.booking-requests.*')">
                        Booking Requests
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.seat-change-requests.index')" :active="request()->routeIs('admin.seat-change-requests.*')">
                        Seat Requests
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')">
                        Payments
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.leave-requests.index')" :active="request()->routeIs('admin.leave-requests.*')">
                        Leave Requests
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.exit-requests.index')" :active="request()->routeIs('admin.exit-requests.*')">
                        Exit Requests
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.announcements.index')" :active="request()->routeIs('admin.announcements.*')">
                        Announcements
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('customer.bookings.index')" :active="request()->routeIs('customer.bookings.*')">
                        Booking
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('customer.seat-change.index')" :active="request()->routeIs('customer.seat-change.*')">
                        Seat Change
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('customer.payments.index')" :active="request()->routeIs('customer.payments.*')">
                        Rent & Payment
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('customer.leaves.index')" :active="request()->routeIs('customer.leaves.*')">
                        Leave
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('customer.exits.index')" :active="request()->routeIs('customer.exits.*')">
                        Exit
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('customer.notifications.index')" :active="request()->routeIs('customer.notifications.*')">
                        Notifications
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ Auth::user()->name }}
                </div>

                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    @auth
        @if(auth()->user()->role === 'customer')
            <script>
                function loadNotificationCount() {
                    fetch("{{ route('customer.notifications.unread-count') }}")
                        .then(response => response.json())
                        .then(data => {
                            const badge = document.getElementById('notificationBadge');

                            if (!badge) {
                                return;
                            }

                            if (data.count > 0) {
                                badge.innerText = data.count;
                                badge.classList.remove('hidden');
                            } else {
                                badge.innerText = '0';
                                badge.classList.add('hidden');
                            }
                        })
                        .catch(error => console.log(error));
                }

                loadNotificationCount();
                setInterval(loadNotificationCount, 5000);
            </script>
        @endif
    @endauth
</nav>