<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold tracking-tight">{{ $event ? 'Edit Event' : 'Create Event' }}</h2>
            <p class="text-muted-foreground mt-1">Event Blog / Details</p>
        </div>
    </div>

    @if (session()->has('error'))
        <x-ui.alert type="error">{{ session('error') }}</x-ui.alert>
    @endif

    <form wire:submit="save" class="space-y-6">
        <x-ui.card title="Event Details">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-ui.form-field label="Title" :required="true" :error="$errors->first('title')">
                    <x-ui.input 
                        type="text" 
                        wire:model="title" 
                        placeholder="Event Title" 
                        required />
                </x-ui.form-field>
                
                <x-ui.form-field label="Slug" :error="$errors->first('slug')">
                    <x-ui.input 
                        type="text" 
                        wire:model="slug" 
                        placeholder="event-slug" />
                </x-ui.form-field>
                
                <div class="md:col-span-2">
                    <x-ui.form-field label="Short Summary" :error="$errors->first('summary')">
                        <x-ui.textarea 
                            wire:model="summary" 
                            rows="2" 
                            placeholder="Optional short summary..." />
                    </x-ui.form-field>
                </div>
                
                <div class="md:col-span-2">
                    <x-ui.form-field 
                        label="Content (TinyMCE)" 
                        :error="$errors->first('content_html')"
                        hint="Rich text supported. Script tags will be removed on save.">
                        <textarea 
                            wire:model="content_html" 
                            id="content_html" 
                            rows="10" 
                            class="flex min-h-[200px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"></textarea>
                    </x-ui.form-field>
                </div>
                
                <x-ui.form-field label="Status">
                    <div class="flex items-center gap-3">
                        <button 
                            type="button" 
                            wire:click="$toggle('is_active')" 
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $is_active ? 'bg-primary' : 'bg-input' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-background transition-transform {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                        <x-ui.badge :variant="$is_active ? 'success' : 'secondary'">
                            {{ $is_active ? 'Active' : 'Inactive' }}
                        </x-ui.badge>
                    </div>
                </x-ui.form-field>
                
                <x-ui.form-field label="Ordering" :error="$errors->first('ordering')">
                    <x-ui.input 
                        type="number" 
                        min="0" 
                        wire:model="ordering" />
                </x-ui.form-field>
            </div>
        </x-ui.card>

        <x-ui.card title="SEO">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-ui.form-field label="Meta Title">
                    <x-ui.input 
                        type="text" 
                        wire:model="meta_title" />
                </x-ui.form-field>
                
                <x-ui.form-field label="Meta Description">
                    <x-ui.input 
                        type="text" 
                        wire:model="meta_description" />
                </x-ui.form-field>
                
                <div class="md:col-span-2">
                    <x-ui.form-field label="Meta Image" :error="$errors->first('meta_image')">
                        @if ($existing_meta_image)
                            <div class="mb-3">
                                <img src="{{ Storage::url($existing_meta_image) }}" alt="Meta" class="h-24 rounded-lg border">
                            </div>
                        @endif
                        <input 
                            type="file" 
                            wire:model="meta_image" 
                            accept=".jpg,.jpeg,.png,.webp" 
                            class="block w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </x-ui.form-field>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card title="Gallery Images">
            <div class="space-y-4">
                <div>
                    <input 
                        type="file" 
                        multiple 
                        wire:model="gallery" 
                        accept=".jpg,.jpeg,.png,.webp" 
                        class="block w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    <p class="mt-2 text-xs text-muted-foreground">Upload multiple images. They will be optimized and resized.</p>
                    @error('gallery.*')
                        <p class="text-sm text-destructive mt-2">{{ $message }}</p>
                    @enderror
                </div>

                @if ($images && $images->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($images as $img)
                            <div class="border rounded-lg p-2 bg-muted/20">
                                <img src="{{ $img->thumb_url }}" alt="thumb" class="w-full h-32 object-cover rounded-lg">
                                <div class="mt-2 flex items-center justify-between gap-2">
                                    <x-ui.button 
                                        type="button" 
                                        size="sm" 
                                        :variant="$event && $event->featured_image_id === $img->id ? 'success' : 'outline'" 
                                        wire:click="setFeatured({{ $img->id }})">
                                        {{ $event && $event->featured_image_id === $img->id ? 'Featured' : 'Set' }}
                                    </x-ui.button>
                                    <x-ui.button 
                                        type="button" 
                                        size="sm" 
                                        variant="destructive" 
                                        wire:click="deleteImage({{ $img->id }})" 
                                        wire:confirm="Delete this image?">
                                        Delete
                                    </x-ui.button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-ui.card>

        <div class="flex items-center justify-end gap-3 pt-4 border-t">
            <x-ui.button type="submit">
                Save Event
            </x-ui.button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#content_html',
            plugins: 'link lists image table code',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code',
            height: 400,
            setup: function (editor) {
                editor.on('change', function () {
                    @this.set('content_html', editor.getContent());
                });
            }
        });
    });
</script>
@endpush
