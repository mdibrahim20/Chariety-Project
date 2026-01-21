<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold tracking-tight">FAQ Items</h2>
        <p class="text-muted-foreground mt-1">Manage frequently asked questions</p>
    </div>

    @if (session()->has('success'))
        <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-2">
            <x-ui.card :title="$editingId ? 'Edit FAQ Item' : 'Add New FAQ Item'">
                <form wire:submit.prevent="save" class="space-y-6">
                    <x-ui.form-field 
                        label="Category" 
                        :error="$errors->first('faq_category_id')">
                        <x-ui.select wire:model="faq_category_id">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-ui.select>
                    </x-ui.form-field>

                    <x-ui.form-field 
                        label="Question" 
                        :error="$errors->first('question')">
                        <x-ui.input 
                            wire:model="question" 
                            placeholder="Enter your question" />
                    </x-ui.form-field>

                    <x-ui.form-field 
                        label="Answer" 
                        :error="$errors->first('answer')"
                        hint="You can use basic HTML tags for formatting">
                        <x-ui.textarea 
                            wire:model="answer" 
                            rows="5" 
                            placeholder="Enter the answer" />
                    </x-ui.form-field>

                    <x-ui.form-field 
                        label="Display Order" 
                        :error="$errors->first('display_order')">
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

        <div class="lg:col-span-3">
            <x-ui.card title="FAQ Items List">
                <div class="mb-4">
                    <x-ui.form-field label="Filter by Category">
                        <x-ui.select wire:model.live="filterCategoryId">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-ui.select>
                    </x-ui.form-field>
                </div>

                @if ($items->count() > 0)
                    <x-ui.table>
                        <x-ui.table-header>
                            <x-ui.table-row>
                                <x-ui.table-head>Category</x-ui.table-head>
                                <x-ui.table-head>Question</x-ui.table-head>
                                <x-ui.table-head>Order</x-ui.table-head>
                                <x-ui.table-head>Status</x-ui.table-head>
                                <x-ui.table-head>Actions</x-ui.table-head>
                            </x-ui.table-row>
                        </x-ui.table-header>
                        <x-ui.table-body>
                            @foreach ($items as $item)
                                <x-ui.table-row>
                                    <x-ui.table-cell>
                                        <x-ui.badge>{{ $item->category->name }}</x-ui.badge>
                                    </x-ui.table-cell>
                                    <x-ui.table-cell class="font-medium">{{ Str::limit($item->question, 60) }}</x-ui.table-cell>
                                    <x-ui.table-cell>{{ $item->display_order }}</x-ui.table-cell>
                                    <x-ui.table-cell>
                                        <x-ui.badge :variant="$item->is_active ? 'success' : 'secondary'">
                                            {{ $item->is_active ? 'Active' : 'Inactive' }}
                                        </x-ui.badge>
                                    </x-ui.table-cell>
                                    <x-ui.table-cell>
                                        <div class="inline-flex gap-2">
                                            <x-ui.button 
                                                size="sm" 
                                                variant="outline" 
                                                wire:click="edit({{ $item->id }})">
                                                Edit
                                            </x-ui.button>
                                            <x-ui.button 
                                                size="sm" 
                                                variant="destructive" 
                                                wire:click="delete({{ $item->id }})"
                                                onclick="return confirm('Are you sure you want to delete this FAQ item?')">
                                                Delete
                                            </x-ui.button>
                                        </div>
                                    </x-ui.table-cell>
                                </x-ui.table-row>
                            @endforeach
                        </x-ui.table-body>
                    </x-ui.table>

                    <div class="mt-4 border-t pt-4">
                        {{ $items->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <p class="text-muted-foreground">No FAQ items found. Create your first FAQ item!</p>
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</div>
