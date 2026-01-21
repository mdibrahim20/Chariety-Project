<div>
    @section('title', 'Topbar Settings')
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Topbar Settings</h2>
        <p class="mt-1 text-sm text-gray-600">Manage the top banner message and contact information</p>
    </div>

    <form wire:submit="save">
        <!-- Preview -->
        @if($topbar_enabled)
            <x-admin-card class="mb-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Live Preview
                </h3>
                <div class="border-2 border-gray-200 rounded-lg overflow-hidden">
                    <div class="py-3 px-4 flex flex-col sm:flex-row items-center justify-between gap-3" 
                         style="background-color: {{ $topbar_bg_color }}; color: {{ $topbar_text_color }};">
                        <div class="text-sm font-medium">
                            {{ $topbar_message ?: 'Enter your message...' }}
                        </div>
                        <div class="flex items-center gap-6 text-sm">
                            @if($topbar_email)
                                <a href="mailto:{{ $topbar_email }}" class="flex items-center hover:opacity-80 transition-opacity">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $topbar_email }}
                                </a>
                            @endif
                            @if($topbar_phone)
                                <a href="tel:{{ $topbar_phone }}" class="flex items-center hover:opacity-80 transition-opacity">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $topbar_phone }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </x-admin-card>
        @endif

        <!-- Enable/Disable Topbar -->
        <x-admin-card class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Enable Topbar</h3>
                    <p class="text-sm text-gray-500 mt-1">Show or hide the topbar on your website</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        wire:model.live="topbar_enabled"
                        class="sr-only peer"
                    >
                    <div class="w-14 h-7 bg-gray-300 rounded-full peer peer-checked:bg-indigo-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all shadow-sm"></div>
                </label>
            </div>
        </x-admin-card>

        <!-- Content Settings -->
        <x-admin-card class="mb-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4">Content</h3>
            
            <div class="space-y-5">
                <!-- Message -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Message
                    </label>
                    <input 
                        type="text"
                        wire:model.live="topbar_message"
                        placeholder="Are you ready for free case evaluation today?"
                        class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    <p class="mt-1.5 text-xs text-gray-500">The main message displayed in the topbar</p>
                    @error('topbar_message')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input 
                            type="email"
                            wire:model.live="topbar_email"
                            placeholder="info@disasterrelief.com"
                            class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                    @error('topbar_email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <input 
                            type="text"
                            wire:model.live="topbar_phone"
                            placeholder="(555) 123-4567"
                            class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                    @error('topbar_phone')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-admin-card>

        <!-- Appearance Settings -->
        <x-admin-card class="mb-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4">Colors</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Background Color -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Background Color
                    </label>
                    <div class="flex items-center gap-3">
                        <input 
                            type="color"
                            wire:model.live="topbar_bg_color"
                            class="h-10 w-20 rounded border border-gray-300 cursor-pointer"
                        >
                        <input 
                            type="text"
                            wire:model.live="topbar_bg_color"
                            placeholder="#1e40af"
                            class="flex-1 px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono"
                        >
                    </div>
                    @error('topbar_bg_color')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Text Color -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Text Color
                    </label>
                    <div class="flex items-center gap-3">
                        <input 
                            type="color"
                            wire:model.live="topbar_text_color"
                            class="h-10 w-20 rounded border border-gray-300 cursor-pointer"
                        >
                        <input 
                            type="text"
                            wire:model.live="topbar_text_color"
                            placeholder="#ffffff"
                            class="flex-1 px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono"
                        >
                    </div>
                    @error('topbar_text_color')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-admin-card>

        <!-- Save Button -->
        <div class="flex items-center justify-end">
            <x-admin-button type="submit">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Topbar Settings
            </x-admin-button>
        </div>
    </form>
</div>
