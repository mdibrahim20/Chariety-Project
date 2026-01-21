<div>
    @section('title', 'Edit Menu Item')
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Edit Menu Item</h2>
        <p class="mt-1 text-sm text-gray-600">Update navigation menu item details</p>
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

                <!-- Current Hierarchy Info -->
                @if($item->parent || $item->children->count() > 0)
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Menu Structure</h4>
                        @if($item->parent)
                            <p class="text-sm text-blue-700">
                                <strong>Current Parent:</strong> {{ $item->parent->label }}
                            </p>
                        @endif
                        @if($item->children->count() > 0)
                            <p class="text-sm text-blue-700 mt-1">
                                <strong>Has {{ $item->children->count() }} child item(s):</strong>
                                {{ $item->children->pluck('label')->join(', ') }}
                            </p>
                        @endif
                    </div>
                @endif

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
                    Update Menu Item
                </x-admin-button>
            </div>
        </x-admin-card>
    </form>
</div>
