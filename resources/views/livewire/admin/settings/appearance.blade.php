<div>
    <x-slot name="title">Appearance Settings</x-slot>

    <x-admin-card title="Appearance Settings">
        <form wire:submit="save">
            <div class="space-y-6">
                <!-- Primary Color -->
                <div>
                    <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">
                        Primary Color
                    </label>
                    <div class="flex items-center space-x-3">
                        <input 
                            type="color" 
                            id="primary_color" 
                            wire:model.live="primary_color" 
                            class="h-10 w-20 border border-gray-300 rounded cursor-pointer"
                        >
                        <input 
                            type="text" 
                            wire:model="primary_color" 
                            class="px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="#3B82F6"
                        >
                    </div>
                    <p class="text-sm text-gray-500 mt-1">This color will be used for buttons, links, and other UI elements</p>
                </div>

                <!-- Sidebar Settings -->
                <div>
                    <label class="flex items-start">
                        <input type="checkbox" wire:model="sidebar_collapsed_default" class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-700">Collapse Sidebar by Default</span>
                            <p class="text-sm text-gray-500 mt-1">When enabled, the sidebar will be collapsed when users first log in</p>
                        </div>
                    </label>
                </div>

                <!-- Preview -->
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Preview</h3>
                    <div class="space-y-3">
                        <button 
                            type="button"
                            class="px-4 py-2 rounded-md text-white transition-colors"
                            style="background-color: {{ $primary_color }}"
                        >
                            Primary Button
                        </button>
                        
                        <div class="flex items-center space-x-2">
                            <a href="#" class="text-sm font-medium transition-colors" style="color: {{ $primary_color }}">
                                Sample Link
                            </a>
                        </div>
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
</div>
