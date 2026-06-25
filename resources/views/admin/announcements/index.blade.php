<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Announcements
            </h2>

            <a href="{{ route('admin.announcements.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Add Announcement
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded p-6 overflow-x-auto">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">ID</th>
                            <th class="border p-2 text-left">Title</th>
                            <th class="border p-2 text-left">Message</th>
                            <th class="border p-2 text-left">Created Date</th>
                            <th class="border p-2 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($announcements as $announcement)
                            <tr>
                                <td class="border p-2">{{ $announcement->id }}</td>

                                <td class="border p-2 font-bold">
                                    {{ $announcement->title }}
                                </td>

                                <td class="border p-2">
                                    {{ Str::limit($announcement->message, 100) }}
                                </td>

                                <td class="border p-2">
                                    {{ $announcement->created_at->format('d M Y') }}
                                </td>

                                <td class="border p-2">
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}"
                                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete this announcement?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-600 text-white px-3 py-1 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border p-3 text-center">
                                    No announcement found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $announcements->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>