<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Reset Password</h2>
    <p class="text-sm text-gray-600 mb-6">Enter your new password</p>

    <form wire:submit="resetPassword">
        <input type="hidden" wire:model="token">
        
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input 
                type="email" 
                id="email" 
                wire:model="email" 
                class="w-full px-3 py-2 border rounded-md bg-gray-50 @error('email') border-red-500 @enderror"
                readonly
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
            <input 
                type="password" 
                id="password" 
                wire:model="password" 
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                required
                autofocus
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input 
                type="password" 
                id="password_confirmation" 
                wire:model="password_confirmation" 
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
        </div>

        <button 
            type="submit" 
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Reset Password</span>
            <span wire:loading>Resetting...</span>
        </button>
    </form>
</div>
