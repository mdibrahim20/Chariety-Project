<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold tracking-tight">FAQ Categories</h2>
        <p class="text-muted-foreground mt-1">Manage FAQ category groups</p>
    </div>

    @if (session()->has('success'))
        <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <x-ui.card :title="$editingId ? 'Edit Category' : 'Add New Category'">
                <form wire:submit.prevent="save" class="space-y-6">
                    <x-ui.form-field 
                        label="Category Name" 
                        :error="$errors->first('name')">
                        <x-ui.input 
                            wire:model="name" 
                            placeholder="e.g., General Questions" />
                    </x-ui.form-field>

                    <x-ui.form-field 
                        label="Display Order" 
                        :error="$errors->first('display_order')"
                        hint="Lower numbers appear first">
                        <x-ui.input 
                            type="number" 
                            wire:model="display_order" 
                            min="0" />
                    </x-ui.form-field>

                    <div class="flex items-center gap-3">
                        <button 
                            type="button" 
                            wire:click="$toggle('is_active')" 
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $is_active ? 'bg-primary' : 'bg-input' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-background transition-transform {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                        <label class="text-sm font-medium">Active</label>
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <x-ui.button type="submit">
                            {{ $editingId ? 'Update' : 'Create' }}
                        </x-ui.button>
                        @if ($editingId)
                            <x-ui.button 
                                type="button" 
                                variant="outline" 
                                wire:click="cancelEdit">
                                Cancel
                            </x-ui.button>
                        @endif
                    </div>
                </form>
            </x-ui.card>
        </div>

        <div class="lg:col-span-2">
            <x-ui.card title="Categories List">
                @if ($categories->count() > 0)
                    <x-ui.table>
                        <x-ui.table-header>
                            <x-ui.table-row>
                                <x-ui.table-head>Name</x-ui.table-head>
                                <x-ui.table-head>Slug</x-ui.table-head>
                                <x-ui.table-head>Order</x-ui.table-head>
                                <x-ui.table-head>Status</x-ui.table-head>
                                <x-ui.table-head>FAQ Count</x-ui.table-head>
                                <x-ui.table-head>Actions</x-ui.table-head>
                            </x-ui.table-row>
                        </x-ui.table-header>
                        <x-ui.table-body>
                            @foreach ($categories as $category)
                                <x-ui.table-row>
                                    <x-ui.table-cell class="font-medium">{{ $category->name }}</x-ui.table-cell>
                                    <x-ui.table-cell class="font-mono text-xs text-muted-foreground">{{ $category->slug }}</x-ui.table-cell>
                                    <x-ui.table-cell>{{ $category->display_order }}</x-ui.table-cell>
                                    <x-ui.table-cell>
                                        <x-ui.badge :variant="$category->is_active ? 'success' : 'secondary'">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </x-ui.badge>
                                    </x-ui.table-cell>
                                    <x-ui.table-cell>{{ $category->faqItems()->count() }}</x-ui.table-cell>
                                    <x-ui.table-cell>
                                        <div class="inline-flex gap-2">
                                            <x-ui.button 
                                                size="sm" 
                                                variant="outline" 
                                                wire:click="edit({{ $category->id }})">
                                                Edit
                                            </x-ui.button>
                                            <x-ui.button 
                                                size="sm" 
                                                variant="destructive" 
                                                wire:click="delete({{ $category->id }})"
                                                onclick="return confirm('Are you sure? This will delete all FAQ items in this category!')">
                                                Delete
                                            </x-ui.button>
                                        </div>
                                    </x-ui.table-cell>
                                </x-ui.table-row>
                            @endforeach
                        </x-ui.table-body>
                    </x-ui.table>

                    <div class="mt-4 border-t pt-4">
                        {{ $categories->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <p class="text-muted-foreground">No categories found. Create your first category!</p>
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</div>
