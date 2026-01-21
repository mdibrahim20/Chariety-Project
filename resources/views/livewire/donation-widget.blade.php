<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-xl font-semibold text-gray-900 mb-4">Support This Cause</h3>

    @if (session()->has('success'))
        <div class="mb-4 rounded bg-green-50 border border-green-200 p-3 text-green-800">{{ session('success') }}</div>
    @endif

    <form wire:submit="submit" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Amount (BDT) *</label>
            <input type="number" min="1" wire:model="amount" class="w-full rounded-lg border-gray-300" placeholder="1000" required>
            @error('amount')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
            <input type="text" wire:model="full_name" class="w-full rounded-lg border-gray-300" placeholder="Your Full Name" required>
            @error('full_name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
            <input type="email" wire:model="email" class="w-full rounded-lg border-gray-300" placeholder="your@email.com" required>
            @error('email')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
            <input type="text" wire:model="phone" class="w-full rounded-lg border-gray-300" placeholder="01XXXXXXXXX" required>
            @error('phone')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
            <select wire:model="payment_method" class="w-full rounded-lg border-gray-300" required>
                <option value="bkash">bKash</option>
                <option value="nagad">Nagad</option>
                <option value="bank">Bank Transfer</option>
                <option value="check">Check</option>
            </select>
            @error('payment_method')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
            Donate Now
        </button>
    </form>
</div>
