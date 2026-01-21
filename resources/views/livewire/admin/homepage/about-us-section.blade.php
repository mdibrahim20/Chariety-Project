<div class="p-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">About Us Section</h1>
                <p class="mt-1 text-sm text-gray-600">Manage the About Us section content and images</p>
            </div>
            
            {{-- Active Status Toggle --}}
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-700">Section Status:</span>
                <button
                    wire:click="$toggle('is_active')"
                    type="button"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $is_active ? 'bg-indigo-600' : 'bg-gray-200' }}"
                >
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                </button>
                <span class="text-sm font-semibold {{ $is_active ? 'text-green-600' : 'text-gray-500' }}">
                    {{ $is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Main Form --}}
    <form wire:submit="save" class="space-y-8">
        
        {{-- Left Content Section --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Left Content</h2>
                <p class="text-sm text-gray-600 mt-1">Badge, heading, and main description</p>
            </div>

            <div class="space-y-6">
                {{-- Badge Text --}}
                <div>
                    <label for="badge_text" class="block text-sm font-medium text-gray-700 mb-2">
                        Badge Text
                        <span class="text-gray-500 font-normal">(e.g., "About Us")</span>
                    </label>
                    <input
                        type="text"
                        id="badge_text"
                        wire:model="badge_text"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="About Us"
                    >
                    @error('badge_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Main Heading --}}
                <div>
                    <label for="main_heading" class="block text-sm font-medium text-gray-700 mb-2">
                        Main Heading <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="main_heading"
                        wire:model="main_heading"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Committed to Relief, Our Work Dedicated to Hope"
                        required
                    >
                    @error('main_heading')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea
                        id="description"
                        wire:model="description"
                        rows="4"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter a short description that appears under the heading..."
                    ></textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Feature Cards Section --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Feature Cards (2)</h2>
                <p class="text-sm text-gray-600 mt-1">Icon, title, and description for each feature</p>
            </div>

            <div class="space-y-8">
                {{-- Feature Card 1 --}}
                <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-md font-semibold text-gray-800 mb-4">Feature Card #1</h3>
                    
                    <div class="space-y-4">
                        {{-- Icon Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                            
                            @if ($feature1_icon)
                                {{-- Temporary upload preview --}}
                                <div class="mb-3">
                                    <div class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg">
                                        @if (str_ends_with($feature1_icon->getClientOriginalName(), '.svg'))
                                            <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/>
                                            </svg>
                                        @else
                                            <img src="{{ $feature1_icon->temporaryUrl() }}" alt="Preview" class="w-12 h-12 object-cover rounded">
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $feature1_icon->getClientOriginalName() }}</p>
                                            <p class="text-xs text-gray-500">Ready to upload</p>
                                        </div>
                                        <button
                                            type="button"
                                            wire:click="removeFeature1Icon"
                                            class="text-red-600 hover:text-red-700 text-sm font-medium"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            @elseif ($existing_feature1_icon)
                                {{-- Existing icon preview --}}
                                <div class="mb-3">
                                    <div class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg">
                                        <img src="{{ Storage::url($existing_feature1_icon) }}" alt="Icon" class="w-12 h-12 object-cover rounded">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Current Icon</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <input
                                type="file"
                                wire:model="feature1_icon"
                                accept=".svg,.jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            >
                            <p class="mt-1 text-xs text-gray-500">SVG, JPG, PNG, or WEBP (max 2MB)</p>
                            @error('feature1_icon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div>
                            <label for="feature1_title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input
                                type="text"
                                id="feature1_title"
                                wire:model="feature1_title"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Helping people rebuild and prepare"
                            >
                            @error('feature1_title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="feature1_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea
                                id="feature1_description"
                                wire:model="feature1_description"
                                rows="3"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Enter supporting text for this feature..."
                            ></textarea>
                            @error('feature1_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Feature Card 2 --}}
                <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-md font-semibold text-gray-800 mb-4">Feature Card #2</h3>
                    
                    <div class="space-y-4">
                        {{-- Icon Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                            
                            @if ($feature2_icon)
                                {{-- Temporary upload preview --}}
                                <div class="mb-3">
                                    <div class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg">
                                        @if (str_ends_with($feature2_icon->getClientOriginalName(), '.svg'))
                                            <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/>
                                            </svg>
                                        @else
                                            <img src="{{ $feature2_icon->temporaryUrl() }}" alt="Preview" class="w-12 h-12 object-cover rounded">
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $feature2_icon->getClientOriginalName() }}</p>
                                            <p class="text-xs text-gray-500">Ready to upload</p>
                                        </div>
                                        <button
                                            type="button"
                                            wire:click="removeFeature2Icon"
                                            class="text-red-600 hover:text-red-700 text-sm font-medium"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            @elseif ($existing_feature2_icon)
                                {{-- Existing icon preview --}}
                                <div class="mb-3">
                                    <div class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg">
                                        <img src="{{ Storage::url($existing_feature2_icon) }}" alt="Icon" class="w-12 h-12 object-cover rounded">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Current Icon</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <input
                                type="file"
                                wire:model="feature2_icon"
                                accept=".svg,.jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            >
                            <p class="mt-1 text-xs text-gray-500">SVG, JPG, PNG, or WEBP (max 2MB)</p>
                            @error('feature2_icon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div>
                            <label for="feature2_title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input
                                type="text"
                                id="feature2_title"
                                wire:model="feature2_title"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Feature title"
                            >
                            @error('feature2_title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="feature2_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea
                                id="feature2_description"
                                wire:model="feature2_description"
                                rows="3"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Enter supporting text for this feature..."
                            ></textarea>
                            @error('feature2_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Content Section --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Right Content</h2>
                <p class="text-sm text-gray-600 mt-1">Paragraph, CTA button, and small image</p>
            </div>

            <div class="space-y-6">
                {{-- Right Paragraph --}}
                <div>
                    <label for="right_paragraph" class="block text-sm font-medium text-gray-700 mb-2">
                        Paragraph Text
                    </label>
                    <textarea
                        id="right_paragraph"
                        wire:model="right_paragraph"
                        rows="4"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter mission/summary text that appears on the right side..."
                    ></textarea>
                    @error('right_paragraph')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CTA Button Text --}}
                <div>
                    <label for="cta_button_text" class="block text-sm font-medium text-gray-700 mb-2">
                        CTA Button Text
                    </label>
                    <input
                        type="text"
                        id="cta_button_text"
                        wire:model="cta_button_text"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Volunteer"
                    >
                    @error('cta_button_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CTA Button Link --}}
                <div>
                    <label for="cta_button_link" class="block text-sm font-medium text-gray-700 mb-2">
                        CTA Button Link (URL)
                    </label>
                    <input
                        type="url"
                        id="cta_button_link"
                        wire:model="cta_button_link"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="https://example.com/volunteer"
                    >
                    @error('cta_button_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CTA Button Target --}}
                <div>
                    <label for="cta_button_target" class="block text-sm font-medium text-gray-700 mb-2">
                        CTA Button Target
                    </label>
                    <select
                        id="cta_button_target"
                        wire:model="cta_button_target"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="_self">Same Tab</option>
                        <option value="_blank">New Tab</option>
                    </select>
                    @error('cta_button_target')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Images Section --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Images</h2>
                <p class="text-sm text-gray-600 mt-1">Upload and manage section images</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Image 1 (Main Large Image) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Image 1 - Main Large Image
                    </label>

                    @if ($image1)
                        {{-- Temporary upload preview --}}
                        <div class="mb-4">
                            <div class="relative aspect-[416/659] bg-gray-100 rounded-lg overflow-hidden border-2 border-indigo-500">
                                <img src="{{ $image1->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                                <button
                                    type="button"
                                    wire:click="removeImage1"
                                    class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 shadow-lg"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-2 text-sm text-green-600 font-medium">✓ Ready to upload</p>
                        </div>
                    @elseif ($existing_image1)
                        {{-- Existing image preview --}}
                        <div class="mb-4">
                            <div class="aspect-[416/659] bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ Storage::url($existing_image1) }}" alt="Current Image" class="w-full h-full object-cover">
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Current Image</p>
                        </div>
                    @else
                        {{-- Placeholder --}}
                        <div class="mb-4 aspect-[416/659] bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No image uploaded</p>
                            </div>
                        </div>
                    @endif

                    <input
                        type="file"
                        wire:model="image1"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    >
                    <div class="mt-2 text-xs text-gray-500 space-y-1">
                        <p><strong>Target:</strong> 416 × 659 px (aspect 416:659)</p>
                        <p><strong>Format:</strong> WEBP | <strong>Max:</strong> 500 KB</p>
                        <p><strong>Expected size:</strong> ~108 KB</p>
                    </div>
                    @error('image1')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="image1" class="mt-2">
                        <div class="flex items-center gap-2 text-indigo-600">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm">Uploading...</span>
                        </div>
                    </div>
                </div>

                {{-- Image 2 (Small Image) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Image 2 - Small Image
                    </label>

                    @if ($image2)
                        {{-- Temporary upload preview --}}
                        <div class="mb-4">
                            <div class="relative aspect-[49/78] bg-gray-100 rounded-lg overflow-hidden border-2 border-indigo-500 max-w-xs">
                                <img src="{{ $image2->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                                <button
                                    type="button"
                                    wire:click="removeImage2"
                                    class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 shadow-lg"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-2 text-sm text-green-600 font-medium">✓ Ready to upload</p>
                        </div>
                    @elseif ($existing_image2)
                        {{-- Existing image preview --}}
                        <div class="mb-4">
                            <div class="aspect-[49/78] bg-gray-100 rounded-lg overflow-hidden border border-gray-200 max-w-xs">
                                <img src="{{ Storage::url($existing_image2) }}" alt="Current Image" class="w-full h-full object-cover">
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Current Image</p>
                        </div>
                    @else
                        {{-- Placeholder --}}
                        <div class="mb-4 aspect-[49/78] bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center max-w-xs">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No image</p>
                            </div>
                        </div>
                    @endif

                    <input
                        type="file"
                        wire:model="image2"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    >
                    <div class="mt-2 text-xs text-gray-500 space-y-1">
                        <p><strong>Target:</strong> 196 × 312 px (aspect 49:78)</p>
                        <p><strong>Format:</strong> WEBP | <strong>Max:</strong> 500 KB</p>
                        <p><strong>Expected size:</strong> ~27.4 KB</p>
                    </div>
                    @error('image2')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="image2" class="mt-2">
                        <div class="flex items-center gap-2 text-indigo-600">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm">Uploading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <button
                type="submit"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="save">Save Changes</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                </span>
            </button>
        </div>
    </form>
</div>
