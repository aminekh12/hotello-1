<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Room') }} - {{ $room->room_number }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.rooms.show', $room) }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                    View Room
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Rooms
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.rooms.update', $room) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Room Category -->
                            <div>
                                <label for="room_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room Category</label>
                                <select name="room_category_id" id="room_category_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('room_category_id', $room->room_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} - {{ number_format($category->base_price, 2) }} MAD/night
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_category_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Room Number -->
                            <div>
                                <label for="room_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room Number</label>
                                <input type="text" name="room_number" id="room_number" value="{{ old('room_number', $room->room_number) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="e.g., S001, D001" required>
                                @error('room_number')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Floor -->
                            <div>
                                <label for="floor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Floor</label>
                                <input type="number" name="floor" id="floor" value="{{ old('floor', $room->floor) }}" min="1" max="20"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                                @error('floor')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price Per Night -->
                            <div>
                                <label for="price_per_night" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price Per Night ($)</label>
                                <input type="number" name="price_per_night" id="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}" step="0.01" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                                @error('price_per_night')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                      placeholder="Room description...">{{ old('description', $room->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Availability -->
                        <div class="mt-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', $room->is_available) ? 'checked' : '' }}
                                       class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <label for="is_available" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                    Room is available for booking
                                </label>
                            </div>
                        </div>

                        <!-- Current Room Info -->
                        <div class="mt-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Current Room Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Current Category:</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $room->roomCategory->name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Max Occupancy:</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $room->roomCategory->max_occupancy }} guests</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Current Status:</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($room->is_available) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @endif">
                                        {{ $room->is_available ? 'Available' : 'Occupied' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Total Bookings:</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $room->bookings->count() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-6 flex justify-end space-x-2">
                            <a href="{{ route('admin.rooms.show', $room) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                Update Room
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
