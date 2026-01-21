@php($featured = $event->featuredImage)

<div class="">
    {{-- Featured image header --}}
    @if ($featured && $featured->featured_url)
        <div class="w-full h-[300px] md:h-[480px] overflow-hidden">
            <img src="{{ $featured->featured_url }}" alt="Featured" class="w-full h-full object-cover">
        </div>
    @endif

    <div class="container mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <h1 class="text-3xl font-bold mb-4">{{ $event->title }}</h1>
            @if ($event->summary)
                <p class="text-gray-600 mb-6">{{ $event->summary }}</p>
            @endif
            <div class="prose max-w-none">
                {!! $event->content_html !!}
            </div>
        </div>
        <div class="lg:col-span-1">
            {{-- Donation widget --}}
            @livewire('donation-widget', ['eventId' => $event->id])
        </div>
    </div>

    {{-- More Cause section --}}
    <div class="bg-gray-50 py-8">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-semibold mb-6">More Events</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($moreEvents as $item)
                    @php($thumb = optional($item->images->first())->thumb_url)
                    <a href="{{ route('events.show', $item->slug) }}" class="block bg-white rounded-lg overflow-hidden border border-gray-200 hover:shadow">
                        @if ($thumb)
                            <img src="{{ $thumb }}" alt="thumb" class="w-full h-40 object-cover">
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $item->title }}</h3>
                            @if ($item->summary)
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($item->summary, 100) }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
