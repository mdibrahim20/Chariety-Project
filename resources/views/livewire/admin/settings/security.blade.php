<div>
    <x-slot name="title">Security Settings</x-slot>

    <div class="space-y-6">
        <!-- Security Settings -->
        <x-admin-card title="Security Settings">
            <form wire:submit="save">
                <div class="space-y-6">
                    <!-- Two-Factor Authentication -->
                    <div class="pb-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Two-Factor Authentication</h3>
                        <label class="flex items-start">
                            <input type="checkbox" wire:model="force_2fa_for_admins" class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Force 2FA for All Admin Users</span>
                                <p class="text-sm text-gray-500 mt-1">When enabled, all admin users will be required to set up two-factor authentication</p>
                            </div>
                        </label>
                    </div>

                    <!-- Password Requirements -->
                    <div class="pb-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Password Requirements</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="password_min_length" class="block text-sm font-medium text-gray-700 mb-1">
                                    Minimum Password Length
                                </label>
                                <input 
                                    type="number" 
                                    id="password_min_length" 
                                    wire:model="password_min_length" 
                                    min="6"
                                    max="32"
                                    class="w-32 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>

                            <label class="flex items-center">
                                <input type="checkbox" wire:model="password_require_uppercase" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Require at least one uppercase letter</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" wire:model="password_require_numbers" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Require at least one number</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" wire:model="password_require_special" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Require at least one special character</span>
                            </label>
                        </div>
                    </div>

                    <!-- Session Settings -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Session Settings</h3>
                        
                        <div>
                            <label for="session_timeout" class="block text-sm font-medium text-gray-700 mb-1">
                                Session Timeout (minutes)
                            </label>
                            <input 
                                type="number" 
                                id="session_timeout" 
                                wire:model="session_timeout" 
                                min="5"
                                max="1440"
                                class="w-32 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <p class="text-sm text-gray-500 mt-1">Users will be automatically logged out after this period of inactivity</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex justify-end">
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Save Settings</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>
            </form>
        </x-admin-card>

        <!-- Login Activity Logs -->
        <x-admin-card title="Recent Login Activity">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentLogins as $login)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $login->user ? $login->user->name : 'Unknown' }}</div>
                                    <div class="text-sm text-gray-500">{{ $login->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $login->ip_address }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($login->status === 'success')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Success
                                        </span>
                                    @elseif($login->status === 'failed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Failed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            {{ ucfirst(str_replace('_', ' ', $login->status)) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $login->reason ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $login->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                    No login activity found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $recentLogins->links() }}
            </div>
        </x-admin-card>
    </div>
</div>
