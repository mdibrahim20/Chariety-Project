@props(['label' => null, 'error' => null, 'hint' => null, 'required' => false])

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
            {{ $label }}
            @if($required)
                <span class="text-destructive">*</span>
            @endif
        </label>
    @endif
    
    {{ $slot }}
    
    @if($hint)
        <p class="text-sm text-muted-foreground">{{ $hint }}</p>
    @endif
    
    @if($error)
        <p class="text-sm font-medium text-destructive">{{ $error }}</p>
    @endif
</div>
