<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    My Notifications
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    View rent reminders, request updates, announcements, and payment notifications.
                </p>
            </div>

            <form method="POST" action="{{ route('customer.notifications.mark-all-read') }}">
                @csrf
                @method('PATCH')

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded">
                    Mark All as Read
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-xl overflow-hidden">
                @forelse($notifications as $notification)
                    <div class="p-5 border-b {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    @if(!$notification->read_at)
                                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">
                                            New
                                        </span>
                                    @endif

                                    <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full">
                                        {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                    </span>
                                </div>

                                <h3 class="font-bold text-gray-800 text-lg">
                                    {{ $notification->title }}
                                </h3>

                                <p class="text-gray-600 mt-1">
                                    {{ $notification->message }}
                                </p>

                                <p class="text-xs text-gray-400 mt-2">
                                    {{ $notification->created_at->format('d M Y, h:i A') }}
                                </p>
                            </div>

                            <div>
                                @if(!$notification->read_at)
                                    <form method="POST" action="{{ route('customer.notifications.read', $notification) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                                            Read
                                        </button>
                                    </form>
                                @else
                                    <span class="text-green-600 text-sm font-semibold">
                                        Read
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        No notification found.
                    </div>
                @endforelse
            </div>

            <div class="mt-5">
                {{ $notifications->links() }}
            </div>

        </div>
    </div>
</x-app-layout>