<div>
    @section('title', 'Navbar Menu')
    
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Navbar Menu Items</h2>
            <p class="mt-1 text-sm text-gray-600">Manage your site's navigation menu structure</p>
        </div>
        <x-admin-button wire:click="openCreateModal">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Menu Item
        </x-admin-button>
    </div>

    <!-- Filters -->
    <x-admin-card class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by label or route..."
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>
            <div class="flex items-end">
                <label class="flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        wire:model.live="showInactive"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    <span class="ml-2 text-sm text-gray-700">Show Inactive Items</span>
                </label>
            </div>
        </div>
    </x-admin-card>

    <!-- Menu Items Table -->
    <x-admin-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Children</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($item->parent_id)
                                        <span class="text-gray-400 mr-2">└─</span>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item->label }}</div>
                                        @if($item->opens_in_new_tab)
                                            <span class="text-xs text-gray-500">(Opens in new tab)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $item->route }}</code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->parent ? $item->parent->label : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->order }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button 
                                    wire:click="toggleStatus({{ $item->id }})"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cursor-pointer {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}"
                                >
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->children->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="openEditModal({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                <button 
                                    wire:click="delete({{ $item->id }})" 
                                    wire:confirm="Are you sure you want to delete this menu item?"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No menu items found</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating your first menu item.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="mt-4">
                {{ $items->links() }}
            </div>
        @endif
    </x-admin-card>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background overlay with blur -->
            <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity"></div>

            <!-- Modal container -->
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal panel -->
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form wire:submit="save">
                        <!-- Modal header -->
                        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-white" id="modal-title">
                                    {{ $editMode ? 'Edit Menu Item' : 'Create New Menu Item' }}
                                </h3>
                                <button 
                                    type="button" 
                                    wire:click="closeModal" 
                                    class="rounded-full p-1 text-indigo-200 hover:text-white hover:bg-indigo-800 transition-colors"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Modal body -->
                        <div class="bg-white px-6 py-6 space-y-5">
                            <!-- Label -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Menu Label <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text"
                                    wire:model="label"
                                    placeholder="Home, About, Services..."
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('label') border-red-300 @enderror"
                                    required
                                >
                                @error('label')
                                    <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Route -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Route / URL <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text"
                                    wire:model="route"
                                    placeholder="/, /about, https://example.com"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors font-mono @error('route') border-red-300 @enderror"
                                    required
                                >
                                @error('route')
                                    <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Parent Menu Item -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Parent Menu (Optional)
                                </label>
                                <select 
                                    wire:model="parent_id"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white"
                                >
                                    @foreach($parentOptions as $option)
                                        <option value="{{ $option['id'] }}">{{ $option['label'] }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Options -->
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <label class="flex items-center cursor-pointer group">
                                    <div class="relative">
                                        <input 
                                            type="checkbox" 
                                            wire:model="is_active"
                                            class="sr-only peer"
                                        >
                                        <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-indigo-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    </div>
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Active</span>
                                        <p class="text-xs text-gray-500">Show this item on the site</p>
                                    </div>
                                </label>

                                <label class="flex items-center cursor-pointer group">
                                    <div class="relative">
                                        <input 
                                            type="checkbox" 
                                            wire:model="opens_in_new_tab"
                                            class="sr-only peer"
                                        >
                                        <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-indigo-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    </div>
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Open in New Tab</span>
                                        <p class="text-xs text-gray-500">Link opens in a new browser tab</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                            <button
                                type="button"
                                wire:click="closeModal"
                                class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $editMode ? 'Update Menu Item' : 'Create Menu Item' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
