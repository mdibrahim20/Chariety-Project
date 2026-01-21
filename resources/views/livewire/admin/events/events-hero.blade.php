<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold tracking-tight">Events Hero Section</h2>
            <p class="text-muted-foreground mt-1">Manage the hero/banner area for Events pages</p>
        </div>
        
        {{-- Active Status Toggle --}}
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium">Section Status:</span>
            <button
                wire:click="$toggle('is_active')"
                type="button"
                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $is_active ? 'bg-primary' : 'bg-input' }}">
                <span class="inline-block h-4 w-4 transform rounded-full bg-background transition-transform {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
            </button>
            <x-ui.badge :variant="$is_active ? 'success' : 'secondary'">
                {{ $is_active ? 'Active' : 'Inactive' }}
            </x-ui.badge>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
    @endif

    {{-- Error Message --}}
    @if (session()->has('error'))
        <x-ui.alert type="error">{{ session('error') }}</x-ui.alert>
    @endif

    {{-- Main Form --}}
    <form wire:submit="save" class="space-y-6">
        
        {{-- Page Content Section --}}
        <x-ui.card title="Page Content" description="Page title and breadcrumb navigation labels">
            <div class="space-y-6">
                {{-- Page Title --}}
                <x-ui.form-field 
                    label="Page Title" 
                    :required="true" 
                    :error="$errors->first('page_title')"
                    hint="Main heading displayed on the Events page">
                    <x-ui.input 
                        wire:model="page_title" 
                        placeholder="Events Details" 
                        required />
                </x-ui.form-field>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Breadcrumb Home Label --}}
                    <x-ui.form-field 
                        label="Breadcrumb Home Label" 
                        :error="$errors->first('breadcrumb_home_label')"
                        hint="First breadcrumb item (e.g., &quot;Home&quot;)">
                        <x-ui.input 
                            wire:model="breadcrumb_home_label" 
                            placeholder="Home" />
                    </x-ui.form-field>

                    {{-- Breadcrumb Current Page Label --}}
                    <x-ui.form-field 
                        label="Breadcrumb Current Page Label" 
                        :error="$errors->first('breadcrumb_current_page_label')"
                        hint="Current page breadcrumb (e.g., &quot;Events&quot;)">
                        <x-ui.input 
                            wire:model="breadcrumb_current_page_label" 
                            placeholder="Events" />
                    </x-ui.form-field>
                </div>
            </div>
        </x-ui.card>

        {{-- Background Image Section --}}
        <x-ui.card title="Background Image" description="Hero banner background image">
            <div>
                @if ($background_image)
                    {{-- Temporary upload preview --}}
                    <div class="mb-4">
                        <div class="relative aspect-[16/5] bg-muted rounded-lg overflow-hidden border-2 border-primary">
                            <img src="{{ $background_image->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                            <x-ui.button
                                type="button"
                                wire:click="removeBackgroundImage"
                                variant="destructive"
                                size="icon"
                                class="absolute top-2 right-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </x-ui.button>
                        </div>
                        <p class="mt-2 text-sm text-green-600 font-medium">✓ Ready to upload</p>
                    </div>
                @elseif ($existing_background_image)
                    {{-- Existing image preview --}}
                    <div class="mb-4">
                        <div class="aspect-[16/5] bg-muted rounded-lg overflow-hidden border relative">
                            <img src="{{ Storage::url($existing_background_image) }}" alt="Current Background" class="w-full h-full object-cover">
                            <x-ui.button
                                type="button"
                                wire:click="deleteBackgroundImage"
                                wire:confirm="Are you sure you want to delete this background image?"
                                variant="destructive"
                                size="icon"
                                class="absolute top-2 right-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </x-ui.button>
                        </div>
                        <p class="mt-2 text-sm text-muted-foreground">Current Background Image</p>
                    </div>
                @else
                    {{-- Placeholder --}}
                    <div class="mb-4 aspect-[16/5] bg-muted rounded-lg border-2 border-dashed flex items-center justify-center">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-2 text-sm text-muted-foreground">No background image uploaded</p>
                        </div>
                    </div>
                @endif

                <input
                    type="file"
                    wire:model="background_image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20"
                >
                <div class="mt-2 text-xs text-muted-foreground space-y-1">
                    <p><strong>Recommended:</strong> 1920 × 600 px (16:5 aspect ratio)</p>
                    <p><strong>Format:</strong> WEBP | <strong>Max:</strong> 500 KB</p>
                    <p><strong>Note:</strong> Images will be automatically resized and optimized</p>
                </div>
                @error('background_image')
                    <p class="mt-2 text-sm text-destructive">{{ $message }}</p>
                @enderror

                <div wire:loading wire:target="background_image" class="mt-2">
                    <div class="flex items-center gap-2 text-primary">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm">Uploading...</span>
                    </div>
                </div>
            </div>
        </x-ui.card>

        {{-- Overlay Settings --}}
        <x-ui.card title="Overlay Settings" description="Improve text readability with a dark overlay">
            <div class="space-y-6">
                {{-- Overlay Enable --}}
                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium">Enable Overlay</label>
                        <p class="text-xs text-muted-foreground mt-1">Add a dark overlay over the background image</p>
                    </div>
                    <button
                        wire:click="$toggle('overlay_enabled')"
                        type="button"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $overlay_enabled ? 'bg-primary' : 'bg-input' }}">
                        <span class="inline-block h-4 w-4 transform rounded-full bg-background transition-transform {{ $overlay_enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                    </button>
                </div>

                @if ($overlay_enabled)
                    {{-- Overlay Opacity --}}
                    <div>
                        <label for="overlay_opacity" class="block text-sm font-medium mb-2">
                            Overlay Opacity: <span class="font-bold text-primary">{{ $overlay_opacity }}%</span>
                        </label>
                        <input
                            type="range"
                            id="overlay_opacity"
                            wire:model.live="overlay_opacity"
                            min="0"
                            max="100"
                            step="5"
                            class="w-full h-2 bg-muted rounded-lg appearance-none cursor-pointer accent-primary"
                        >
                        <div class="flex justify-between text-xs text-muted-foreground mt-1">
                            <span>Transparent (0%)</span>
                            <span>Opaque (100%)</span>
                        </div>
                        @error('overlay_opacity')
                            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </div>
        </x-ui.card>

        {{-- Submit Button --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t">
            <x-ui.button 
                type="submit" 
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">Save Changes</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                </span>
            </x-ui.button>
        </div>
    </form>
</div>
