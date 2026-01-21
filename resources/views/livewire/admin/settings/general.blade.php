<div>
    <x-slot name="title">General Settings</x-slot>

    <x-admin-card title="General Settings">
        <form wire:submit="save">
            <div class="space-y-6">
                <!-- App Name -->
                <div>
                    <label for="app_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Application Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="app_name" 
                        wire:model="app_name" 
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('app_name') border-red-500 @enderror"
                        required
                    >
                    @error('app_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Timezone -->
                <div>
                    <label for="app_timezone" class="block text-sm font-medium text-gray-700 mb-1">
                        Timezone <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="app_timezone" 
                        wire:model="app_timezone" 
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="UTC">UTC</option>
                        <option value="America/New_York">America/New York</option>
                        <option value="America/Chicago">America/Chicago</option>
                        <option value="America/Los_Angeles">America/Los Angeles</option>
                        <option value="Europe/London">Europe/London</option>
                        <option value="Europe/Paris">Europe/Paris</option>
                        <option value="Asia/Tokyo">Asia/Tokyo</option>
                        <option value="Asia/Dubai">Asia/Dubai</option>
                    </select>
                    @error('app_timezone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Locale -->
                <div>
                    <label for="app_locale" class="block text-sm font-medium text-gray-700 mb-1">
                        Language <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="app_locale" 
                        wire:model="app_locale" 
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="en">English</option>
                        <option value="es">Spanish</option>
                        <option value="fr">French</option>
                        <option value="de">German</option>
                    </select>
                    @error('app_locale')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
</div>
