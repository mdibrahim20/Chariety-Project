<div>
    @if(!$verified)
        <x-admin-card title="Set Up Two-Factor Authentication">
            <div class="max-w-2xl mx-auto">
                <div class="mb-6">
                    <p class="text-gray-700 mb-4">
                        Two-factor authentication adds an extra layer of security to your account. 
                        Follow these steps to enable it:
                    </p>
                    
                    <ol class="list-decimal list-inside space-y-2 text-gray-700">
                        <li>Install an authenticator app (Google Authenticator, Authy, etc.)</li>
                        <li>Scan the QR code below with your app</li>
                        <li>Enter the code from your app to verify</li>
                        <li>Save your recovery codes in a safe place</li>
                    </ol>
                </div>

                <!-- QR Code -->
                <div class="bg-white border-2 border-gray-200 rounded-lg p-6 mb-6 flex justify-center">
                    <div class="inline-block">
                        {!! $qrCode !!}
                    </div>
                </div>

                <!-- Manual Secret Key -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-2">Can't scan? Enter this code manually:</p>
                    <code class="block bg-white border border-gray-300 rounded px-3 py-2 text-center font-mono text-sm">
                        {{ $secret }}
                    </code>
                </div>

                <!-- Verification -->
                <form wire:submit="verify">
                    <div class="mb-4">
                        <label for="verificationCode" class="block text-sm font-medium text-gray-700 mb-1">
                            Verification Code
                        </label>
                        <input 
                            type="text" 
                            id="verificationCode" 
                            wire:model="verificationCode" 
                            class="w-full px-3 py-2 border rounded-md text-center text-lg tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 @error('verificationCode') border-red-500 @enderror"
                            placeholder="000000"
                            maxlength="6"
                            required
                        >
                        @error('verificationCode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-admin-button type="submit" variant="primary" class="w-full">
                        Verify and Enable 2FA
                    </x-admin-button>
                </form>
            </div>
        </x-admin-card>
    @else
        <x-admin-card title="Recovery Codes">
            <div class="max-w-2xl mx-auto">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-yellow-800">Important!</h3>
                            <p class="text-sm text-yellow-700 mt-1">
                                Save these recovery codes in a secure location. Each code can only be used once.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($recoveryCodes as $code)
                            <code class="block bg-white border border-gray-300 rounded px-3 py-2 text-center font-mono text-sm">
                                {{ $code }}
                            </code>
                        @endforeach
                    </div>
                </div>

                <div class="flex space-x-3">
                    <x-admin-button type="button" variant="outline" class="flex-1" onclick="window.print()">
                        Print Codes
                    </x-admin-button>
                    <x-admin-button wire:click="complete" variant="primary" class="flex-1">
                        Continue to Dashboard
                    </x-admin-button>
                </div>
            </div>
        </x-admin-card>
    @endif
</div>
