<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold tracking-tight">FAQ Settings</h2>
        <p class="text-muted-foreground mt-1">Configure FAQ page content settings</p>
    </div>

    @if (session()->has('success'))
        <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <x-ui.card title="FAQ Page Settings" description="Section heading for FAQ display">
            <x-ui.form-field 
                label="Section Heading" 
                :error="$errors->first('section_heading')"
                hint="This heading will appear at the top of the FAQ section">
                <x-ui.input 
                    wire:model="section_heading" 
                    placeholder="e.g., Frequently Asked Questions" />
            </x-ui.form-field>
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
