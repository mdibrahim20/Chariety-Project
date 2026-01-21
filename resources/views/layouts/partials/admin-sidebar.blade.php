<!-- Logo -->
<div class="flex h-16 items-center border-b px-6">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-primary-foreground">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <span class="text-lg font-semibold">{{ config('app.name') }}</span>
    </a>
</div>

<!-- Navigation -->
<nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
    @livewire('admin.sidebar-menu')
</nav>
