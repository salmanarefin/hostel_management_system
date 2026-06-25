<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Branches
            </h2>

            <a href="{{ route('admin.branches.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Add Branch
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

            <div class="bg-white shadow rounded p-6">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">ID</th>
                            <th class="border p-2 text-left">Name</th>
                            <th class="border p-2 text-left">Address</th>
                            <th class="border p-2 text-left">Phone</th>
                            <th class="border p-2 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($branches as $branch)
                            <tr>
                                <td class="border p-2">{{ $branch->id }}</td>
                                <td class="border p-2">{{ $branch->name }}</td>
                                <td class="border p-2">{{ $branch->address ?? 'N/A' }}</td>
                                <td class="border p-2">{{ $branch->phone ?? 'N/A' }}</td>
                                <td class="border p-2">
                                    <a href="{{ route('admin.branches.edit', $branch) }}"
                                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.branches.destroy', $branch) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Are you sure?')">
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
                                    No branch found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $branches->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>