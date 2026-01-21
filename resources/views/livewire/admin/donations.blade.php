<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Donations</h1>
            <p class="mt-1 text-sm text-gray-600">Manage all donation submissions</p>
        </div>
        <button wire:click="exportCsv" class="px-4 py-2 bg-green-600 text-white rounded-lg">Export CSV</button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded bg-green-50 border border-green-200 p-3 text-green-800">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Total Donations</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Confirmed</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['confirmed'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-700">Search</label>
                <input type="text" wire:model.live="search" class="w-full rounded-lg border-gray-300" placeholder="Name or Email">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Event</label>
                <select wire:model.live="eventFilter" class="w-full rounded-lg border-gray-300">
                    <option value="">All Events</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Status</label>
                <select wire:model.live="statusFilter" class="w-full rounded-lg border-gray-300">
                    <option value="">All</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Method</label>
                <select wire:model.live="methodFilter" class="w-full rounded-lg border-gray-300">
                    <option value="">All</option>
                    <option value="bkash">bKash</option>
                    <option value="nagad">Nagad</option>
                    <option value="bank">Bank</option>
                    <option value="check">Check</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($donations as $donation)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">{{ $donation->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $donation->email }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $donation->event ? $donation->event->title : 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">৳{{ number_format($donation->amount) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($donation->payment_method) }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $donation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                   ($donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($donation->status === 'paid' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex gap-1">
                                <button wire:click="updateStatus({{ $donation->id }}, 'confirmed')" class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Confirm</button>
                                <button wire:click="updateStatus({{ $donation->id }}, 'failed')" class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Fail</button>
                                <button wire:click="delete({{ $donation->id }})" wire:confirm="Delete?" class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-200">{{ $donations->links() }}</div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('download', (event) => {
            const path = event[0].path;
            const link = document.createElement('a');
            link.href = `/storage/${path}`;
            link.download = path.split('/').pop();
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>
@endpush
