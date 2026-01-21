<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Admin Login</h2>
    <p class="text-sm text-gray-600 mb-6">Sign in to access the admin panel</p>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded-md text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login">
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

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input 
                type="password" 
                id="password" 
                wire:model="password" 
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                required
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center">
                <input type="checkbox" wire:model="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>

            <a href="{{ route('admin.password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">
                Forgot password?
            </a>
        </div>

        <button 
            type="submit" 
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Sign In</span>
            <span wire:loading>Signing in...</span>
        </button>
    </form>
</div>
