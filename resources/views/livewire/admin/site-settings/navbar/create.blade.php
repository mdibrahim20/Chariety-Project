<div>
    @section('title', 'Create Menu Item')
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Create Menu Item</h2>
        <p class="mt-1 text-sm text-gray-600">Add a new navigation menu item to your site</p>
    </div>

    <form wire:submit="save">
        <x-admin-card>
            <div class="space-y-6">
                <!-- Label -->
                <div>
                    <x-admin-input 
                        label="Label" 
                        wire:model="label"
                        placeholder="e.g., Home, About, Contact"
                        required
                        error="{{ $errors->first('label') }}"
                    />
                    <p class="mt-1 text-sm text-gray-500">The text that will be displayed in the menu</p>
                </div>

                <!-- Route -->
                <div>
                    <x-admin-input 
                        label="Route / URL" 
                        wire:model="route"
                        placeholder="e.g., /home, /about, https://example.com"
                        required
                        error="{{ $errors->first('route') }}"
                    />
                    <p class="mt-1 text-sm text-gray-500">Can be a relative path (/about) or full URL (https://...)</p>
                </div>

                <!-- Parent Menu Item -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Parent Menu Item
                    </label>
                    <select 
                        wire:model="parent_id"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        @foreach($parentOptions as $option)
                            <option value="{{ $option['id'] }}">{{ $option['label'] }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Select a parent to create a nested menu item</p>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Toggles -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            wire:model="is_active"
                            id="is_active"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <label for="is_active" class="ml-2 text-sm text-gray-700">
                            Active (visible on site)
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            wire:model="opens_in_new_tab"
                            id="opens_in_new_tab"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <label for="opens_in_new_tab" class="ml-2 text-sm text-gray-700">
                            Open in new tab
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.site-settings.navbar.index') }}" wire:navigate>
                    <x-admin-button variant="secondary">
                        Cancel
                    </x-admin-button>
                </a>
                <x-admin-button type="submit">
                    Create Menu Item
                </x-admin-button>
            </div>
        </x-admin-card>
    </form>
</div>
