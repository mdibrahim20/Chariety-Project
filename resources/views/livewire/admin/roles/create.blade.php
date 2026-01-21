<div>
    <x-slot name="title">Create Role</x-slot>

    <x-admin-card title="Create New Role">
        <form wire:submit="save">
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Role Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        wire:model.live="name" 
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                        Slug <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="slug" 
                        wire:model="slug" 
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('slug') border-red-500 @enderror"
                        required
                    >
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea 
                        id="description" 
                        wire:model="description" 
                        rows="3"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ></textarea>
                </div>

                <!-- Permissions -->
                @if(count($permissions) > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 bg-gray-50 border border-gray-200 rounded-lg p-4">
                            @foreach($permissions as $permission)
                                <label class="flex items-start">
                                    <input 
                                        type="checkbox" 
                                        wire:model="selectedPermissions" 
                                        value="{{ $permission->id }}" 
                                        class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    >
                                    <div class="ml-2">
                                        <span class="text-sm font-medium text-gray-700">{{ $permission->name }}</span>
                                        @if($permission->description)
                                            <p class="text-xs text-gray-500">{{ $permission->description }}</p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>Create Role</span>
                    <span wire:loading>Creating...</span>
                </button>
            </div>
        </form>
    </x-admin-card>
</div>
