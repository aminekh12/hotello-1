<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $room->room_number }} - {{ $room->roomCategory->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.rooms.edit', $room) }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                    Edit Room
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Rooms
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Room Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">Room Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium">Room Number:</span> {{ $room->room_number }}
                                </div>
                                <div>
                                    <span class="font-medium">Category:</span> {{ $room->roomCategory->name }}
                                </div>
                                <div>
                                    <span class="font-medium">Floor:</span> {{ $room->floor }}
                                </div>
                                <div>
                                    <span class="font-medium">Price per Night:</span> {{ number_format($room->price_per_night, 2) }} MAD
                                </div>
                                <div>
                                    <span class="font-medium">Max Occupancy:</span> {{ $room->roomCategory->max_occupancy }} guests
                                </div>
                                <div>
                                    <span class="font-medium">Status:</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($room->is_available) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @endif">
                                        {{ $room->is_available ? 'Available' : 'Occupied' }}
                                    </span>
                                </div>
                                @if($room->description)
                                <div>
                                    <span class="font-medium">Description:</span>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $room->description }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Room Images -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">Room Images</h3>
                            @if($room->images && $room->images->count() > 0)
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach($room->images as $image)
                                        <div class="h-32 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-500 dark:text-gray-400 text-sm">Image {{ $loop->iteration }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="h-32 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500 dark:text-gray-400">No images available</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Category Amenities -->
                    @if($room->roomCategory->amenities && count($room->roomCategory->amenities) > 0)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium mb-4">Room Amenities</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($room->roomCategory->amenities as $amenity)
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200 text-sm rounded-full">
                                    {{ $amenity }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Booking History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Booking History</h3>
                    @if($room->bookings && $room->bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Booking Ref</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-in</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-out</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Guests</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($room->bookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $booking->booking_reference }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <div>
                                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $booking->customer->user->name }}</div>
                                                <div class="text-gray-500 dark:text-gray-400">{{ $booking->customer->user->email }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $booking->check_in_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $booking->check_out_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $booking->guests }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ number_format($booking->total_amount, 2) }} MAD
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($booking->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @elseif($booking->status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($booking->status === 'checked_in') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                                @elseif($booking->status === 'checked_out') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-orange-600 hover:text-orange-900 dark:text-orange-400 dark:hover:text-orange-300">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No bookings found</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This room has no booking history yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
