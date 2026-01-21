<div class="space-y-1">
    @foreach($menu as $item)
        @if(isset($item['children']))
            <!-- Menu with Submenu -->
            <div x-data="{ open: {{ $this->isParentActive($item['children']) ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md transition-colors {{ $this->isParentActive($item['children']) ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span>{{ $item['name'] }}</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                
                <!-- Submenu -->
                <div x-show="open" x-collapse class="ml-4 space-y-1 border-l pl-4">
                    @foreach($item['children'] as $child)
                        <a href="{{ route($child['route']) }}" wire:navigate
                           class="block px-3 py-2 text-sm rounded-md transition-colors {{ $this->isActive($child['route']) ? 'bg-primary/10 text-primary font-medium' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                            {{ $child['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Single Menu Item -->
            <a href="{{ route($item['route']) }}" wire:navigate
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ $this->isActive($item['route']) ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>{{ $item['name'] }}</span>
            </a>
        @endif
    @endforeach
</div>
