<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold tracking-tight">FAQ Hero Section</h2>
        <p class="text-muted-foreground mt-1">Manage the hero/banner area for FAQ pages</p>
    </div>

    @if (session()->has('success'))
        <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <x-ui.card title="Hero Section Settings" description="Configure FAQ page hero banner">
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-ui.form-field 
                        label="Page Title" 
                        :error="$errors->first('page_title')">
                        <x-ui.input wire:model="page_title" />
                    </x-ui.form-field>

                    <x-ui.form-field 
                        label="Breadcrumb Home Label" 
                        :error="$errors->first('breadcrumb_home_label')">
                        <x-ui.input wire:model="breadcrumb_home_label" />
                    </x-ui.form-field>

                    <x-ui.form-field 
                        label="Breadcrumb Current Label" 
                        :error="$errors->first('breadcrumb_current_label')">
                        <x-ui.input wire:model="breadcrumb_current_label" />
                    </x-ui.form-field>

                    <x-ui.form-field 
                        label="Overlay Opacity (%)" 
                        :error="$errors->first('overlay_opacity')">
                        <x-ui.input 
                            type="number" 
                            wire:model="overlay_opacity" 
                            min="0" 
                            max="100" />
                    </x-ui.form-field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center gap-3">
                        <button 
                            type="button" 
                            wire:click="$toggle('is_active')" 
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $is_active ? 'bg-primary' : 'bg-input' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-background transition-transform {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                        <label class="text-sm font-medium">Active</label>
                    </div>

                    <div class="flex items-center gap-3">
                        <button 
                            type="button" 
                            wire:click="$toggle('overlay_enabled')" 
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $overlay_enabled ? 'bg-primary' : 'bg-input' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-background transition-transform {{ $overlay_enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                        <label class="text-sm font-medium">Enable Overlay</label>
                    </div>
                </div>

                <x-ui.form-field 
                    label="Background Image" 
                    :error="$errors->first('background_image')"
                    hint="1920x600 pixels, max 10MB">
                    <input 
                        type="file" 
                        wire:model="background_image" 
                        accept="image/*" 
                        class="block w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    
                    @if ($background_image)
                        <div class="mt-3">
                            <p class="text-sm text-muted-foreground mb-2">Preview:</p>
                            <img src="{{ $background_image->temporaryUrl() }}" class="rounded-lg border max-h-48">
                        </div>
                    @elseif ($current_background_image)
                        <div class="mt-3">
                            <p class="text-sm text-muted-foreground mb-2">Current Image:</p>
                            <div class="flex items-start gap-3">
                                <img src="{{ asset('storage/' . $current_background_image) }}" class="rounded-lg border max-h-48">
                                <x-ui.button 
                                    type="button" 
                                    variant="destructive" 
                                    size="sm" 
                                    wire:click="deleteImage"
                                    onclick="return confirm('Are you sure you want to delete this image?')">
                                    Delete Image
                                </x-ui.button>
                            </div>
                        </div>
                    @endif
                </x-ui.form-field>
            </div>
        </x-ui.card>

        <div class="flex gap-3 pt-4 border-t">
            <x-ui.button type="submit">
                Save Changes
            </x-ui.button>
            <x-ui.button 
                variant="outline" 
                :href="'/admin/dashboard'" 
                wire:navigate>
                Cancel
            </x-ui.button>
        </div>
    </form>
</div>
