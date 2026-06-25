<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Announcement
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('admin.announcements.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Title</label>

                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               class="w-full border-gray-300 rounded"
                               placeholder="Enter announcement title"
                               required>

                        @error('title')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Message</label>

                        <textarea name="message"
                                  rows="6"
                                  class="w-full border-gray-300 rounded"
                                  placeholder="Write announcement message"
                                  required>{{ old('message') }}</textarea>

                        @error('message')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Save
                        </button>

                        <a href="{{ route('admin.announcements.index') }}"
                           class="bg-gray-600 text-white px-4 py-2 rounded">
                            Back
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>