<div>
    <x-slot name="title">Email Settings</x-slot>

    <div class="space-y-6">
        <!-- SMTP Configuration -->
        <x-admin-card title="SMTP Configuration">
            <form wire:submit="save">
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Host -->
                        <div class="md:col-span-2">
                            <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-1">
                                SMTP Host <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="mail_host" 
                                wire:model="mail_host" 
                                placeholder="smtp.example.com"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('mail_host') border-red-500 @enderror"
                                required
                            >
                            @error('mail_host')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Port -->
                        <div>
                            <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-1">
                                Port <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="mail_port" 
                                wire:model="mail_port" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <!-- Encryption -->
                        <div>
                            <label for="mail_encryption" class="block text-sm font-medium text-gray-700 mb-1">
                                Encryption <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="mail_encryption" 
                                wire:model="mail_encryption" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                                <option value="tls">TLS</option>
                                <option value="ssl">SSL</option>
                            </select>
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="mail_username" class="block text-sm font-medium text-gray-700 mb-1">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="mail_username" 
                                wire:model="mail_username" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="mail_password" class="block text-sm font-medium text-gray-700 mb-1">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="{{ $showPassword ? 'text' : 'password' }}" 
                                    id="mail_password" 
                                    wire:model="mail_password" 
                                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required
                                >
                                <button 
                                    type="button" 
                                    wire:click="$toggle('showPassword')"
                                    class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700"
                                >
                                    @if($showPassword)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    @endif
                                </button>
                            </div>
                        </div>

                        <!-- From Address -->
                        <div>
                            <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-1">
                                From Address <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="mail_from_address" 
                                wire:model="mail_from_address" 
                                placeholder="noreply@example.com"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <!-- From Name -->
                        <div>
                            <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-1">
                                From Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="mail_from_name" 
                                wire:model="mail_from_name" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required
                            >
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end">
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>Save Settings</span>
                            <span wire:loading>Saving...</span>
                        </button>
                    </div>
                </div>
            </form>
        </x-admin-card>

        <!-- Test Email -->
        <x-admin-card title="Test Email Configuration">
            <form wire:submit="testEmail">
                <div class="space-y-4">
                    <p class="text-sm text-gray-600">Send a test email to verify your SMTP configuration</p>
                    
                    <div>
                        <label for="test_email" class="block text-sm font-medium text-gray-700 mb-1">
                            Test Email Address
                        </label>
                        <input 
                            type="email" 
                            id="test_email" 
                            wire:model="test_email" 
                            placeholder="test@example.com"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                    </div>

                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Send Test Email</span>
                        <span wire:loading>Sending...</span>
                    </button>
                </div>
            </form>
        </x-admin-card>
    </div>
</div>
