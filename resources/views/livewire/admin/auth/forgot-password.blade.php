<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Forgot Password</h2>
    <p class="text-sm text-gray-600 mb-6">Enter your email to receive a password reset link</p>

    @if($message)
        <div class="mb-4 p-3 rounded-md text-sm {{ $messageType === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' }}">
            {{ $message }}
        </div>
    @endif

    <form wire:submit="sendResetLink">
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input 
                type="email" 
                id="email" 
                wire:model="email" 
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                required
                autofocus
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button 
            type="submit" 
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Send Reset Link</span>
            <span wire:loading>Sending...</span>
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('admin.login') }}" class="text-sm text-blue-600 hover:text-blue-800">
            Back to login
        </a>
    </div>
</div>
