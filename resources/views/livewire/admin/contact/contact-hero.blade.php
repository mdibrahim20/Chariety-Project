<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold tracking-tight">Contact Hero Section</h2>
            <p class="text-muted-foreground mt-1">Manage the hero banner for the contact page</p>
        </div>
    </div>

    <!-- Success Alert -->
    @if (session()->has('success'))
        <x-ui.alert type="success">
            {{ session('success') }}
        </x-ui.alert>
    @endif

    <!-- Main Form Card -->
    <x-ui.card>
        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Page Title & Breadcrumb Row -->
            <div class="grid gap-6 md:grid-cols-2">
                <x-ui.form-field label="Page Title" :required="true" :error="$errors->first('page_title')">
                    <x-ui.input type="text" wire:model="page_title" placeholder="Contact Us" />
                </x-ui.form-field>

                <x-ui.form-field label="Breadcrumb Home Label" :required="true" :error="$errors->first('breadcrumb_home_label')">
                    <x-ui.input type="text" wire:model="breadcrumb_home_label" placeholder="Home" />
                </x-ui.form-field>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <x-ui.form-field label="Breadcrumb Current Label" :required="true" :error="$errors->first('breadcrumb_current_label')">
                    <x-ui.input type="text" wire:model="breadcrumb_current_label" placeholder="Contact Us" />
                </x-ui.form-field>

                <x-ui.form-field label="Overlay Opacity (%)" :required="true" :error="$errors->first('overlay_opacity')" hint="0-100">
                    <x-ui.input type="number" wire:model="overlay_opacity" min="0" max="100" />
                </x-ui.form-field>
            </div>

            <!-- Toggles Row -->
            <div class="grid gap-6 md:grid-cols-2">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="is_active" wire:model="is_active" class="h-4 w-4 rounded border-input">
                    <label for="is_active" class="text-sm font-medium">Active</label>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="overlay_enabled" wire:model="overlay_enabled" class="h-4 w-4 rounded border-input">
                    <label for="overlay_enabled" class="text-sm font-medium">Enable Overlay</label>
                </div>
            </div>

            <!-- Background Image Upload -->
            <x-ui.form-field label="Background Image" hint="Recommended: 1920x600, max 10MB. Will be converted to WEBP" :error="$errors->first('background_image')">
                <x-ui.input type="file" wire:model="background_image" accept="image/*" />
                
                @if ($background_image)
                    <div class="mt-4 space-y-2">
                        <p class="text-sm font-medium">Preview:</p>
                        <img src="{{ $background_image->temporaryUrl() }}" class="h-48 w-auto rounded-lg border object-cover" alt="Preview">
                    </div>
                @elseif ($current_background_image)
                    <div class="mt-4 space-y-2">
                        <p class="text-sm font-medium">Current Image:</p>
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/' . $current_background_image) }}" class="h-48 w-auto rounded-lg border object-cover" alt="Current">
                            <x-ui.button type="button" wire:click="deleteImage" variant="destructive" size="sm" class="mt-2"
                                    onclick="return confirm('Are you sure you want to delete this image?')">
                                Delete Image
                            </x-ui.button>
                        </div>
                    </div>
                @endif
            </x-ui.form-field>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4 border-t">
                <x-ui.button type="submit">
                    Save Changes
                </x-ui.button>
                <x-ui.button type="button" variant="outline" onclick="window.history.back()">
                    Cancel
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
