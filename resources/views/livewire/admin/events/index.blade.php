<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold tracking-tight">Manage Events</h2>
            <p class="text-muted-foreground mt-1">Create and manage Event posts</p>
        </div>
        <x-ui.button :href="route('admin.events.create')" wire:navigate>
            + New Event
        </x-ui.button>
    </div>

    @if (session()->has('success'))
        <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
    @endif

    <x-ui.card>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-ui.form-field label="Search">
                <x-ui.input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Search events..." />
            </x-ui.form-field>
            
            <x-ui.form-field label="Status">
                <x-ui.select wire:model.live="statusFilter">
                    <option value="">All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </x-ui.select>
            </x-ui.form-field>
        </div>
    </x-ui.card>

    <x-ui.card>
        <x-ui.table>
            <x-ui.table-header>
                <x-ui.table-row>
                    <x-ui.table-head>Title</x-ui.table-head>
                    <x-ui.table-head>Slug</x-ui.table-head>
                    <x-ui.table-head>Status</x-ui.table-head>
                    <x-ui.table-head class="text-right">Actions</x-ui.table-head>
                </x-ui.table-row>
            </x-ui.table-header>
            <x-ui.table-body>
                @foreach ($events as $event)
                    <x-ui.table-row>
                        <x-ui.table-cell class="font-medium">{{ $event->title }}</x-ui.table-cell>
                        <x-ui.table-cell class="text-muted-foreground">{{ $event->slug }}</x-ui.table-cell>
                        <x-ui.table-cell>
                            <x-ui.badge :variant="$event->is_active ? 'success' : 'secondary'">
                                {{ $event->is_active ? 'Active' : 'Inactive' }}
                            </x-ui.badge>
                        </x-ui.table-cell>
                        <x-ui.table-cell class="text-right">
                            <div class="inline-flex gap-2">
                                <x-ui.button 
                                    size="sm" 
                                    variant="outline" 
                                    :href="route('admin.events.edit', $event->id)" 
                                    wire:navigate>
                                    Edit
                                </x-ui.button>
                                <x-ui.button 
                                    size="sm" 
                                    variant="outline" 
                                    wire:click="toggleStatus({{ $event->id }})">
                                    {{ $event->is_active ? 'Unpublish' : 'Publish' }}
                                </x-ui.button>
                                <x-ui.button 
                                    size="sm" 
                                    variant="destructive" 
                                    wire:click="delete({{ $event->id }})" 
                                    wire:confirm="Delete this event?">
                                    Delete
                                </x-ui.button>
                            </div>
                        </x-ui.table-cell>
                    </x-ui.table-row>
                @endforeach
            </x-ui.table-body>
        </x-ui.table>
        <div class="mt-4 border-t pt-4">{{ $events->links() }}</div>
    </x-ui.card>
</div>
