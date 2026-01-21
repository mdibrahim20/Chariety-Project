@props(['type' => 'default'])

@php
$types = [
    'default' => 'bg-background text-foreground',
    'success' => 'bg-green-50 text-green-900 border-green-200',
    'error' => 'bg-destructive/15 text-destructive border-destructive/30',
    'warning' => 'bg-yellow-50 text-yellow-900 border-yellow-200',
    'info' => 'bg-blue-50 text-blue-900 border-blue-200',
];

$classes = 'relative w-full rounded-lg border p-4 ' . ($types[$type] ?? $types['default']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }} role="alert">
    <div class="flex items-start gap-3">
        @if($type === 'success')
            <svg class="h-5 w-5 flex-shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        @elseif($type === 'error')
            <svg class="h-5 w-5 flex-shrink-0 text-destructive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        @elseif($type === 'warning')
            <svg class="h-5 w-5 flex-shrink-0 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        @elseif($type === 'info')
            <svg class="h-5 w-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        @endif
        <div class="flex-1">
            {{ $slot }}
        </div>
    </div>
</div>
