<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold tracking-tight">Contact Messages</h2>
        <p class="text-muted-foreground mt-1">View and manage contact form submissions</p>
    </div>

    @if (session()->has('success'))
        <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
    @endif

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-ui.card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-muted-foreground">New Messages</p>
                    <p class="text-2xl font-bold">{{ $newCount }}</p>
                </div>
                <div class="bg-primary rounded-full p-3">
                    <svg class="w-6 h-6 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-muted-foreground">Read</p>
                    <p class="text-2xl font-bold">{{ $readCount }}</p>
                </div>
                <div class="bg-green-600 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-muted-foreground">Replied</p>
                    <p class="text-2xl font-bold">{{ $repliedCount }}</p>
                </div>
                <div class="bg-purple-600 rounded-full p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Filters -->
    <x-ui.card>
        <div class="flex flex-wrap gap-4 items-center">
            <label class="text-sm font-medium">Filter by Status:</label>
            <x-ui.select wire:model.live="filterStatus">
                <option value="">All Messages</option>
                <option value="new">New</option>
                <option value="read">Read</option>
                <option value="replied">Replied</option>
            </x-ui.select>
        </div>
    </x-ui.card>

    <!-- Messages Table -->
    <x-ui.card>
        @if ($messages->count() > 0)
            <x-ui.table>
                <x-ui.table-header>
                    <x-ui.table-row>
                        <x-ui.table-head>Name</x-ui.table-head>
                        <x-ui.table-head>Email</x-ui.table-head>
                        <x-ui.table-head>Subject</x-ui.table-head>
                        <x-ui.table-head>Message</x-ui.table-head>
                        <x-ui.table-head>Status</x-ui.table-head>
                        <x-ui.table-head>Date</x-ui.table-head>
                        <x-ui.table-head>Actions</x-ui.table-head>
                    </x-ui.table-row>
                </x-ui.table-header>
                <x-ui.table-body>
                    @foreach ($messages as $message)
                        <x-ui.table-row>
                            <x-ui.table-cell class="font-medium">{{ $message->full_name }}</x-ui.table-cell>
                            <x-ui.table-cell class="text-muted-foreground">{{ $message->email }}</x-ui.table-cell>
                            <x-ui.table-cell class="text-muted-foreground">{{ $message->subject ?? '-' }}</x-ui.table-cell>
                            <x-ui.table-cell>
                                <div class="max-w-xs truncate text-muted-foreground">{{ $message->message }}</div>
                            </x-ui.table-cell>
                            <x-ui.table-cell>
                                @if ($message->status === 'new')
                                    <x-ui.badge>New</x-ui.badge>
                                @elseif ($message->status === 'read')
                                    <x-ui.badge variant="success">Read</x-ui.badge>
                                @else
                                    <x-ui.badge variant="secondary">Replied</x-ui.badge>
                                @endif
                            </x-ui.table-cell>
                            <x-ui.table-cell class="text-muted-foreground">{{ $message->created_at->format('M d, Y') }}</x-ui.table-cell>
                            <x-ui.table-cell>
                                <div class="inline-flex gap-2">
                                    <x-ui.button 
                                        size="sm" 
                                        variant="outline" 
                                        wire:click="viewMessage({{ $message->id }})">
                                        View
                                    </x-ui.button>
                                    <x-ui.button 
                                        size="sm" 
                                        variant="destructive" 
                                        wire:click="delete({{ $message->id }})"
                                        onclick="return confirm('Are you sure you want to delete this message?')">
                                        Delete
                                    </x-ui.button>
                                </div>
                            </x-ui.table-cell>
                        </x-ui.table-row>
                    @endforeach
                </x-ui.table-body>
            </x-ui.table>

            <div class="mt-4 border-t pt-4">{{ $messages->links() }}</div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="mt-4 text-muted-foreground">No messages found</p>
            </div>
        @endif
    </x-ui.card>

    <!-- Message Detail Modal -->
    @if ($showModal && $selectedMessage)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showModal') }">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-black/50" @click="$wire.closeModal()"></div>

                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-card rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border">
                    <div class="px-6 pt-5 pb-4">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-xl font-semibold">Message Details</h3>
                            <button @click="$wire.closeModal()" class="text-muted-foreground hover:text-foreground">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Name</label>
                                <p class="text-foreground">{{ $selectedMessage->full_name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Email</label>
                                <p class="text-foreground">{{ $selectedMessage->email }}</p>
                            </div>

                            @if ($selectedMessage->subject)
                                <div>
                                    <label class="block text-sm font-medium mb-1">Subject</label>
                                    <p class="text-foreground">{{ $selectedMessage->subject }}</p>
                                </div>
                            @endif

                            @if ($selectedMessage->amount)
                                <div>
                                    <label class="block text-sm font-medium mb-1">Amount</label>
                                    <p class="text-foreground">${{ number_format($selectedMessage->amount, 2) }}</p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium mb-1">Message</label>
                                <div class="p-4 bg-muted rounded-lg">
                                    <p class="text-foreground whitespace-pre-wrap">{{ $selectedMessage->message }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Status</label>
                                @if ($selectedMessage->status === 'new')
                                    <x-ui.badge>New</x-ui.badge>
                                @elseif ($selectedMessage->status === 'read')
                                    <x-ui.badge variant="success">Read</x-ui.badge>
                                @else
                                    <x-ui.badge variant="secondary">Replied</x-ui.badge>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Received</label>
                                <p class="text-foreground">{{ $selectedMessage->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-muted/50 px-6 py-3 flex gap-3 justify-end border-t">
                        @if ($selectedMessage->status !== 'replied')
                            <x-ui.button 
                                variant="outline"
                                wire:click="markAsReplied({{ $selectedMessage->id }})">
                                Mark as Replied
                            </x-ui.button>
                        @endif
                        <x-ui.button 
                            variant="destructive"
                            wire:click="delete({{ $selectedMessage->id }})"
                            onclick="return confirm('Are you sure you want to delete this message?')">
                            Delete
                        </x-ui.button>
                        <x-ui.button 
                            variant="outline"
                            @click="$wire.closeModal()">
                            Close
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
