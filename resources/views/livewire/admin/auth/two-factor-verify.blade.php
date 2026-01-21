<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Two-Factor Authentication</h2>
    <p class="text-sm text-gray-600 mb-6">
        @if($useRecoveryCode)
            Enter one of your recovery codes
        @else
            Enter the code from your authenticator app
        @endif
    </p>

    <form wire:submit="verify">
        <div class="mb-4">
            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                {{ $useRecoveryCode ? 'Recovery Code' : 'Authentication Code' }}
            </label>
            <input 
                type="text" 
                id="code" 
                wire:model="code" 
                class="w-full px-3 py-2 border rounded-md text-center text-lg tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 @error('code') border-red-500 @enderror"
                placeholder="{{ $useRecoveryCode ? 'XXXXXXXXXX' : '000000' }}"
                required
                autofocus
            >
            @error('code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button 
            type="submit" 
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors mb-4"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Verify</span>
            <span wire:loading>Verifying...</span>
        </button>

        <button 
            type="button" 
            wire:click="toggleRecoveryCode"
            class="w-full text-sm text-blue-600 hover:text-blue-800"
        >
            {{ $useRecoveryCode ? 'Use authenticator code instead' : 'Use recovery code instead' }}
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('admin.login') }}" class="text-sm text-gray-600 hover:text-gray-800">
            Back to login
        </a>
    </div>
</div>
