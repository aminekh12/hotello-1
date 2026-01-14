<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create New Booking') }}
            </h2>
            <a href="{{ route('admin.bookings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Bookings
            </a>
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
                    <form method="POST" action="{{ route('admin.bookings.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Selection -->
                            <div>
                                <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                                <select name="customer_id" id="customer_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                                    <option value="">Select a customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->user->name }} ({{ $customer->user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Room Selection -->
                            <div>
                                <label for="room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room</label>
                                <select name="room_id" id="room_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                                    <option value="">Select a room</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}
                                                data-price="{{ $room->price_per_night }}"
                                                data-category="{{ $room->roomCategory->name }}">
                                            {{ $room->room_number }} - {{ $room->roomCategory->name }} ({{ number_format($room->price_per_night, 2) }} MAD/night)
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Agent Selection -->
                            <div>
                                <label for="agent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Agent (Optional)</label>
                                <select name="agent_id" id="agent_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">No agent assigned</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('agent_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Check-in Date -->
                            <div>
                                <label for="check_in_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check-in Date</label>
                                <input type="date" name="check_in_date" id="check_in_date" value="{{ old('check_in_date') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                                @error('check_in_date')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Check-out Date -->
                            <div>
                                <label for="check_out_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check-out Date</label>
                                <input type="date" name="check_out_date" id="check_out_date" value="{{ old('check_out_date') }}"
                                       min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                                @error('check_out_date')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Number of Guests -->
                            <div>
                                <label for="guests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Guests</label>
                                <input type="number" name="guests" id="guests" value="{{ old('guests') }}" min="1" max="10"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                                @error('guests')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Special Requests -->
                        <div class="mt-6">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special Requests</label>
                            <textarea name="special_requests" id="special_requests" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                      placeholder="Any special requests or notes...">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Booking Summary -->
                        <div class="mt-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Booking Summary</h4>
                            <div id="booking-summary" class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Check-in:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100" id="summary-checkin">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Check-out:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100" id="summary-checkout">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Nights:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100" id="summary-nights">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Room:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100" id="summary-room">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Price per night:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100" id="summary-price">-</span>
                                </div>
                                <div class="flex justify-between border-t border-gray-200 dark:border-gray-600 pt-2">
                                    <span class="text-gray-600 dark:text-gray-400">Total:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100" id="summary-total">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                Create Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkInInput = document.getElementById('check_in_date');
            const checkOutInput = document.getElementById('check_out_date');
            const roomSelect = document.getElementById('room_id');

            function updateSummary() {
                const checkIn = checkInInput.value;
                const checkOut = checkOutInput.value;
                const selectedRoom = roomSelect.options[roomSelect.selectedIndex];

                document.getElementById('summary-checkin').textContent = checkIn ? new Date(checkIn).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '-';
                document.getElementById('summary-checkout').textContent = checkOut ? new Date(checkOut).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '-';

                if (checkIn && checkOut) {
                    const nights = Math.ceil((new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24));
                    document.getElementById('summary-nights').textContent = nights;
                } else {
                    document.getElementById('summary-nights').textContent = '-';
                }

                if (selectedRoom && selectedRoom.value) {
                    const roomText = selectedRoom.textContent.split(' - ')[0];
                    const price = parseFloat(selectedRoom.dataset.price);

                    document.getElementById('summary-room').textContent = roomText;
                    document.getElementById('summary-price').textContent = `$${price.toFixed(2)}`;

                    if (checkIn && checkOut) {
                        const nights = Math.ceil((new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24));
                        const total = price * nights;
                        document.getElementById('summary-total').textContent = `$${total.toFixed(2)}`;
                    } else {
                        document.getElementById('summary-total').textContent = '-';
                    }
                } else {
                    document.getElementById('summary-room').textContent = '-';
                    document.getElementById('summary-price').textContent = '-';
                    document.getElementById('summary-total').textContent = '-';
                }
            }

            checkInInput.addEventListener('change', updateSummary);
            checkOutInput.addEventListener('change', updateSummary);
            roomSelect.addEventListener('change', updateSummary);

            // Initial update
            updateSummary();
        });
    </script>
</x-app-layout>
